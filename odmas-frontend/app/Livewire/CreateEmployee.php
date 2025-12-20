<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateEmployee extends Component
{
    public $projects = [];
    public $stations = [];
    public $project_roles = [];
    public $project_percentages = [];
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $phone_number;
    public $password;
    public $related_role;
    public $gender;
    public $roles;
    public $hasDepartmentRole;
    public $related_project;
    public $related_project_role;
    public $related_station;
    public $level_of_effort;
    public $projects_attached = [];
    public $option;
    public $project_option;
    public $has_department_role;

    public function hasProjectRole()
    {
        if ($this->project_option == 'yes') {
            return 'yes';
        }
        if ($this->project_option == 'no') {
            return 'no';
        }
    }

    public function hasRole()
    {
        if ($this->option == 'yes') {
            return 'yes';
        }
        if ($this->option == 'no') {
            return 'no';
        } else {
        }
    }

    public function mount()
    {
        if ($this->getProjects() == 'Error' || $this->getDepartmentRoles() == 'Error' || $this->getDepartmenStations() == 'Error') {
            return redirect()->route('error');
        }
        if ($this->getDepartmentRoles() == null || $this->getProjects() == null || $this->getDepartmenStations() == null) {
            return redirect()->route('error');
        }
        $this->projects = $this->getProjects();
        $this->roles = $this->getDepartmentRoles();
        $this->stations = $this->getDepartmenStations();
    }

    public function checkLevel()
    {
        $total = $this->level_of_effort;

        foreach ($this->projects_attached as $project_attached) {
            $total = intval($total) + intval($project_attached['level_of_effort']);
        }
        if ($total > 100) {
            $balance = $total - 100;
            return 'Levels of Effort are more by ' . $balance;
        }
        if ($total < 100) {
            $balance = 100 - $total;
            return 'Levels of Effort are less by ' . $balance;
        }
        return;
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
            return;
        }
    }

    public function getDepartmenStations()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_stations?tenant_id=1';
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
            return;
        }
    }

    public function addRowToItemList()
    {
        $this->projects_attached[] = [
            'related_project' => 0,
            'related_project_role' => 0,
            'related_station' => 0,
            'level_of_effort' => 0,
        ];
    }

    public function getProjectRoles($key)
    {
        $project = $this->projects_attached[$key]['related_project'];
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles?project_id=' . $project;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 500) {
                    return [];
                } elseif ($jsonData['status'] == 400) {
                    return [];
                } else {
                    return $jsonData['data'];
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getProjects()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
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

    public function getRoles()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles?project_id=' . $this->related_project;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 500) {
                    return [];
                } elseif ($jsonData['status'] == 400) {
                    return [];
                } else {
                    return $jsonData['data'];
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function createEmployee()
    {
        $jsonData = $this->storeEmployee();
        if ($jsonData) {
            if ($jsonData == 'Project must be attached') {
                return redirect()->back()->with('warning', 'Project must be attached');
            } elseif ($jsonData == 'Levels of Effort should be equal to 100') {
                return redirect()->back()->with('warning', 'Levels of Effort should be equal to 100');
            } elseif ($jsonData['status'] == 201) {
                return redirect()->route('employees.index')->with('success', 'Successfully added an employee');
            } elseif ($jsonData['status'] == 400 && $jsonData['error']['username'][0]) {
                $this->projects_attached = [];
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']['username'][0]);
            } elseif ($jsonData['status'] == 400 && $jsonData['error']['email'][0]) {
                $this->projects_attached = [];
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']['email'][0]);
            } elseif ($jsonData['status'] == 400 && $jsonData['error']['phone_number'][0]) {
                $this->projects_attached = [];
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']['phone_number'][0]);
            } elseif ($jsonData['status'] == 400 && $jsonData['error']) {
                $this->projects_attached = [];
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']);
            } else {
                return redirect()->back()->with('warning', "Request wasn't successfully");
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    public function storeEmployee()
    {
        $validatedData = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => ['required', 'string', 'alpha_dash'],
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => 'required',
            'gender' => 'required',
            'option' => ['nullable', 'string'],
            'project_option' => ['nullable', 'string'],
        ]);

        if ($this->project_option == 'yes') {
            $validatedLevelOfEffort = $this->validate([
                'related_project' => ['required', 'integer', 'min:1'],
                'related_project_role' => ['required', 'integer', 'min:1'],
                'related_station' => ['required', 'integer', 'min:1'],
                'level_of_effort' => ['required', 'integer', 'min:1'],
            ]);
        }

        if (count($this->projects_attached) > 0) {
            foreach ($this->projects_attached as $index => $project_attached) {
                $this->validate([
                    'projects_attached.' . $index . '.related_project' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.related_project_role' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.level_of_effort' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.related_station' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        if ($this->option == 'yes') {
            $this->validate([
                'related_role' => ['required', 'integer', 'min:1'],
            ]);
        }

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees';
        $data = [];
        $data['related_tenant'] = 1;
        $data['related_department'] = 1;
        $data['first_name'] = $validatedData['first_name'];
        $data['last_name'] = $validatedData['last_name'];
        $data['username'] = $validatedData['username'];
        $data['email'] = $validatedData['email'];
        $data['phone_number'] = $validatedData['phone_number'];
        $data['password'] = $validatedData['password'];
        $data['gender'] = $validatedData['gender'];
        $data['related_role'] = $this->related_role ? $this->related_role : 0;
        $data['has_department_role'] = $validatedData['option'] == 'yes' ? true : false;

        if ($this->project_option == 'yes') {
            array_push($this->projects_attached, [
                'related_project' => intval($validatedLevelOfEffort['related_project']),
                'related_project_role' => intval($validatedLevelOfEffort['related_project_role']),
                'related_station' => intval($validatedLevelOfEffort['related_station']),
                'level_of_effort' => intval($validatedLevelOfEffort['level_of_effort']),
            ]);
        }
        if (count($this->projects_attached) < 1 && $this->option == 'no') {
            return 'Project must be attached';
        }
        $data['projects_attached'] = $this->projects_attached;
        $total = 0;
        foreach ($data['projects_attached'] as $project_attached) {
            $total = $total + $project_attached['level_of_effort'];
        }
        if ($total < 100 || $total < 100) {
            return 'Levels of Effort should be equal to 100';
        }

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

    public function removeRowToItemList($Id)
    {
        array_splice($this->projects_attached, $Id, 1);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
