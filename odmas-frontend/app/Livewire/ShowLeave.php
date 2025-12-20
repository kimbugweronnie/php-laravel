<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ShowLeave extends Component
{
    use WithFileUploads;

    public $leave = [];
    public $currentUser = [];
    public $attachedDocuments = [];
    public $url;
    public $file;
    public $profile;

    public function render()
    {
        return view('livewire.show-leave');
    }

    public function mount($id)
    {
        $this->url = 'https://api.odms.savannah.ug';
        $this->attachedDocuments = $this->attachedDocuments($id);
        $this->leave = $this->getLeaveById($id);
        $this->profile = Session::get('employee_details')['related_role'];
        $this->currentUser = Session::get('userDetails');
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
