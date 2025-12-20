<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditTravel extends Component
{
    public $travelReq = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $total = 0;
    public $url = '';
    public $days = 0;
    public $rates = 0;
    public $attachedDocuments = [];
    public $employees;
    public $delegated_employees;

    public function getTraveReqById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/details/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                }
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1';
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

    public function isItApproved()
    {
        $approval = end($this->travelReq['approval_steps']);
        $approval_date = $approval['date_performed'];
        return $approval_date;
    }

    public function attachedDocuments($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/list?category=project_request_document&id=' . $id . '&search=false&status_filter=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getProject($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json()['data']['project_number'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function approveRequest()
    {
        if ($this->comment) {
            $this->sendAppproval(1);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function sendAppproval($status)
    {
        if ($this->comment) {
            $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approve';
            $data = [];
            $data['approval_step_id'] = $this->approval_step_id;
            $data['related_document_request'] = $this->travelReq['related_document_request']['id'];
            $data['related_document_approval_step'] = $this->related_document_approval_step;
            $data['status'] = $status;
            $data['comment'] = $this->comment;
            $accessToken = $this->getToken();
            if ($accessToken) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                    ])->post($url, $data);
                    $jsonData = $response->json();
                    if ($jsonData['status'] == 404) {
                        session()->flash('error', $jsonData['error']);
                    }
                    $this->comment = '';
                    return redirect()->route('approvals.index');
                } catch (\Throwable $error) {
                    return redirect()->route('error');
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function ReferBackRequest()
    {
        if ($this->comment) {
            $this->sendAppproval(3);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function total()
    {
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->total = $this->total + $field['total'];
        }
        return $this->total;
    }

    public function employees()
    {
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->employees = count($this->travelReq['travel_advance_request_fields']);
        }
        return $this->employees;
    }

    public function days()
    {
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->days = $this->days + $field['days'];
        }
        return $this->days;
    }

    public function rates()
    {
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->rates = $this->rates + $field['rate'];
        }
        return $this->rates;
    }

    public function mount($id)
    {
        $this->travelReq = $this->getTraveReqById($id);
        $this->employees = $this->getEmployees();
        $this->delegated_employees = $this->getEmployees();
        $this->url = 'https://api.odms.savannah.ug';
        $this->attachedDocuments = $this->attachedDocuments($id);
        if ($this->travelReq) {
            foreach ($this->travelReq['approval_steps'] as $approver) {
                if ($approver['next_step']) {
                    $this->approval_step_id = $approver['id'];
                    $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.edit-travel', [
            'total' => $this->total(),
            'days' => $this->days(),
            'employees' => $this->employees(),
            'rates' => $this->rates(),
        ]);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
