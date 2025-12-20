<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class IndexLeave extends Component
{
   
    public $pendingRequests = [];
    public $approvedRequests = [];
    public $rejectedRequests = [];
    public $pendingClicked = false;
    public $approvedClicked = false;
    public $rejectedClicked = false;
   

    public function mount()
    {
        $this->pendingClicked = true;
        $this->handlePending();
    }

    public function render()
    {
        return view('livewire.index-leave');
    }

    public function handlePending()
    {
        if ($this->approvedClicked) {
            $this->approvedClicked = false;
        }
        if ($this->rejectedClicked) {
            $this->rejectedClicked = false;
        }
        $this->pendingClicked = true;

        $id = Session::get('employee_details')['id'];
        $jsonData = $this->getPendingRequests();
        if ($jsonData) {
            if($jsonData['status'] == 400){
                return redirect()->back()->with('error', $jsonData['error']);
            }
            elseif($jsonData['status'] == 404){
                return redirect()->back()->with('error', $jsonData['error']);
            }
            elseif ($jsonData['status'] == 200) {
                if (!empty($jsonData['data'])) {
                    $this->pendingRequests = $jsonData['data'];
                } else {
                    return redirect()->back()->with('warning', 'Employee hasnt made any leave requests');
                }
            } else {
                return redirect()->back()->with('warning', 'No leave requests for this employee');
            }
        } elseif(empty($jsonData)) {
            return redirect()->back()->with('warning', 'No leave requests for this employee');
        } else {
            return redirect()->back()->with('warning', 'No leave requests for this employee');
        }
       
    }

    public function handleApproved()
    {    
        if($this->pendingClicked) {
            $this->pendingClicked = false;
        }
        if ($this->rejectedClicked) {
            $this->rejectedClicked = false;
        }
        $this->approvedClicked = true;
       
      
        $jsonData = $this->getApprovedRequests();
        $this->approvedRequests = [1];
        // if ($jsonData) {
        //     if($jsonData['status'] == 400){
        //         return redirect()->back()->with('error', $jsonData['error']);
        //     }
        //     elseif($jsonData['status'] == 404){
        //         return redirect()->back()->with('error', $jsonData['error']);
        //     }
        //     elseif ($jsonData['status'] == 200) {
        //         if (!empty($jsonData['data'])) {
        //             $this->approvedRequests = $jsonData['data'];
        //         } else {
        //             return redirect()->back()->with('warning', 'Employee hasnt made any leave requests');
        //         }
        //     } else {
        //         return redirect()->back()->with('warning', 'No leave requests for this employee');
        //     }
        // } elseif(empty($jsonData)) {
        //     return redirect()->back()->with('warning', 'No leave requests for this employee');
        // } else {
        //     return redirect()->back()->with('warning', 'No leave requests for this employee');
        // }

    }

    public function handleRejected()
    {
        if ($this->approvedClicked) {
            $this->approvedClicked = false;
        }
        if ($this->pendingClicked) {
            $this->pendingClicked = false;
        }
        $this->rejectedClicked = true;

        $id = Session::get('employee_details')['id'];
        // $jsonData = $this->getRejectedRequests($id);
        $jsonData = $this->getRejectedRequests();
        $this->rejectedRequests = [1];
        // if ($jsonData) {
        //     if($jsonData['status'] == 400){
        //         return redirect()->back()->with('error', $jsonData['error']);
        //     }
        //     elseif($jsonData['status'] == 404){
        //         return redirect()->back()->with('error', $jsonData['error']);
        //     }
        //     elseif ($jsonData['status'] == 200) {
        //         if (!empty($jsonData['data'])) {
        //             $this->rejectedRequests = $jsonData['data'];
        //         } else {
        //             return redirect()->back()->with('warning', 'Employee hasnt made any leave requests');
        //         }
        //     } else {
        //         return redirect()->back()->with('warning', 'No leave requests for this employee');
        //     }
        // } elseif(empty($jsonData)) {
        //     return redirect()->back()->with('warning', 'No leave requests for this employee');
        // } else {
        //     return redirect()->back()->with('warning', 'No leave requests for this employee');
        // }
       
    }

    public function getPendingRequests() 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/requests/leave_request?user_filter=True&status_filter=1';
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

    public function getApprovedRequests() 
    {
    
         return [];
        // $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id='. $projectId . '&document_domain=' . $this->document_domain;
        // $accessToken = $this->getToken();
        // if ($accessToken) {
        //     try{
        //         $response = Http::withHeaders([
        //             'Authorization' => 'Bearer ' . $accessToken,
        //         ])->get($url);
        //         return $response->json();
        //      } catch (\Throwable $error) {
        //         return 'Error';
        //     }
        // } else {
        //     return;
        // }
    }
    public function getRejectedRequests() 
    {
       
        return [];
        // $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents?project_id='. $projectId . '&document_domain=' . $this->document_domain;
        // $accessToken = $this->getToken();
        // if ($accessToken) {
        //     try{
        //         $response = Http::withHeaders([
        //             'Authorization' => 'Bearer ' . $accessToken,
        //         ])->get($url);
        //         return $response->json();
        //      } catch (\Throwable $error) {
        //         return 'Error';
        //     }
        // } else {
        //     return;
        // }
    }

    

    public function getToken()
    {
        return Session::get('token');
    }


}