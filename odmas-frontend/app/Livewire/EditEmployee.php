<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditEmployee extends Component
{
    public $related_project;
    public $related_project_role;
    public $related_station;
    public $level_of_effort;
    public $first_name;
    public $last_name;
    public $department_name;
    public $related_role;
    public $gender;
    public $email;
    public $phone_number;
    public $roles = [];
    public $tenant_name;
    public $tenant_address;
    public $projects_attached = [];
    public $employee = [];
    public $projects = [];

    public function employeeDetails()
    {
        $jsonData = $this->editEmployee();
        if ($jsonData['status'] == 200) {
            return redirect()
                ->route('employees.show', $this->employee['id'])
                ->with('success', 'Successfully updated an employee');
        } elseif ($jsonData['status'] == 400) {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        } elseif ($jsonData == 'Error') {
            return redirect()->route('error');
        } elseif ($jsonData == null) {
            return redirect()->route('login');
        } else {
        }
    }

    function editEmployee()
    {
        $validatedData = $this->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable',
            'phone_number' => 'nullable',
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id=' . $this->employee['id'] . '&method=edit&attribute=biodata';
        $data = [];
        $data['first_name'] = $validatedData['first_name'] ? $validatedData['first_name'] : $this->employee['related_user']['first_name'];
        $data['last_name'] = $validatedData['last_name'] ? $validatedData['last_name'] : $this->employee['related_user']['last_name'];
        $data['email'] = $validatedData['email'] ? $validatedData['email'] : $this->employee['related_user']['email'];
        $data['phone_number'] = $validatedData['phone_number'] ? $validatedData['phone_number'] : $this->employee['related_user']['phone_number'];

        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function mount($id)
    {
        if ($this->getEmployee($id) == null || $this->getDepartmentRoles() == null) {
            return redirect()->route('login');
        }
        if ($this->getEmployee($id) == 'Error' || $this->getDepartmentRoles() == 'Error') {
            return redirect()->route('error');
        }
        $jsonData = $this->getEmployee($id);
        $this->employee = $jsonData['data'];
        $this->first_name = $this->employee['related_user']['first_name'];
        $this->last_name = $this->employee['related_user']['last_name'];
        $this->first_name = $this->employee['related_user']['first_name'];
        $this->phone_number = $this->employee['related_user']['phone_number'];
        $this->email = $this->employee['related_user']['email'];
        $this->roles = $this->getDepartmentRoles();
    }

    public function getDepartmentRoles()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles?department_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getEmployee($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id=' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function render()
    {
        return view('livewire.edit-employee', ['employee' => $this->employee]);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
