<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditProjectDocument extends Component
{
    // public $projects = [];
    // public $memoClicked = false;
    // public $procurementClicked = false;
    // public $paymentClicked = false;
    // public $travelClicked = false;
    // public $project_id = '';
    // public $memoTypes = [];
    // public $procurementTypes = [];
    // public $paymentTypes = [];
    // public $travelTypes = [];
    // public $memo_domain = 'MEMO';
    // public $procurement_domain = 'PROCUREMENT';
    // public $payment_domain = 'PAYMENT';
    // public $travel_domain = 'TRANSPORT';
    public $related_approval_steps = [];
    public $related_approval_step;
    public $related_approver;
    public $projectDocumentTemp = [];
    public $employees = [];
    public $previous_approval_steps = [];
    public $document_name;
    public $order_number;

    public function mount($id)
    {
        if ($this->getEmployees() == 'Error' || $this->getApprovals() == 'Error') {
            return redirect()->route('error');
        }
        $this->projectDocumentTemp = $this->getProjectDocumentTempById($id);
        $this->document_name = $this->projectDocumentTemp['document_name'];
        $this->order_number = $this->projectDocumentTemp['order_number'];
        $this->related_approval_steps = $this->getApprovals();
        $this->employees = $this->getEmployees();
        if ($this->projectDocumentTemp['approval_steps']) {
            foreach ($this->projectDocumentTemp['approval_steps'] as $value) {
                $this->previous_approval_steps[] = [
                    'related_approval_step' => $value['related_approval_step']['id'],
                    'related_approver' => $value['related_approver']['id'],
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.edit-project-document');
    }

    // To be added on the frontend
    public function editProjDocApprovalSteps()
    {
        $jsonData = $this->storeProjectDocument();
        if ($jsonData['status']) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('projectDocuments.index')->with('success', 'Sucessfully created project  document');
            } elseif ($jsonData['status'] == 404) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            }
        } elseif ($jsonData == 'Error') {
            return redirect()->route('error');
        }
    }
    // To be updated on submission
    public function storeProjectDocument()
    {
        $validatedData = $this->validate([
            'document_name' => ['required', 'string'],
            'order_number' => ['required', 'integer'],
        ]);

        if (count($this->previous_approval_steps) > 0) {
            foreach ($this->previous_approval_steps as $index => $approval_steps_field) {
                $this->validate([
                    'previous_approval_steps.' . $index . '.related_approval_step' => ['required', 'integer', 'min:1'],
                    'previous_approval_steps.' . $index . '.related_approver' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_documents';
        $data = [];

        $data['related_project'] = $this->projectDocumentTemp['related_project']['id'];
        $data['related_document_type'] = $this->projectDocumentTemp['document_type']['id'];
        $data['related_document_domain'] = $this->projectDocumentTemp['document_domain']['id'];
        $data['related_region_project'] = $this->projectDocumentTemp['related_region_project']['id'];
        $data['document_name'] = $validatedData['document_name'];
        $data['order_number'] = $validatedData['order_number'];
        $data['approval_steps_fields'] = $this->previous_approval_steps;

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

    public function getProjectDocumentTempById($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents/' . $id;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
