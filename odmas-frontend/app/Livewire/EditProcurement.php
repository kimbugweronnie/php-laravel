<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditProcurement extends Component
{
    public $procurementReq = [];
    public $url;
    public $attachedDocuments = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $names = '';
    public $total = 0;
    public $delegated_employees;

    public function getProcurementReqById($id)
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
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

    public function mount($id)
    {
        $this->url = 'https://api.odms.savannah.ug';
        $this->delegated_employees = $this->getEmployees();
        $this->attachedDocuments = $this->attachedDocuments($id);
        if ($this->attachedDocuments == 'Error') {
            return redirect()->route('error');
        }
        $this->procurementReq = $this->getProcurementReqById($id);
        if ($this->procurementReq) {
            if ($this->procurementReq == 'Error') {
                return redirect()->route('error');
            }
            foreach ($this->procurementReq['approval_steps'] as $approver) {
                if ($approver['next_step']) {
                    $this->approval_step_id = $approver['id'];
                    $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
                }
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

    public function submitCommit()
    {
        $this->approveRequest();
    }

    public function sendApproval($status)
    {
        if ($this->comment) {
            $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approve';
            $data = [];
            $data['approval_step_id'] = $this->approval_step_id;
            $data['related_document_request'] = $this->procurementReq['related_document_request']['id'];
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
                return;
            }
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function approveRequest()
    {
        if ($this->comment) {
            $this->sendApproval(1);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function ReferBackRequest()
    {
        if ($this->comment) {
            $this->sendApproval(3);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function total()
    {
        foreach ($this->procurementReq['meta_fields'] as $field) {
            $this->total = $this->total + intval($field['estimated_total_cost']);
        }
        return $this->total;
    }

    public function render()
    {
        return view('livewire.edit-procurement', [
            'procurementReq' => $this->procurementReq,
            'total' => $this->total(),
        ]);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
