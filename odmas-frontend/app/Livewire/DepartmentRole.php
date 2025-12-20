<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class DepartmentRole extends Component
{
    public $departments = [];
    public $department;
    public $roles = [];
    public $fetchRole;

    public function mount()
    {
        $this->departments = $this->getDepartments();
    }

    public function fetchRoles($id)
    {
        $this->roles = $this->getRoles($id);
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
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getRoles($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles?department_id=' . $id;
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

    public function render()
    {
        return view('livewire.department-role');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
