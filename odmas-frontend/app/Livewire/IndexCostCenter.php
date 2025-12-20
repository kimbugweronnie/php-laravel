<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class IndexCostCenter extends Component
{
    public $projects = [];
    public $costCenters = [];
    public $project_id = null;

    public function mount()
    {
        $this->projects = $this->getProjects();
        
        $projectId = Session::get('projectId');
        if ($this->project_id) {
            $jsonData = $this->getCostCenters($this->project_id);
            if ($jsonData['status'] == 200) {
                $this->costCenters = $jsonData['data'];
            }
        } elseif (!is_null($projectId)) {
            $jsonData = $this->getCostCenters($projectId);
            if ($jsonData['status'] == 200) {
                $this->costCenters = $jsonData['data'];
            }
        } else {
            return redirect()->back()->with('warning', 'No data found');
        }
    }

    public function render()
    {
        return view('livewire.index-cost-center');
    }

    public function getCostCenters($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/cost_centers?project_id=' . $id;
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

    public function reqByProject()
    {
        if ($this->project_id) {
            Session::put('projectId', $this->project_id);
            $jsonData = $this->getCostCenters($this->project_id);
            if ($jsonData == 'Error') {
                return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            } elseif ($jsonData['status'] == 200) {
                $this->costCenters = $jsonData['data'];
            }
        } else {
            return redirect()->back()->with('error', 'Please select a project');
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

    public function getToken()
    {
        return Session::get('token');
    }
}
