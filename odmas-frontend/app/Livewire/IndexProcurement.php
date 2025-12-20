<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;

class IndexProcurement extends Component
{
    public $projects = [];
    public $procurementTypes = [];
    public $procurementReqs = [];
    public $project_id = '';
    public $tempClicked = false;
    public $reqClicked = false;
    public $unAuthStatus = true;
    public $authStatus = false;
    public $rejectStatus = false;
    public $document_domain = 'PROCUREMENT';

    public function mount()
    {
        $this->tempClicked = true;
        $projects = $this->getProjects();
        if ($projects == 'Error') {
            return redirect()->route('error');
        } elseif (is_null($projects)) {
            return redirect()->route('login');
        }
        $this->projects = $projects;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $this->project_id = $projectId;
            $this->handleTemplate();
        } else {
            return redirect()->back()->with('warning', 'Select A Project');
        }
    }

    public function render()
    {
        return view('livewire.index-procurement');
    }

    public function getProjects()
    {
        $id = Session::get('employee_details')['id'];
        $url = 'https://api.odms.savannah.ug/api/v1/projects/participants/attached_projects?employee_id=' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function createProcurementType($id)
    {
        Session::put('procurementId', $id);
        return redirect()->route('procurements.create');
    }

    public function reqByProject()
    {
        if ($this->project_id) {
            Session::put('projectId', $this->project_id);
            if ($this->tempClicked) {
                $jsonData = $this->getProcurementTemps($this->project_id);
                if ($jsonData == 'Error') {
                    return redirect()->route('error');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->procurementTypes = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } elseif ($this->reqClicked) {
                $jsonData = $this->getProcurementReqs($this->project_id);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->procurementReqs = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', 'Select A Project');
        }
    }

    public function handleTemplate()
    {
        if ($this->reqClicked) {
            $this->reqClicked = false;
        }
        $this->tempClicked = true;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getProcurementTemps($projectId);
            if ($jsonData) {
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 404) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->procurementTypes = $jsonData['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Select a project');
                }
            } elseif (empty($jsonData)) {
                return redirect()->back()->with('warning', 'No data available');
            } else {
                return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function handleRequest()
    {
        if ($this->tempClicked) {
            $this->tempClicked = false;
        }
        $this->reqClicked = true;
        $this->unAuthorized();
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getProcurementReqs($projectId, $unAuthorized = 1);
            if ($jsonData == 'Error') {
                return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            } elseif ($jsonData['status'] == 404) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            } elseif ($jsonData['status'] == 200) {
                if (!empty($jsonData['data'])) {
                    $this->procurementReqs = $jsonData['data'];
                }
            } else {
                return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function authorized()
    {
        $this->unAuthStatus = false;
        $this->authStatus = true;
        $this->rejectStatus = false;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getProcurementReqs($projectId, $authStatus = 2);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData == null) {
                return redirect()->route('login');
            }
            if (!empty($jsonData['data'])) {
                $this->procurementReqs = $jsonData['data'];
            } else {
                $this->procurementReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif (empty($jsonData)) {
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
            $jsonData = $this->getProcurementReqs($projectId, $unAuthStatus = 1);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData == null) {
                return redirect()->route('login');
            } elseif (!empty($jsonData['data'])) {
                $this->procurementReqs = $jsonData['data'];
            } else {
                $this->procurementReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif (empty($jsonData)) {
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
            $jsonData = $this->getProcurementReqs($projectId, $rejected = 3);
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData == null) {
                return redirect()->route('login');
            } elseif (!empty($jsonData['data'])) {
                $this->procurementReqs = $jsonData['data'];
            } else {
                $this->procurementReqs = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        } elseif (empty($jsonData)) {
            return redirect()->back()->with('warning', 'No data available');
        } else {
            return redirect()->back()->with('error', 'Select a project');
        }
    }

    public function getProcurementTemps($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id=' . $projectId . '&document_domain=' . $this->document_domain;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
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

    public function getProcurementReqs($projectId, $statusFilter = 2)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/procurement_requisition?project_id=' . $projectId . '&user_filter=True&status_filter=' . $statusFilter;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
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

    public function getToken()
    {
        return Session::get('token');
    }
}
