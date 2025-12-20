<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CreateProjectDocument extends Component
{
    public $related_projects = [];
    public $related_document_types = [];
    public $related_document_domains = [];
    public $related_region_projects = [];
    public $related_approval_steps = [];
    public $related_project;
    public $related_document_type;
    public $related_document_domain;
    public $related_region_project;
    public $employees = [];
    public $document_name = '';
    public $order_number = '';
    public $approval_steps_fields = [];

    public function mount()
    {
        $this->related_projects = $this->getProjects();
        $this->related_document_types = $this->getDocumentTypes();
        $this->related_document_domains = $this->getDocumentDomains();
        $this->related_region_projects = $this->getRegions();
        $this->related_approval_steps = $this->getApprovals();
        $this->employees = $this->getEmployees();
    }

    public function getProjects()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
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

    public function getDocumentTypes()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_types?tenant_id=1';
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

    public function getDocumentDomains()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_domains?tenant_id=1';
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

    public function getApprovals()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_document_approval_steps?tenant_id=1';
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

    public function getRegions()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_stations?tenant_id=1';
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

    public function getEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees?tenant_id=1';
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

    public function render()
    {
        return view('livewire.create-project-document');
    }

    public function addRowToItemList()
    {
        $this->approval_steps_fields[] = [
            'related_approval_step' => 0,
            'related_approver' => 0,
        ];
    }

    public function removeRowToItemList($Id)
    {
        array_splice($this->approval_steps_fields, $Id, 1);
    }

    public function projectDocument()
    {
        $jsonData = $this->storeProjectDocument();
        if ($jsonData['status']) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('projectDocuments.index')->with('success', 'Sucessfully created project  document');
            } elseif ($jsonData['status'] == 404) {
                return redirect()
                    ->route('projectDocuments.create')
                    ->with('error', $jsonData['error']);
            }
        } elseif ($jsonData == 'Error') {
            return redirect()->route('error');
        }
    }

    public function storeProjectDocument()
    {
        $validatedData = $this->validate([
            'related_project' => ['required', 'integer'],
            'related_document_type' => ['required', 'integer'],
            'related_document_domain' => ['required', 'integer'],
            'related_region_project' => ['required', 'integer'],
            'document_name' => ['required', 'string'],
            'order_number' => ['required'],
        ]);

        if (count($this->approval_steps_fields) > 0) {
            foreach ($this->approval_steps_fields as $index => $approval_steps_field) {
                $this->validate([
                    'approval_steps_fields.' . $index . '.related_approval_step' => ['required', 'integer', 'min:1'],
                    'approval_steps_fields.' . $index . '.related_approver' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_documents';
        $data = [];
        $data['related_project'] = $validatedData['related_project'];
        $data['related_document_type'] = $validatedData['related_document_type'];
        $data['related_document_domain'] = $validatedData['related_document_domain'];
        $data['related_region_project'] = $validatedData['related_region_project'];
        $data['document_name'] = $validatedData['document_name'];
        $data['order_number'] = $validatedData['order_number'];
        $data['approval_steps_fields'] = $this->approval_steps_fields;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
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
