<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditEmployeePassword extends Component
{
    public $password;
    public $password_confirmed;
    public $employee = [];

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
            'password' => 'required|min:8',
            'password_confirmed' => 'required|same:password',
        ]);

        $data = [];
        $data['new_password'] = $validatedData['password'];
        $data['confirm_password'] = $validatedData['password_confirmed'];
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id=' . $this->employee['id'] . '&method=edit&attribute=password';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function mount($id)
    {
        $jsonData = $this->getEmployee($id);
        $this->employee = $jsonData['data'];
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.edit-employee-password');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
