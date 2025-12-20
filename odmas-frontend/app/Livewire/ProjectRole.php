<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ProjectRole extends Component
{
    public $projects = [];
    public $roles = [];
    public $fetchRole;
    public $selectedProject;

    public function mount()
    {
        $this->projects = $this->getProjects();
    }

    public function fetchRoles($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $id;
        $this->roles = $this->getRoles($id);
        if (is_null($this->roles)) {
            return redirect()->back()->with('warning', 'No data found');
        }
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                $this->selectedProject = $jsonData['data'];
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

    public function getRoles($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles?project_id=' . $id;
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
        return view('livewire.project-role');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
