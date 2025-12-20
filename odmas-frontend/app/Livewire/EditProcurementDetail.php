<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditProcurementDetail extends Component
{
    public $procurementReq = [];
    public $meta_fields = [];
    public $currencies = [];
    public $projects = [];
    public $activities = [];
    public $centers = [];
    public $title;
    public $date;
    public $related_currency;
    public $project;
    public $related_activity;
    public $cost_center;
    public $location_for_delivery;
    public $projectUsers = [];
    public $head_of_section_id;
    public $id;
    public $quantity;
    public $estimated_unit_cost;
    public $previous_meta_fields = [];
    public $previous_attached = [];
    public $total;

    public function mount($id)
    {
        $this->procurementReq = $this->getProcurementReqById($id);
        $this->previous_meta_fields = $this->procurementReq['meta_fields'];
        $this->projectUsers = $this->getProjectUsers();

        if ($this->procurementReq['meta_fields']) {
            foreach ($this->previous_meta_fields as $value) {
                $this->previous_attached[] = [
                    'quantity' => $value['quantity'],
                    'description' => $value['description'],
                    'unit_of_measure' => $value['unit_of_measure'],
                    'estimated_unit_cost' => $value['estimated_unit_cost'],
                    'estimated_total_cost' => $value['estimated_total_cost'],
                ];
            }
        }

        $this->title = $this->procurementReq['title'];
        $this->date = $this->procurementReq['date'];
        $this->related_currency = $this->procurementReq['currency_id'];
        $this->related_activity = $this->procurementReq['related_activity'];
        $this->cost_center = $this->procurementReq['cost_center'];
        $this->location_for_delivery = $this->procurementReq['location_for_delivery'];
        $this->currencies = $this->getCurrencies();
        $this->projects = $this->getProjects();
        $this->activities = $this->getActivities();
        $this->centers = $this->getCostCenters();
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
                if ($jsonData['status'] == 200) {
                    return $jsonData['data'];
                } else {
                    return redirect()->back();
                }
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function calculateSubtotal()
    {
        $finalTotal = 0;
        foreach ($this->previous_attached as $item) {
            $finalTotal += $item['estimated_total_cost'];
        }
        foreach ($this->meta_fields as $item) {
            $finalTotal += $item['estimated_total_cost'];
        }
        return $finalTotal;
    }

    public function render()
    {
        return view('livewire.edit-procurement-detail');
    }

    public function editProcurement()
    {
        if (date('l', strtotime($this->date)) === 'Saturday' || date('l', strtotime($this->date)) === 'Sunday') {
            return redirect()->back()->with('warning', 'Unable to create procurement request on a weekend');
        }
        $jsonData = $this->updateProcurement();
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 200) {
                return redirect()
                    ->route('procurements.show', $this->procurementReq['related_document_request']['id'])
                    ->with('success', 'Sucessfully updated procurement request');
            } elseif ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
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

    public function updateProcurement()
    {
        $validatedData = $this->validate([
            'title' => ['required', 'string'],
            'location_for_delivery' => ['string', 'required'],
            'date' => ['required', 'date'],
            'related_currency' => ['nullable'],
            'related_activity' => ['nullable'],
            'head_of_section_id' => ['nullable', 'integer'],
            'cost_center' => ['nullable'],
        ]);

        if (count($this->previous_attached) > 0) {
            foreach ($this->previous_attached as $index => $previous_attached) {
                $this->validate([
                    'previous_attached.' . $index . '.description' => ['required', 'string'],
                    'previous_attached.' . $index . '.quantity' => ['required', 'integer', 'min:1'],
                    'previous_attached.' . $index . '.unit_of_measure' => ['required', 'string'],
                    'previous_attached.' . $index . '.estimated_unit_cost' => ['required', 'numeric', 'min:1'],
                    'previous_attached.' . $index . '.estimated_total_cost' => ['required', 'numeric', 'min:1'],
                ]);
            }
        }
        if (count($this->meta_fields) > 0) {
            foreach ($this->meta_fields as $index => $fields) {
                $this->meta_fields[$index]['budget_code'] = null;
                $this->validate([
                    'meta_fields.' . $index . '.description' => ['required', 'string'],
                    'meta_fields.' . $index . '.quantity' => ['numeric', 'min:1'],
                    'meta_fields.' . $index . '.unit_of_measure' => ['required', 'string'],
                    'meta_fields.' . $index . '.estimated_unit_cost' => ['required', 'numeric', 'min:1'],
                    'meta_fields.' . $index . '.estimated_total_cost' => ['required', 'numeric', 'min:1'],
                ]);
            }
        }
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/procurement_requisition/edit?id=' . $this->procurementReq['related_document_request']['id'];
        $data = [];
        $data['title'] = $validatedData['title'] ? $validatedData['title'] : $this->procurementReq['title'];
        $data['location_for_delivery'] = $validatedData['location_for_delivery'] ? $validatedData['location_for_delivery'] : $this->procurementReq['location_for_delivery'];
        $data['date'] = $validatedData['date'] ? $validatedData['date'] : $this->procurementReq['date'];
        $data['related_currency'] = $validatedData['related_currency'] ? $validatedData['related_currency'] : $this->procurementReq['currency_id'];
        $data['related_activity'] = $validatedData['related_activity'] ? $validatedData['related_activity']['id'] : $this->procurementReq['related_activity']['id'];
        $data['head_of_section_id'] = $validatedData['head_of_section_id'];
        $data['cost_center'] = $validatedData['cost_center'] ? $validatedData['cost_center']['id'] : $this->procurementReq['cost_center']['id'];
        if (count($this->previous_attached) > 0) {
            foreach ($this->previous_attached as $index => $previous_attached) {
                array_push($this->meta_fields, [
                    'description' => $this->previous_attached[$index]['description'],
                    'quantity' => $this->previous_attached[$index]['quantity'],
                    'unit_of_measure' => $this->previous_attached[$index]['unit_of_measure'],
                    'estimated_unit_cost' => $this->previous_attached[$index]['estimated_unit_cost'],
                    'estimated_total_cost' => $this->previous_attached[$index]['estimated_total_cost'],
                ]);
            }
        }
        $data['meta_fields'] = count($this->meta_fields) > 0 ? $this->meta_fields : $this->procurementReq['meta_fields'];
        $data['is_head_of_section'] = true;
        $data['total_amount'] = $this->getFinalTotal();
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

    public function addRowToItemList()
    {
        $this->meta_fields[] = [
            'description' => '',
            'quantity' => 0,
            'unit_of_measure' => '',
            'estimated_unit_cost' => 0,
            'estimated_total_cost' => 0,
        ];
    }

    public function calculateTotal($key)
    {
        $quantity = $this->previous_attached[$key]['quantity'];
        $estimatedUnitCost = $this->previous_attached[$key]['estimated_unit_cost'];
        $this->previous_attached[$key]['estimated_total_cost'] = $quantity * $estimatedUnitCost;
    }

    public function fetchTotal()
    {
        $this->total = $this->estimated_total_cost;
    }

    public function calculateTotalCost($key)
    {
        $quantity = $this->meta_fields[$key]['quantity'];
        $estimatedUnitCost = $this->meta_fields[$key]['estimated_unit_cost'];
        $this->meta_fields[$key]['estimated_total_cost'] = $quantity * $estimatedUnitCost;
        $this->getFinalTotal();
    }

    public function getFinalTotal()
    {
        $finalTotal = 0;
        foreach ($this->meta_fields as $item) {
            $finalTotal += $item['estimated_total_cost'];
        }
        return $finalTotal;
    }

    public function getPreviousFinalTotal()
    {
        $finalTotal = 0;
        foreach ($this->previous_attached as $item) {
            $finalTotal += $item['estimated_total_cost'];
        }
        return $finalTotal;
    }

    public function removeRowToItemList($Id)
    {
        array_splice($this->meta_fields, $Id, 1);
    }

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

    public function getToken()
    {
        return Session::get('token');
    }
}
