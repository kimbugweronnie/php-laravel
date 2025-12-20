<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ShowActivity extends Component
{
    public $activity = null;
    public $projectId = null;
    public $projects = [];
    // #[Validate('required')]
    public $project_id = '';

    public function mount()
    {
        $this->projects = $this->getProjects();
    }

    public function createTask()
    {
        return redirect()->route('tasks.create');
    }

    public function render()
    {
        return view('livewire.show-activity');
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

    public function getProjectUsers($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/participants?project=' . $id;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
