<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Http;

class CreateProcurement extends Component
{
    use WithFileUploads;

    public $title;
    public $location_for_delivery;
    public $description;
    public $cost_center = '';
    public $project_id = '';
    public $quantity = 0;
    public $unit_of_measure;
    public $estimated_unit_cost = 0;
    public $estimated_total_cost = 0;
    public $date;
    public $related_project_document;
    public $related_activity;
    public $procurementTempId;
    public $activities = [];
    public $cost_centers = [];
    public $projects = [];
    public $project;
    public $currencies = [];
    public $projectUsers = [];
    public $head_of_section_id = '';
    public $regional_team_lead_id = '';
    public $currency = '';
    public $meta_fields = [];
    public $total_amount = 0;
    public $related_currency;
    public $finalTotal;
    public $tempId = '';
    public $temp = '';
    public $total;
    public $projectHeadOfSections = [];

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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function mount()
    {
        if (Session::get('projectId')) {
            $this->project_id = Session::get('projectId');
            $this->cost_centers = $this->getCostCenters($this->project_id);
        } else {
            return redirect()->back()->with('warning', 'Please select project to proceed');
        }

        $this->projects = $this->getProjects();
        $this->activities = $this->getActivities();
        $this->currencies = $this->getCurrencies();
        $jsonData = $this->getProjectUsers();
        $jsonDataHeadOfSections = $this->getHeadOfSections();
        $this->procurementTempId = Session::get('procurementId');

        if ($this->procurementTempId) {
            $jsonDataTemp = $this->getTemp($this->procurementTempId);
            if ($jsonDataTemp) {
                if ($jsonDataTemp == 'Error') {
                    return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                } elseif ($jsonDataTemp['status'] == 400) {
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
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
                return redirect()->route('error');
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
                return redirect()->route('error');
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

    public function calculateSubtotal()
    {
        $finalTotal = 0;
        $finalTotal = $finalTotal + $this->estimated_total_cost;
        foreach ($this->meta_fields as $item) {
            $finalTotal += $item['estimated_total_cost'];
        }
        return $finalTotal;
    }

    public function calculateTotal()
    {
        $quantity = $this->quantity;
        $estimated_unit_cost = $this->estimated_unit_cost;
        $this->estimated_total_cost = $quantity * $estimated_unit_cost;
        $this->fetchTotal();
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

    public function removeRowToItemList($Id)
    {
        array_splice($this->meta_fields, $Id, 1);
    }

    public function render()
    {
        return view('livewire.create-procurement');
    }

    public function procurementRequest()
    {
        $jsonData = $this->storeProcurement();
        if ($jsonData) {
            if ($jsonData['status']) {
                if ($jsonData['status'] == 201) {
                    return redirect()->route('procurements.index')->with('success', 'Sucessfully created procurement request');
                } elseif ($jsonData['status'] == 400) {
                    if ($jsonData['error']) {
                        return redirect()
                            ->route('procurements.create')
                            ->with('error', $jsonData['error']);
                    }
                }
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    public function storeProcurement()
    {
        $validatedData = $this->validate([
            'title' => ['required', 'string'],
            'location_for_delivery' => ['required', 'string'],
            'related_activity' => ['required', 'integer'],
            'head_of_section_id' => ['nullable', 'integer'],
            'regional_team_lead_id' => ['nullable', 'integer'],
            'cost_center' => ['required', 'integer'],
            'date' => ['required'],
            'description' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_of_measure' => ['required', 'string'],
            'estimated_unit_cost' => ['required', 'integer', 'min:1'],
            'estimated_total_cost' => ['required', 'integer', 'min:1'],
            'related_currency' => ['required', 'integer'],
        ]);
        if (count($this->meta_fields) > 0) {
            foreach ($this->meta_fields as $index => $meta_field) {
                $this->validate([
                    'meta_fields.' . $index . '.description' => ['required', 'string'],
                    'meta_fields.' . $index . '.quantity' => ['required', 'integer', 'min:1'],
                    'meta_fields.' . $index . '.unit_of_measure' => ['required', 'string', 'min:1'],
                    'meta_fields.' . $index . '.estimated_unit_cost' => ['required', 'integer', 'min:1'],
                    'meta_fields.' . $index . '.estimated_total_cost' => ['required', 'integer', 'min:1'],
                ]);
            }
        }
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/procurement_requisition';
        $data = [];
        $data['title'] = $validatedData['title'];
        $data['location_for_delivery'] = $validatedData['location_for_delivery'];
        $data['related_project_document'] = $this->procurementTempId;
        $data['related_activity'] = $validatedData['related_activity'];
        $data['head_of_section_id'] = $validatedData['head_of_section_id'];
        $data['regional_team_lead_id'] = $validatedData['regional_team_lead_id'];
        $data['cost_center'] = $validatedData['cost_center'];
        $data['date'] = $validatedData['date'];
        $data['currency_id'] = $validatedData['related_currency'];
        array_push($this->meta_fields, [
            'description' => $validatedData['description'],
            'quantity' => $validatedData['quantity'],
            'unit_of_measure' => $validatedData['unit_of_measure'],
            'estimated_unit_cost' => $validatedData['estimated_unit_cost'],
            'estimated_total_cost' => $validatedData['estimated_total_cost'],
        ]);
        if ($validatedData['head_of_section_id']) {
            $data['is_head_of_section'] = true;
            $data['head_of_section_id'] = $validatedData['head_of_section_id'];
        } else {
            $data['is_head_of_section'] = false;
            $data['head_of_section_id'] = 0;
        }

        if ($validatedData['regional_team_lead_id']) {
            $data['is_regional_team_lead'] = true;
            $data['regional_team_lead_id'] = $validatedData['regional_team_lead_id'];
        } else {
            $data['is_regional_team_lead'] = false;
            $data['regional_team_lead_id'] = 0;
        }
        $data['meta_fields'] = $this->meta_fields;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
