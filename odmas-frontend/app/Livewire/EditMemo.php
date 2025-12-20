<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class EditMemo extends Component
{
    public $memo = [];
    public $approval_step_id = '';
    public $related_document_request = '';
    public $related_document_approval_step = '';
    public $comment = null;
    public $currentUser = null;
    public $url;
    public $attachedDocuments = [];
    public $employees;

    public function render()
    {
        return view('livewire.edit-memo');
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
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function approvalDelegate(Request $request)
    {
        $validatedData = $request->validate([
            'approval_step_id' => 'required',
            'related_employee' => ['required', 'integer', 'min:1'],
        ]);
    }

    public function mount($id)
    {
        $this->employees = $this->getEmployees();

        if (Session::get('userDetails')) {
            $this->currentUser = Session::get('userDetails');
        } else {
            return redirect()->route('login');
        }
        $jsonData = $this->getMemoById($id);
        if ($jsonData['status'] == 200) {
            $this->memo = $jsonData['data'];
        } elseif ($jsonData['status'] == 404) {
            return redirect()
                ->route('approvals.index')
                ->with('warning', $jsonData['error']);
        } else {
            return redirect()->route('approvals.index')->with('warning', 'Request wasn\'t successful');
        }
        $this->url = 'https://api.odms.savannah.ug';
        $this->attachedDocuments = $this->attachedDocuments($id);

        if ($this->memo) {
            if ($this->memo == 'Error') {
                return redirect()->route('error');
            }
            foreach ($this->memo['approval_steps'] as $approver) {
                if ($approver['next_step']) {
                    $this->approval_step_id = $approver['id'];
                    $this->related_document_request = $approver['related_document_request'];
                    $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
                }
            }
        } else {
            return redirect()
                ->route('approvals.index')
                ->with('warning', $jsonData['error']);
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

    public function approveRequest()
    {
        if ($this->comment) {
            $this->sendAppproval(1);
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

    public function sendAppproval($status)
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
                return redirect()->route('approvals.index');
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getMemoById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/details/' . $id;
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
