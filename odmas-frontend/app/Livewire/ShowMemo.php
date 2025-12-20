<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
// use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ShowMemo extends Component
{
    use WithFileUploads;

    public $memo = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = null;
    public $currentUser = null;
    public $attachedDocuments = [];
    public $url;
    public $file;

    public function render()
    {
        return view('livewire.show-memo', [
            'memo' => $this->memo,
        ]);
    }

    public function mount($id)
    {
        $currentUser = Session::get('userDetails');
        if ($currentUser) {
            $this->currentUser = $currentUser;
        } else {
            return redirect()->route('login');
        }
        $this->url = 'https://api.odms.savannah.ug';
        if ($this->getMemoById($id) == null) {
            return redirect()->route('login');
        }
        if ($this->getMemoById($id) == 'Error' || $this->attachedDocuments($id) == 'Error') {
            return redirect()->route('error');
        }
        $jsonData = $this->getMemoById($id);
        if ($jsonData['status'] == 404) {
            return redirect()
                ->route('memos.index')
                ->back()
                ->with('warning', $jsonData['error']);
        }
        if ($jsonData['status'] == 200) {
            $this->memo = $jsonData['data'];
        }
        $this->attachedDocuments = $this->attachedDocuments($id);
        foreach ($this->memo['approval_steps'] as $approver) {
            if ($approver['next_step']) {
                $this->approval_step_id = $approver['id'];
                $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
            }
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

    public function storeDocument()
    {
        $document_upload = $this->attachDocuments();
        if ($document_upload == 'Error') {
            return redirect()->route('error');
        } elseif (isset($document_upload['file_name'][0])) {
            return redirect()
                ->route('memos.show', $this->memo['related_document_request']['id'])
                ->with('error', $document_upload['file_name'][0]);
        } else {
            return redirect()
                ->route('memos.show', $this->memo['related_document_request']['id'])
                ->with('success', $document_upload['data']);
        }
    }

    public function attachDocuments()
    {
        $this->validate([
            'file' => 'mimes:pdf,doc,docx',
        ]);

        $userId = Session::get('userDetails')['id'];
        $accessToken = $this->getToken();
        $url = 'https://api.odms.savannah.ug/api/v1/upload_document/add';
        $data = [];
        $fileName = $this->file->getClientOriginalName();
        $data['file_name'] = $fileName;
        $data['description'] = $this->memo['title'];
        $data['added_by'] = $userId;
        $data['uploaded_document_type'] = 'SUPPORTING DOCUMENTS';
        $data['related_document_request'] = $this->memo['related_document_request']['id'];
        $data['uploaded_document_category'] = 1;
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])
                ->attach('file_path', file_get_contents($this->file->getRealPath()), $this->file->getClientOriginalName())
                ->post($url, $data);
            return $response->json();
        } catch (\Throwable $error) {
            return redirect()->route('error');
        }
    }

    public function isItApproved()
    {
        $approval = end($this->memo['approval_steps']);
        $approval_date = $approval['date_performed'];
        return $approval_date;
    }

    public function approveRequest()
    {
        $approveStatus = 1;
        if ($this->comment) {
            if ($this->sendAppproval($approveStatus) == 'Error') {
                return redirect()->route('error');
            }
            $this->sendAppproval($approveStatus);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function rejectRequest()
    {
        $rejectStatus = 3;
        if ($this->comment) {
            if ($this->sendAppproval($rejectStatus) == 'Error') {
                return redirect()->route('error');
            }
            $this->sendAppproval($rejectStatus);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function sendAppproval($status)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approve';
        $data = [];
        $data['approval_step_id'] = $this->approval_step_id;
        $data['related_document_request'] = $this->memo['related_document_request']['id'];
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
                return redirect()->route('memos.show', $this->memo['related_document_request']['id']);
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
