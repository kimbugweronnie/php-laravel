<?php

namespace App\Livewire;

use Session;
use Livewire\Component;

use Illuminate\Support\Facades\Http;

class CreateProjectRole extends Component
{
    public $projectroles = [];
    public $projects = [];
    public $related_project;
    public $role_name;
    public $reports_to;

    public function render()
    {
        return view('livewire.create-project-role');
    }

    public function mount()
    {
        if (is_null($this->getProjects())) {
            return redirect()->route('login');
        } elseif ($this->getProjects() == 'Error') {
            return redirect()->route('error');
        }
        $this->projects = $this->getProjects();
    }

    public function createProjectRole()
    {
        $jsonData = $this->storeRole();
        if ($jsonData == 'Error') {
            return redirect()->route('error');
        } elseif ($jsonData == null) {
            return redirect()->route('login');
        } elseif ($jsonData['status'] == 200) {
            return redirect()->route('projectRoles.index')->with('success', 'Successfully added a project role');
        } else {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        }
    }

    public function storeRole()
    {
        $validatedData = $this->validate([
            'related_project' => ['required', 'integer', 'min:1'],
            'role_name' => 'required',
        ]);

        $userDetails = null;
        if (Session::get('userDetails')) {
            $userDetails = Session::get('userDetails');
        } else {
            return redirect()->route('login');
        }
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles';
        $data = [];
        $data['related_project'] = $validatedData['related_project'];
        $data['role_name'] = $validatedData['role_name'];
        $data['reports_to'] = $this->reports_to;
        $data['added_by'] = $userDetails['id'];
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

    public function getProjects()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
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

    public function getToken()
    {
        return Session::get('token');
    }
}
