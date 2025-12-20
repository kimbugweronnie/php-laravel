<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class IndexTravel extends Component
{
    public $projects = [];
    public $travelTypes = [];
    public $travelReqs = [];
    public $matrices = [];
    public $project_id = '';
    public $tempClicked = false;
    public $reqClicked = false;
    public $matrixClicked = false;
    public $unAuthStatus = true;
    public $authStatus = false;
    public $rejectStatus = false;
    public $document_domain = 'TRANSPORT';

    public function mount()
    {
        $this->tempClicked = true;
        $projects = $this->getProjects();
        if($projects == 'Error'){
            return redirect()->route('error');
        }
        elseif (is_null($projects)) {
            return redirect()->route('login');
        }
        $this->projects = $projects;
        $projectId = Session::get('projectId');
        if ($projectId) { 
            $this->project_id = $projectId;
           $this->handleTemplate();
        }else{
            return redirect()->back()->with('warning','Select A Project'); 
        }
    }

    public function getProjects()
    {
        $id = Session::get('employee_details')['id'];
        $url = 'https://api.odms.savannah.ug/api/v1/projects/participants/attached_projects?employee_id='. $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return  'Error';
            }
        } else {
             return;
        }
    }

    public function authorized()
    {
        $this->unAuthStatus = false;
        $this->authStatus = true;
        $this->rejectStatus = false;
        $projectId = Session::get('projectId');
        if ($projectId) { 
            $jsonData = $this->getTravelReqs($projectId, $authStatus = 2);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
            if($jsonData == 'Error'){
                return redirect()->route('error');
            }
            elseif ($jsonData == null) {
                return redirect()->route('login');
            }
            if (!empty($jsonData['data'])) {
                $this->travelReqs = $jsonData['data'];
            } else {
                $this->travelReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif(empty($jsonData)) {
            return redirect()->back()->with('warning', 'No data available');
        } else {
             return redirect()->back()->with('error', 'Select a project');
        }
    }

    public function unAuthorized()
    {
        $this->unAuthStatus = true;
        $this->authStatus = false;
        $this->rejectStatus = false;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getTravelReqs($projectId, $unAuthStatus = 1);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
            if($jsonData == 'Error'){
                return redirect()->route('error');
            }
            elseif ($jsonData == null) {
                return redirect()->route('login');
            }
            elseif (!empty($jsonData['data'])) {
                $this->travelReqs = $jsonData['data'];
            } else {
                $this->travelReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif(empty($jsonData)) {
            return redirect()->back()->with('warning', 'No data available');
        } else {
            return redirect()->back()->with('error', 'Select a project');
        }
    }

    public function rejected()
    {
        $this->unAuthStatus = false;
        $this->authStatus = false;
        $this->rejectStatus = true;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getTravelReqs($projectId, $rejected = 3);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
             if($jsonData == 'Error'){
                return redirect()->route('error');
            }
            elseif ($jsonData == null) {
               return redirect()->route('login');
            }
            elseif (!empty($jsonData['data'])) {
                $this->travelReqs = $jsonData['data'];
            } else {
                $this->travelReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif(empty($jsonData)) {
            return redirect()->back()->with('warning', 'No data available');
        } else {
            return redirect()->back()->with('error', 'Select a project');
        }
    }

    public function render()
    {
        return view('livewire.index-travel');
    }

    public function handleTemplate()
    {
        if ($this->reqClicked) {
            $this->reqClicked = false;
        }
        if ($this->matrixClicked) {
            $this->matrixClicked = false;
        }
        $this->tempClicked = true;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getTravelTemps($projectId);
            if ($jsonData) {
                if($jsonData == 'Error'){
                   return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                }
                elseif($jsonData['status'] == 400){
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif($jsonData['status'] == 404){
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->travelTypes = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Select a project');
                }
            } elseif(empty($jsonData)) {
                return redirect()->back()->with('warning', 'No data available');
            } else {
               return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function handleMatrix()
    {    
        if($this->tempClicked) {
            $this->tempClicked = false;
        }
        if ($this->reqClicked) {
            $this->reqClicked = false;
        }
        $this->matrixClicked = true;
        $year = Carbon::now()->year;
        $jsonData = $this->getTravelMatrices($year = $year);
        if ($jsonData) {
            if($jsonData == 'Error'){
                return redirect()->route('error');
            }
            elseif($jsonData['status'] == 400){
                return redirect()->back()->with('error', $jsonData['error']);
            }
            elseif($jsonData['status'] == 404){
                return redirect()->back()->with('error', $jsonData['error']);
            }
            elseif($jsonData['status'] == 500){
                return redirect()->back()->with('warning', 'No data available');
            }
            elseif ($jsonData['status'] == 200) {
                if (!empty($jsonData['data'])) {
                    $this->matrices = $jsonData['data'];
                } else {
                    return redirect()->back()->with('warning', 'No data available');
                }
            } else {
                return redirect()->back()->with('warning', 'Select a project');
            }
        } elseif(empty($jsonData)) {
            return redirect()->back()->with('warning', 'No data available');
        } else {
            return redirect()->back()->with('warning', 'No data available');
        }

    }

    public function getTravelMatrices($year = 2024)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/travel_matrix?year='. $year;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function handleRequest()
    {
        if ($this->tempClicked) {
            $this->tempClicked = false;
        }
        $this->reqClicked = true;
        $this->unAuthorized();
        if ($this->matrixClicked) {
            $this->matrixClicked = false;
        }
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getTravelReqs($projectId, $unAuthorized = 1);
            if ($jsonData) {
                if($jsonData == 'Error'){
                   return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif($jsonData['status'] == 400){
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif($jsonData['status'] == 404){
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->travelReqs = $jsonData['data'];
                    }
                } else {
                    return redirect()->back()->with('warning', 'Select a project');
                }
            } else {
                return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function reqByProject()
    {
        if ($this->project_id) {
            Session::put('projectId', $this->project_id);
            if ($this->tempClicked) {
                 $jsonData = $this->getTravelTemps($this->project_id);
                if ($jsonData == 'Error') {
                    return redirect()->route('error');
                }
                elseif($jsonData['status'] == 400) {
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->travelTypes = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } elseif($this->reqClicked) {
                $jsonData = $this->getTravelReqs($this->project_id);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                }
                elseif($jsonData['status'] == 400) {
                    return redirect()->back()->with('error', $jsonData['error']);
                }
                elseif($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->travelReqs = $jsonData['data'];
                    } else {
                            return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } 
        }else{
            return redirect()->back()->with('warning', 'Select A Project A');
        }
    }

    public function createTravelType($id)
    {
        Session::put('travelId', $id); 
        return redirect()->route('travels.create');
    }

    public function getTravelTemps($projectId) 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id='. $projectId . '&document_domain=' . $this->document_domain;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function getTravelReqs($projectId, $statusFilter = 2) 
    { 
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/travel_requisition?project_id='. $projectId .'&user_filter=True&status_filter=' . $statusFilter;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
                // dd($response->json());
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}