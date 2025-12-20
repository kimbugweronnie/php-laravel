<?php

namespace App\Livewire;

use Session;
use Livewire\Component;

use Illuminate\Support\Facades\Http;

class CreateDepartmentRole extends Component
{
    public $departments = [];
    public $department;
    public $role_name = '';
    public $reports_to;

    public function render()
    {
        return view('livewire.create-department-role');
    }

    public function mount()
    {
        $this->departments = $this->getDepartments();
    }

    public function createRole()
    {
        $jsonData = $this->storeRole();
        if ($jsonData) {
            if ($jsonData['status'] == 200) {
                return redirect()->route('departmentRoles.index')->with('success', 'Successfully added a role');
            } else {
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']);
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    function storeRole()
    {
        $validatedData = $this->validate([
            'role_name' => ['required', 'string'],
            'department' => ['required', 'integer', 'min:1'],
            'reports_to' => ['required', 'integer', 'min:1'],
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles';
        $data = [];
        $data['related_tenant'] = 1;
        $data['related_department'] = $validatedData['department'];
        $data['role_name'] = $validatedData['role_name'];
        $data['reports_to'] = $validatedData['reports_to'];
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

    public function getRoles()
    {
        $roles = $this->getDepartmentRoles();
        return $roles;
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getDepartments()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json()['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
