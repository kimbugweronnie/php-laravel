<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ShowPayment extends Component
{
    use WithFileUploads;

    public $paymentReq = [];
    public $attachedDocuments = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $url;
    public $file;

    public function mount($id)
    {
        $this->url = 'https://api.odms.savannah.ug';
        $this->attachedDocuments = $this->attachedDocuments($id);
        $jsonData = $this->getPaymentReqById($id);
        if ($jsonData['status'] == 200) {
            $this->paymentReq = $jsonData['data'];
        }
        if ($jsonData['status'] == 404) {
            return redirect()
                ->route('payments.index')
                ->with('warning', $jsonData['error']);
        }

        if (!is_null($this->paymentReq)) {
            foreach ($this->paymentReq['approval_steps'] as $approver) {
                if ($approver['next_step']) {
                    $this->approval_step_id = $approver['id'];
                    $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
                }
            }
        }
    }

    public function isItApproved()
    {
        $approval = end($this->paymentReq['approval_steps']);
        $approval_date = $approval['date_performed'];
        return $approval_date;
    }

    public function render()
    {
        return view('livewire.show-payment');
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
                ->route('payments.show', $this->paymentReq['related_document_request']['id'])
                ->with('error', $document_upload['file_name'][0]);
        } else {
            return redirect()
                ->route('payments.show', $this->paymentReq['related_document_request']['id'])
                ->with('success', $document_upload['data']);
        }
    }

    // Get payment request by id
    public function getPaymentReqById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/details/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData;
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getTotal($id)
    {
        $total = 0;
        $jsonData = $this->getPaymentReqById($id);
        if ($jsonData['status'] == 200) {
            $payment = $jsonData['data'];
        }
        if ($jsonData['status'] == 404) {
            return redirect()
                ->route('payments.index')
                ->with('warning', $jsonData['error']);
        }
        foreach ($payment['meta_fields'] as $field) {
            $total = $total + $field['amount'];
        }
        return $total;
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
        $data['description'] = $this->paymentReq['title'];
        $data['added_by'] = $userId;
        $data['uploaded_document_type'] = 'SUPPORTING DOCUMENTS';
        $data['related_document_request'] = $this->paymentReq['related_document_request']['id'];
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

    public function getToken()
    {
        return Session::get('token');
    }
}
