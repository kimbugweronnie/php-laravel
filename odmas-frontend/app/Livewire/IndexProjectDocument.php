<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class IndexProjectDocument extends Component
{
    public $projects = [];
    public $memoClicked = false;
    public $procurementClicked = false;
    public $paymentClicked = false;
    public $travelClicked = false;
    public $project_id = '';
    public $memoTypes = [];
    public $procurementTypes = [];
    public $paymentTypes = [];
    public $travelTypes = [];
    public $memo_domain = 'MEMO';
    public $procurement_domain = 'PROCUREMENT';
    public $payment_domain = 'PAYMENT';
    public $travel_domain = 'TRANSPORT';

    public function mount()
    {
        $this->memoClicked = true;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $this->project_id = $projectId;
            $this->handleMemo();
        }
        if ($this->getProjects() == 'Error') {
            return redirect()->route('error');
        } else {
            $this->projects = $this->getProjects();
        }
    }

    public function render()
    {
        return view('livewire.index-project-document');
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

    public function reqByProject()
    {
        if ($this->project_id) {
            Session::put('projectId', $this->project_id);
            $projectId = Session::get('projectId');
            if ($this->procurementClicked) {
                $jsonData = $this->getProcurementTemps($projectId);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->procurementTypes = $jsonData['data'];
                    } else {
                        $this->procurementTypes = [];
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } elseif ($this->paymentClicked) {
                $jsonData = $this->getPaymentTemps($projectId);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->paymentTypes = $jsonData['data'];
                    } else {
                        $this->paymentTypes = [];
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } elseif ($this->travelClicked) {
                $jsonData = $this->getTravelTemps($projectId);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->travelTypes = $jsonData['data'];
                    } else {
                        $this->travelTypes = [];
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            } elseif ($this->memoClicked) {
                $jsonData = $this->getMemoTypes($projectId);
                if ($jsonData == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                } elseif ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $this->memoTypes = $jsonData['data'];
                    } else {
                        $this->memoTypes = [];
                        return redirect()->back()->with('warning', 'No data available');
                    }
                }
            }
        } else {
            return redirect()->back()->with('error', 'Please select a project');
        }
    }

    public function handleMemo()
    {
        if ($this->procurementClicked) {
            $this->procurementClicked = false;
        }
        if ($this->paymentClicked) {
            $this->paymentClicked = false;
        }
        if ($this->travelClicked) {
            $this->travelClicked = false;
        }
        $this->memoClicked = true;
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getMemoTypes($projectId);
            if ($jsonData == 'Error') {
                return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            } elseif ($jsonData['status'] == 200) {
                if (!empty($jsonData['data'])) {
                    $this->memoTypes = $jsonData['data'];
                } else {
                    $this->memoTypes = [];
                    return redirect()->back()->with('warning', 'No data available');
                }
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function handleProcurement()
    {
        if ($this->memoClicked) {
            $this->memoClicked = false;
        }
        if ($this->paymentClicked) {
            $this->paymentClicked = false;
        }
        if ($this->travelClicked) {
            $this->travelClicked = false;
        }
        $this->procurementClicked = true;
        $projectId = Session::get('projectId');
        $jsonData = $this->getProcurementTemps($projectId);
        if ($jsonData == 'Error') {
            return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
        } elseif ($jsonData['status'] == 400) {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        } elseif ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $this->procurementTypes = $jsonData['data'];
            } else {
                $this->procurementTypes = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        }
    }

    public function handlePayment()
    {
        if ($this->memoClicked) {
            $this->memoClicked = false;
        }
        if ($this->procurementClicked) {
            $this->procurementClicked = false;
        }
        if ($this->travelClicked) {
            $this->travelClicked = false;
        }
        $this->paymentClicked = true;
        $projectId = Session::get('projectId');
        $jsonData = $this->getPaymentTemps($projectId);
        if ($jsonData == 'Error') {
            return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
        } elseif ($jsonData['status'] == 400) {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        } elseif ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $this->memoTypes = $jsonData['data'];
            } else {
                $this->memoTypes = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        }
    }

    public function handleTravel()
    {
        if ($this->memoClicked) {
            $this->memoClicked = false;
        }
        if ($this->procurementClicked) {
            $this->procurementClicked = false;
        }
        if ($this->paymentClicked) {
            $this->paymentClicked = false;
        }
        $this->travelClicked = true;
        $projectId = Session::get('projectId');
        $jsonData = $this->getTravelTemps($projectId);
        if ($jsonData == 'Error') {
            return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
        } elseif ($jsonData['status'] == 400) {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        } elseif ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $this->travelTypes = $jsonData['data'];
            } else {
                $this->travelTypes = [];
                return redirect()->back()->with('warning', 'No data available');
            }
        }
    }

    public function getMemoTypes($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id=' . $projectId . '&document_domain=' . $this->memo_domain;
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

    public function getProcurementTemps($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id=' . $projectId . '&document_domain=' . $this->procurement_domain;
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

    public function getPaymentTemps($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id=' . $projectId . '&document_domain=' . $this->payment_domain;
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

    public function getTravelTemps($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id=' . $projectId . '&document_domain=' . $this->travel_domain;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
