<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreatePayment extends Component
{
    public $title = '';
    public $budget_category = '';
    public $cost_center = '';
    public $project_id = '';
    public $related_activity = '';
    public $payment_date = '';
    public $total_amount = 0;
    public $paymentTempId;
    public $projectUsers = [];
    public $head_of_section_id;
    public $regional_team_lead_id;
    public $cost_centers = [];
    public $meta_fields = [];
    public $activities = [];
    public $currencies = [];
    public $currency = '';
    public $tempId = '';
    public $temp = '';
    public $projectHeadOfSections = [];

    public function mount()
    {
        if (Session::get('paymentId') || Session::get('projectId')) {
            $this->paymentTempId = Session::get('paymentId');
            $this->project_id = Session::get('projectId');
            $jsonData = $this->getProjectUsers();
            $jsonDataHeadOfSections = $this->getHeadOfSections();
            $this->activities = $this->getActivities();
            $this->cost_centers = $this->getCostCenters($this->project_id);
            $this->currencies = $this->getCurrencies();

            if ($this->paymentTempId) {
                $jsonDataTemp = $this->getTemp($this->paymentTempId);
                if ($jsonDataTemp) {
                    if ($jsonDataTemp['status'] == 400) {
                        return redirect()
                            ->back()
                            ->with('error', $jsonDataTemp['error']);
                    } elseif ($jsonDataTemp['status'] == 404) {
                        return redirect()
                            ->back()
                            ->with('error', $jsonDataTemp['error']);
                    } elseif ($jsonDataTemp['status'] == 200) {
                        if (!empty($jsonDataTemp['data'])) {
                            $this->temp = $jsonDataTemp['data'];
                        } else {
                            return redirect()->back()->with('warning', 'No data available');
                        }
                    } else {
                        return redirect()->back()->with('warning', 'Select a project');
                    }
                } elseif (empty($jsonDataTemp)) {
                    return redirect()->back()->with('warning', 'No data available');
                } else {
                    return redirect()->back()->with('warning', 'No data available');
                }
            } else {
                return redirect()->back()->with('warning', 'Select a project');
            }

            if ($jsonData) {
                if ($jsonData == 'Error') {
                    return redirect()->route('error');
                } elseif ($jsonData['status'] == 200) {
                    $this->projectUsers = $jsonData['data'];
                } elseif ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                }
            } else {
                return redirect()->route('login');
            }

            if ($jsonDataHeadOfSections) {
                if ($jsonDataHeadOfSections == 'Error') {
                    return redirect()->route('error');
                } elseif ($jsonDataHeadOfSections['status'] == 200) {
                    $this->projectHeadOfSections = $jsonDataHeadOfSections['data'];
                } elseif ($jsonDataHeadOfSections['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonDataHeadOfSections['error']);
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->back()->with('error', 'Please select project or payment template to proceed');
        }
    }

    public function getTemp($tempId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents/' . $tempId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getHeadOfSections()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1&head_of_section=True';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getProjectUsers()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getCurrencies()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/currency_settings?tenant_id=1';
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

    public function addRowToItemList()
    {
        $this->meta_fields[] = [
            'date' => '',
            'budget_code' => '',
            'description' => '',
            'amount' => '',
        ];
        $this->sumTotal();
    }

    public function removeRowToItemList($Id)
    {
        array_splice($this->meta_fields, $Id, 1);
        $this->sumTotal();
    }

    protected function sumTotal()
    {
        $subTotal = 0;
        if (count($this->meta_fields) > 0) {
            foreach ($this->meta_fields as $meta_field) {
                if (!empty($meta_field['amount'])) {
                    $subTotal = $subTotal + $meta_field['amount'];
                }
            }
        }
        $this->total_amount = $subTotal;
    }

    public function getFinalTotal()
    {
        $this->sumTotal();
    }

    public function paymentRequest()
    {
        $jsonData = $this->storePayment();
        if ($jsonData) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('payments.index')->with('success', 'Sucessfully created payment request');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->route('payments.create')
                    ->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    public function getActivities()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/list?search=false';
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

    public function getCostCenters($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/cost_centers?project_id=' . $id;
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
        return view('livewire.create-payment');
    }

    public function storePayment()
    {
        $validated = $this->validate([
            'payment_date' => ['required', 'date'],
            'title' => ['required', 'string'],
            'budget_category' => ['required', 'string'],
            'cost_center' => ['required', 'integer'],
            'head_of_section_id' => ['nullable', 'integer'],
            'regional_team_lead_id' => ['nullable', 'integer'],
            'related_activity' => ['required', 'integer'],
            'total_amount' => 'required',
            'currency' => ['required', 'integer'],
        ]);

        if (count($this->meta_fields) > 0) {
            foreach ($this->meta_fields as $index => $fields) {
                $this->validate([
                    'meta_fields.' . $index . '.date' => ['required', 'date'],
                    'meta_fields.' . $index . '.budget_code' => ['required', 'string'],
                    'meta_fields.' . $index . '.description' => ['required', 'string'],
                    'meta_fields.' . $index . '.amount' => ['required', 'integer', 'min:1'],
                ]);
            }
        }
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/payment_requisition';
        $data = [];
        $data['related_project_document'] = $this->paymentTempId;
        $data['title'] = $validated['title'];
        $data['budget_category'] = $validated['budget_category'];
        $data['cost_center'] = $validated['cost_center'];
        $data['head_of_section_id'] = $validated['head_of_section_id'];
        $data['regional_team_lead_id'] = $validated['regional_team_lead_id'];
        $data['related_activity'] = $validated['related_activity'];
        $data['total_amount'] = $validated['total_amount'];
        $data['date'] = $validated['payment_date'];
        $data['currency_id'] = $validated['currency'];
        if ($validated['head_of_section_id']) {
            $data['is_head_of_section'] = true;
            $data['head_of_section_id'] = $validated['head_of_section_id'];
        } else {
            $data['is_head_of_section'] = false;
            $data['head_of_section_id'] = 0;
        }

        if ($validated['regional_team_lead_id']) {
            $data['is_regional_team_lead'] = true;
            $data['regional_team_lead_id'] = $validated['regional_team_lead_id'];
        } else {
            $data['is_regional_team_lead'] = false;
            $data['regional_team_lead_id'] = 0;
        }
        $data['meta_fields'] = $this->meta_fields;
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
