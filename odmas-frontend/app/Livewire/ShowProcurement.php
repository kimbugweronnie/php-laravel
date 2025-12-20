<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ShowProcurement extends Component
{
    use WithFileUploads;

    public $procurementReq = [];
    public $url;
    public $attachedDocuments = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $names = '';
    public $total = 0;
    public $yourId;
    public $file;

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

    public function mount($id)
    {
        $this->procurementReq = $this->getProcurementReqById($id);
        $this->url = 'https://api.odms.savannah.ug';
        $this->attachedDocuments = $this->attachedDocuments($id);
        if ($this->attachedDocuments == 'Error') {
            return redirect()->route('error');
        }
        if (!is_null($this->procurementReq)) {
            if ($this->procurementReq == 'Error') {
                return redirect()->route('error');
            }
        } else {
            foreach ($this->procurementReq['approval_steps'] as $approver) {
                if ($approver['next_step']) {
                    $this->approval_step_id = $approver['id'];
                    $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
                }
            }
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
        }
        if (isset($document_upload['file_name'][0])) {
            return redirect()
                ->route('procurements.show', $this->procurementReq['related_document_request']['id'])
                ->with('error', $document_upload['file_name'][0]);
        } else {
            return redirect()
                ->route('procurements.show', $this->procurementReq['related_document_request']['id'])
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
        $data['description'] = $this->procurementReq['title'];
        $data['added_by'] = $userId;
        $data['uploaded_document_type'] = 'SUPPORTING DOCUMENTS';
        $data['related_document_request'] = $this->procurementReq['related_document_request']['id'];
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
        $approval = end($this->procurementReq['approval_steps']);
        $approval_date = $approval['date_performed'];
        return $approval_date;
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
        return view('livewire.show-procurement', [
            'total' => $this->total(),
        ]);
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
