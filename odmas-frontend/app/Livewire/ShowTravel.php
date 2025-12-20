<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class ShowTravel extends Component
{
    use WithFileUploads;

    public $travelReq = [];
    public $attachedDocuments = [];
    public $approval_step_id = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $subTotal = 0;
    public $employees = 0;
    public $days = 0;
    public $rates = 0;
    public $url;
    public $isItApproved;
    public $file;

    public function mount($id)
    {
        $this->url = 'https://api.odms.savannah.ug';

        $this->attachedDocuments = $this->attachedDocuments($id);
        $this->travelReq = $this->getTraveReqById($id);
    }

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

    public function employees()
    {
        $employees = 0;
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->employees = count($this->travelReq['travel_advance_request_fields']);
        }
        return $this->employees;
    }

    public function days()
    {
        $days = 0;
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->days = $this->days + $field['days'];
        }
        return $this->days;
    }

    public function rates()
    {
        $rates = 0;
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->rates = $this->rates + $field['rate'];
        }
        return $this->rates;
    }

    public function total()
    {
        foreach ($this->travelReq['travel_advance_request_fields'] as $field) {
            $this->subTotal = $this->subTotal + $field['total'];
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

        if (isset($document_upload['file_name'][0])) {
            return redirect()
                ->route('travels.show', $this->travelReq['related_document_request']['id'])
                ->with('error', $document_upload['file_name'][0]);
        } else {
            return redirect()
                ->route('travels.show', $this->travelReq['related_document_request']['id'])
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
        $data['description'] = $this->travelReq['title'];
        $data['added_by'] = $userId;
        $data['uploaded_document_type'] = 'SUPPORTING DOCUMENTS';
        $data['related_document_request'] = $this->travelReq['related_document_request']['id'];
        $data['uploaded_document_category'] = 1;
        $accessToken = $this->getToken();
        if ($accessToken) {
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
        } else {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.show-travel', [
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
