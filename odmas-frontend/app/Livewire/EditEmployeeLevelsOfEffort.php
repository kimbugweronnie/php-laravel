<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditEmployeeLevelsOfEffort extends Component
{
    public $related_project;
    public $projects_attached = [];
    public $attached_projects = [];
    public $previous_attached = [];
    public $employee = [];
    public $projects = [];
    public $previous_stations = [];
    public $stations = [];

    public function employeeProjectAttachment()
    {
        $jsonData = $this->editEmployeeProjectAttachment();
        if ($jsonData['status'] == 201) {
            return redirect()->route('employees.index')->with('success', 'Successfully updated an employee');
        }
        if ($jsonData['status'] = 400) {
            if (isset($jsonData['error']['username'][0])) {
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']['username'][0]);
            } elseif (isset($jsonData['error']['email'][0])) {
                return redirect()
                    ->back()
                    ->with('warning', $jsonData['error']['email'][0]);
            } elseif (isset($jsonData['error'])) {
                return redirect()
                    ->route('employees.editLevelsOfEffort', $this->employee['id'])
                    ->with('error', $jsonData['error']);
            }
        }
    }

    public function checkLevel()
    {
        $total = 0;
        foreach ($this->previous_attached as $project_attached) {
            $total = intval($total) + intval($project_attached['previous_level_of_effort']);
        }
        if (count($this->projects_attached) > 0) {
            foreach ($this->projects_attached as $project_attached) {
                $total = intval($total) + intval($project_attached['level_of_effort']);
            };
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

    public function editEmployeeProjectAttachment()
    {
        if (count($this->previous_attached) > 0) {
            foreach ($this->previous_attached as $index => $previous_attached) {
                $this->validate([
                    'previous_attached.' . $index . '.previous_related_station' => ['required', 'integer', 'min:1'],
                    'previous_attached.' . $index . '.previous_project_role' => ['required', 'integer', 'min:1'],
                    'previous_attached.' . $index . '.previous_level_of_effort' => ['required', 'integer', 'min:1'],
                    'previous_attached.' . $index . '.related_project' => ['nullable', 'integer', 'min:1'],
                ]);
            }
        }

        if (count($this->projects_attached) > 0) {
            foreach ($this->projects_attached as $index => $projects_attached) {
                $this->validate([
                    'projects_attached.' . $index . '.related_project' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.related_project_role' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.related_station' => ['required', 'integer', 'min:1'],
                    'projects_attached.' . $index . '.level_of_effort' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id=' . $this->employee['id'] . '&method=edit&attribute=projects_attached';
        $data = [];
        $data['projects_attached'] = $this->projects_attached;
        $total = 0;
        if (count($this->previous_attached) > 0) {
            foreach ($this->previous_attached as $index => $previous_attached) {
                array_push($this->projects_attached, [
                    'related_project' => $this->previous_attached[$index]['related_project'],
                    'related_project_role' => $this->previous_attached[$index]['previous_project_role'],
                    'related_station' => $this->previous_attached[$index]['previous_related_station'],
                    'level_of_effort' => $this->previous_attached[$index]['previous_level_of_effort'],
                ]);
            }
        }
        foreach ($data['projects_attached'] as $project_attached) {
            $total = $total + $project_attached['level_of_effort'];
        }
        if ($total > 100 || $total < 100) {
            $jsonData['status'] = 400;
            $jsonData['error'] = 'Please check the total effort attached, Total effort should be equal to 100';
        }

        $data['projects_attached'] = $this->projects_attached;

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

    public function addRowToItemList()
    {
        $this->projects_attached[] = [
            'related_project' => 0,
            'related_project_role' => 0,
            'related_station' => 0,
            'level_of_effort' => 0,
        ];
    }

    

    public function removeRowToItemList($Id)
    {
        array_splice($this->projects_attached, $Id, 1);
    }

    public function removeRowToPreviousItemList($Id)
    {
        array_splice($this->previous_attached, $Id, 1);
    }

    public function mount($id)
    {
        $jsonData = $this->getEmployee($id);
        $this->employee = $jsonData['data'];
        $this->attached_projects = $this->employee['projects_attached'];

        if ($this->employee['projects_attached']) {
            foreach ($this->attached_projects as $value) {
                $this->previous_attached[] = [
                    'related_project' => $value['related_project']['id'],
                    'previous_project_role' => $value['related_project_role']['id'],
                    'previous_related_station' => $value['related_station'],
                    'previous_level_of_effort' => $value['level_of_effort'],
                ];
            }
        }
        $this->projects = $this->getProjects();
        $this->previous_stations = $this->getDepartmenStations();
        $this->stations = $this->getDepartmenStations();
    }

    function getLevelOfEffort($project)
    {
        foreach ($this->previous_attached as $value) {
            if ($value['related_project'] == $project) {
                return $value['level_of_effort'];
            }
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
    function getProjectRoles($key)
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

    function getPreviousRoles($key)
    {
        $project = $this->previous_attached[$key]['related_project'];
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
            return redirect()->route('login');
        }
    }

    public function getStations()
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
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.edit-employee-levels-of-effort');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
