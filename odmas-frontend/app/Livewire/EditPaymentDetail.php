<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditPaymentDetail extends Component
{
    public $paymentReq = [];
    public $currencies = [];
    public $centers = [];
    public $activities = [];
    public $meta_fields = [];
    public $previous_items_attached = [];
    public $total;
    public $total_amount;
    public $estimated_total;
    public $projectUsers = [];
    public $head_of_section_id;
    public $regional_team_lead_id;
    public $title;
    public $date;
    public $previous_center;
    public $center;
    public $related_activity;
    public $previous_actvity;
    public $previous_budget_category;
    public $previous_currency;
    public $currency;
    public $previous_meta_fields;

    public function mount($id)
    {
        $jsonData = $this->getProjectUsers();
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
            return redirect()->back()->with('warning', 'Unable to edit payment');
        }

        $this->currencies = $this->getCurrencies();
        $this->centers = $this->getCostCenters();
        $this->activities = $this->getActivities();
        $this->paymentReq = $this->getPaymentReqById($id);
        $this->date = $this->paymentReq['date'];
        $this->title = $this->paymentReq['title'];
        $this->previous_center = $this->paymentReq['cost_center'];
        $this->previous_currency = $this->paymentReq['currency_id'];
        $this->previous_actvity = $this->paymentReq['related_activity'];
        $this->previous_meta_fields = $this->paymentReq['meta_fields'];

        if ($this->previous_meta_fields) {
            foreach ($this->previous_meta_fields as $value) {
                $this->previous_items_attached[] = [
                    'budget_code' => $value['budget_code'],
                    'description' => $value['description'],
                    'amount' => $value['amount'],
                    'date' => $value['date'],
                ];
            }
        }
        if (count($this->previous_items_attached) > 0) {
            foreach ($this->previous_items_attached as $previous_item_attached) {
                if (!empty($previous_item_attached['amount'])) {
                    $this->total_amount = $this->total_amount + $previous_item_attached['amount'];
                }
            }
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

    public function getCostCenters()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/cost_centers?project_id=1';
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

    public function editPayment()
    {
        $jsonData = $this->updatePayment();
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 200) {
                return redirect()
                    ->route('payments.show', $this->paymentReq['related_document_request']['id'])
                    ->with('success', 'Sucessfully updated payment request');
            } elseif ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->route('payments.create')
                    ->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function updatePayment()
    {
        $validatedData = $this->validate([
            'date' => ['required', 'date'],
            'title' => ['required', 'string'],
            'center' => ['nullable', 'integer', 'min:1'],
            'related_activity' => ['nullable', 'integer', 'min:1'],
            'currency' => ['nullable', 'integer', 'min:1'],
        ]);
        if (count($this->previous_items_attached) > 0) {
            foreach ($this->previous_items_attached as $index => $previous_items_attached) {
                $this->validate([
                    'previous_items_attached.' . $index . '.budget_code' => ['required', 'string'],
                    'previous_items_attached.' . $index . '.description' => ['required', 'string'],
                    'previous_items_attached.' . $index . '.date' => ['required', 'date'],
                ]);
            }
        }
        if (count($this->meta_fields) > 0) {
            foreach ($this->meta_fields as $index => $fields) {
                $this->validate([
                    'meta_fields.' . $index . '.budget_code' => ['required', 'string'],
                    'meta_fields.' . $index . '.description' => ['required', 'string'],
                    'meta_fields.' . $index . '.amount' => ['required', 'numeric', 'min:1'],
                    'meta_fields.' . $index . '.date' => ['required', 'date', 'min:1'],
                ]);
            }
        }

        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/payment_requisition/edit?id=' . $this->paymentReq['related_document_request']['id'];
        $data = [];
        $data['title'] = $validatedData['title'] ? $validatedData['title'] : $this->paymentReq['title'];
        $data['date'] = $validatedData['date'] ? $validatedData['date'] : $this->paymentReq['date'];
        $data['center'] = $validatedData['center'] ? $validatedData['center'] : $this->paymentReq['cost_center']['id'];
        $data['related_activity'] = $validatedData['related_activity'] ? $validatedData['related_activity'] : $this->paymentReq['related_activity']['id'];
        $data['currency'] = $validatedData['currency'] ? $validatedData['currency'] : $this->paymentReq['currency_id'];
        $data['total_amount'] = $this->total_amount ? $this->total_amount : $this->paymentReq['total'];

        if (count($this->previous_items_attached) > 0) {
            foreach ($this->previous_items_attached as $index => $previous_items_attached) {
                array_push($this->meta_fields, [
                    'budget_code' => $this->previous_items_attached[$index]['budget_code'],
                    'description' => $this->previous_items_attached[$index]['description'],
                    'amount' => $this->previous_items_attached[$index]['amount'],
                    'date' => $this->previous_items_attached[$index]['date'],
                ]);
            }
        }
        $data['meta_fields'] = count($this->meta_fields) > 0 ? $this->meta_fields : $this->paymentReq['meta_fields'];
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

    public function render()
    {
        return view('livewire.edit-payment-detail');
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

    public function removeRowPreviousItemList($Id)
    {
        array_splice($this->previous_items_attached, $Id, 1);
        $this->sumTotal();
    }

    protected function sumTotal()
    {
        $subTotal = 0;
        if (count($this->previous_items_attached) > 0) {
            foreach ($this->previous_items_attached as $previous_item_attached) {
                if (!empty($previous_item_attached['amount'])) {
                    $subTotal = $subTotal + $previous_item_attached['amount'];
                }
            }
        }
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
