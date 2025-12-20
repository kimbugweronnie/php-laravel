<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Session;

class EditLeave extends Component
{
    public $leave = [];
    public $url;
    public $attachedDocuments = [];
    public $currentUser;
    public $approval_step_id = '';
    public $related_document_request = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $profile;

    public function render()
    {
        return view('livewire.edit-leave');
    }

    public function mount($id)
    {
        $this->url = 'https://api.odms.savannah.ug';
        $this->leave = $this->getLeaveById($id);
        foreach ($this->leave['approval_steps'] as $approver) {
            if ($approver['next_step']) {
                $this->approval_step_id = $approver['id'];
                $this->related_document_request = $approver['related_document_request'];
                $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
            }
        }
        $this->profile = Session::get('employee_details')['related_role'];
        $this->currentUser = Session::get('userDetails');
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
            $this->sendAppproval(3);
        } else {
            session()->flash('error', 'Please write a comment.');
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

    public function sendApproval($status)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approve';
        $data = [];
        $data['approval_step_id'] = $this->approval_step_id;
        $data['related_document_request'] = $this->related_document_request;
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
                if ($jsonData['status'] == 200) {
                    return redirect()->route('approvals.index');
                }
            } catch (\Throwable $error) {
                return redirect()->status('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getLeaveById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/requests/leave_request/details/' . $id;
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
    public function getToken()
    {
        return Session::get('token');
    }
}
