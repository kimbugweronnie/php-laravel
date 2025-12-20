<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditTravelDetail extends Component
{
    public $days = 0;
    public $rate = 0;
    public $travel_sda_rate;
    public $sda_standard_rate = 1000;
    public $travelReq = [];
    public $travel_advance_request_fields = [];
    public $pre_trip_request_fields = [];
    public $total = 0;
    public $estimated_total = 0;
    public $title = '';
    public $date;
    public $id = '';
    public $projectUsers = [];
    public $head_of_section_id = '';
    public $regional_team_lead_id = '';
    public $previous_pre_trip = [];
    public $previous_pre_items = [];
    public $previous_travel_advance = [];
    public $previous_travel_advance_items = [];
    public $previousfinalTotal;
    public $option = '';
    public $sda_rate;
    public $finalTotal;
    public $contigency;
    public $communication = '';
    public $travel_contingency_amount = '';
    public $travel_other_communication = '';
    public $travel_other_communication_ammount = '';

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
            return redirect()->route('login');
        }

        $this->travelReq = $this->getTraveReqById($id);
        $this->previous_pre_trip = $this->travelReq['meta_fields'];
        $this->previous_travel_advance = $this->travelReq['travel_advance_request_fields'];
        $this->title = $this->travelReq['title'];
        $this->date = $this->travelReq['date'];
        $this->travel_other_communication = $this->travelReq['travel_other_communication'];
        $this->travel_contingency_amount = $this->travelReq['travel_contingency_amount'];
        $this->id = $id;
        if ($this->previous_pre_trip) {
            foreach ($this->previous_pre_trip as $value) {
                $this->previous_pre_items[] = [
                    'date_of_travel' => $value['date_of_travel'],
                    'origin_location' => $value['origin_location'],
                    'destination_location' => $value['destination_location'],
                    'transport_mode' => $value['transport_mode'],
                    'time_of_day' => $value['time_of_day'],
                    'number_of_travelers' => $value['number_of_travelers'],
                ];
            }
        }
        if ($this->previous_travel_advance) {
            foreach ($this->previous_travel_advance as $value) {
                $this->previous_travel_advance_items[] = [
                    'name_of_persons' => $value['name_of_persons'],
                    'designation' => $value['designation'],
                    'days' => $value['days'],
                    'rate' => $value['rate'],
                    'total' => $value['total'],
                ];
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.edit-travel-detail');
    }

    public function calculateSubtotal()
    {
        $finalTotal = 0;
        foreach ($this->previous_travel_advance_items as $item) {
            $finalTotal += $item['total'];
        }
        foreach ($this->travel_advance_request_fields as $item) {
            $finalTotal += $item['total'];
        }
        return $finalTotal;
    }

    public function editTravel()
    {
        $jsonData = $this->updateTravel();
        if ($jsonData) {
            if ($jsonData['status'] == 200) {
                return redirect()->route('travels.index')->with('success', 'Sucessfully updated travel request');
            } elseif ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->back()
                    ->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    public function updateTravel()
    {
        $validatedData = $this->validate([
            'title' => ['required', 'string'],
            'date' => ['date', 'required'],
            'head_of_section_id' => ['nullable', 'integer'],
            'regional_team_lead_id' => ['nullable', 'integer'],
            'travel_sda_rate' => ['nullable', 'integer'],
            'travel_other_communication' => ['nullable', 'string'],
            'travel_other_communication_ammount' => ['nullable', 'numeric'],
            'travel_contingency_amount' => ['nullable', 'numeric'],
        ]);

        if ($this->travel_sda_rate) {
            $this->validate(['travel_sda_rate' => ['required', 'min:1']]);
        }

        if ($this->travel_other_communication) {
            $this->validate(['travel_other_communication' => ['required']]);
            // $this->validate([ "travel_other_communication_ammount" => ['required', 'min:1']]);
        }

        if ($this->travel_contingency_amount) {
            $this->validate(['travel_contingency_amount' => ['required', 'min:1']]);
        }
        if (count($this->previous_pre_items) > 0) {
            foreach ($this->previous_pre_items as $index => $fields) {
                $this->validate([
                    'previous_pre_items.' . $index . '.date_of_travel' => ['required', 'date'],
                    'previous_pre_items.' . $index . '.origin_location' => ['required', 'string'],
                    'previous_pre_items.' . $index . '.destination_location' => ['required', 'string'],
                    'previous_pre_items.' . $index . '.transport_mode' => ['required', 'string'],
                    'previous_pre_items.' . $index . '.time_of_day' => ['required', 'date_format:H:i'],
                    'previous_pre_items.' . $index . '.number_of_travelers' => ['required', 'integer', 'min:1'],
                ]);
            }
        }

        if (count($this->previous_travel_advance_items) > 0) {
            foreach ($this->previous_travel_advance_items as $index => $fields) {
                $this->validate([
                    'previous_travel_advance_items.' . $index . '.name_of_persons' => ['required', 'string'],
                    'previous_travel_advance_items.' . $index . '.designation' => ['required', 'string'],
                    'previous_travel_advance_items.' . $index . '.days' => ['numeric', 'min:1'],
                    'previous_travel_advance_items.' . $index . '.rate' => ['numeric', 'min:1'],
                    'previous_travel_advance_items.' . $index . '.total' => ['numeric', 'min:1'],
                ]);
            }
        }

        if (count($this->pre_trip_request_fields) > 0) {
            foreach ($this->pre_trip_request_fields as $index => $fields) {
                $this->validate([
                    'pre_trip_request_fields.' . $index . '.date_of_travel' => ['required', 'date'],
                    'pre_trip_request_fields.' . $index . '.origin_location' => ['required', 'string'],
                    'pre_trip_request_fields.' . $index . '.destination_location' => ['required', 'string'],
                    'pre_trip_request_fields.' . $index . '.transport_mode' => ['required', 'string'],
                    'pre_trip_request_fields.' . $index . '.time_of_day' => ['required', 'date_format:H:i'],
                    'pre_trip_request_fields.' . $index . '.number_of_travelers' => ['required', 'integer', 'min:1'],
                ]);
            }
        }
        if (count($this->travel_advance_request_fields) > 0) {
            foreach ($this->travel_advance_request_fields as $index => $fields) {
                $this->validate([
                    'travel_advance_request_fields.' . $index . '.name_of_persons' => ['required', 'string'],
                    'travel_advance_request_fields.' . $index . '.designation' => ['required', 'string'],
                    'travel_advance_request_fields.' . $index . '.days' => ['numeric', 'min:1'],
                    'travel_advance_request_fields.' . $index . '.rate' => ['numeric', 'min:1'],
                    'travel_advance_request_fields.' . $index . '.total' => ['numeric', 'min:1'],
                ]);
            }
        }

        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/travel_requisition/edit?id=' . $this->travelReq['related_document_request']['id'];
        $data = [];
        $data['title'] = $validatedData['title'] ? $validatedData['title'] : $this->travelReq['title'];
        $data['date'] = $validatedData['date'] ? $validatedData['date'] : $this->travelReq['date'];

        if (count($this->previous_pre_items) > 0) {
            foreach ($this->previous_pre_items as $index => $previous_pre_items) {
                array_push($this->pre_trip_request_fields, [
                    'date_of_travel' => $this->previous_pre_items[$index]['date_of_travel'],
                    'origin_location' => $this->previous_pre_items[$index]['origin_location'],
                    'destination_location' => $this->previous_pre_items[$index]['destination_location'],
                    'transport_mode' => $this->previous_pre_items[$index]['transport_mode'],
                    'time_of_day' => $this->previous_pre_items[$index]['time_of_day'],
                    'number_of_travelers' => $this->previous_pre_items[$index]['number_of_travelers'],
                ]);
            }
        }

        if (count($this->previous_travel_advance_items) > 0) {
            foreach ($this->previous_travel_advance_items as $index => $previous_travel_advance_items) {
                array_push($this->travel_advance_request_fields, [
                    'name_of_persons' => $this->previous_travel_advance_items[$index]['name_of_persons'],
                    'designation' => $this->previous_travel_advance_items[$index]['designation'],
                    'days' => $this->previous_travel_advance_items[$index]['days'],
                    'rate' => $this->previous_travel_advance_items[$index]['rate'],
                    'total' => $this->previous_travel_advance_items[$index]['total'],
                ]);
            }
        }

        $data['pre_trip_request_fields'] = $this->pre_trip_request_fields;
        $data['travel_advance_request_fields'] = $this->travel_advance_request_fields;
        $data['travel_sda_rate'] = $validatedData['travel_sda_rate'];
        $data['travel_other_communication'] = $validatedData['travel_other_communication'];
        $data['travel_other_communication_ammount'] = $validatedData['travel_other_communication_ammount'];
        $data['travel_contingency_amount'] = $validatedData['travel_contingency_amount'];
        $travelTempId = Session::get('travelId');
        $data['related_project_document'] = $travelTempId;

        if ($validatedData['head_of_section_id']) {
            $data['is_head_of_section'] = true;
        } else {
            $data['is_head_of_section'] = false;
        }

        if ($validatedData['regional_team_lead_id']) {
            $data['is_regional_team_lead'] = true;
        } else {
            $data['is_regional_team_lead'] = false;
        }

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

    public function hasContigency()
    {
        if ($this->contigency == 'yes' || $this->travel_contingency_amount) {
            return 'yes';
        }
        if ($this->contigency == 'no') {
            return 'no';
            $this->travel_contingency_amount = '';
        }
    }

    public function hasOtherCommunication()
    {
        if ($this->communication == 'yes' || $this->travel_other_communication) {
            return 'yes';
        }
        if ($this->communication == 'no') {
            return 'no';
            $this->travel_other_communication = '';
        }
    }

    public function removeRowPrevioustripList($Id)
    {
        array_splice($this->previous_pre_items, $Id, 1);
    }

    public function removeRowTotripList($Id)
    {
        array_splice($this->pre_trip_request_fields, $Id, 1);
    }

    public function removeRowToAdvanceList($Id)
    {
        array_splice($this->travel_advance_request_fields, $Id, 1);
    }

    public function removeRowPreviousTravelAdvanceList($Id)
    {
        array_splice($this->previous_travel_advance_items, $Id, 1);
    }

    public function addRowTotripList()
    {
        $this->pre_trip_request_fields[] = [
            'date_of_travel' => '',
            'origin_location' => '',
            'destination_location' => '',
            'transport_mode' => '',
            'time_of_day' => '',
            'number_of_travelers' => 0,
        ];
    }

    public function addRowToAdvanceList()
    {
        $this->travel_advance_request_fields[] = [
            'name_of_persons' => '',
            'designation' => '',
            'days' => 0,
            'rate' => 0,
            'total' => 0,
        ];
    }

    public function calculateTotal()
    {
        $days = $this->days;
        $rate = $this->rate;
        $this->estimated_total = floatval($days) * $rate;
        $this->fetchTotal();
    }

    public function fetchTotal()
    {
        $this->total = $this->estimated_total;
    }

    public function calculateTotalCost($key)
    {
        $days = $this->travel_advance_request_fields[$key]['days'];
        $rate = $this->travel_advance_request_fields[$key]['rate'];
        $this->travel_advance_request_fields[$key]['total'] = floatval($days) * intval($rate);
        $this->getTotal();
    }

    public function calculatePreviousTotal($key)
    {
        $days = $this->previous_travel_advance_items[$key]['days'];
        $rate = $this->previous_travel_advance_items[$key]['rate'];
        $this->previous_travel_advance_items[$key]['total'] = floatval($days) * intval($rate);
        $this->getPreviousTotal();
    }

    public function getPreviousTotal()
    {
        $finalTotal = 0;
        foreach ($this->previous_travel_advance_items as $item) {
            $finalTotal += $item['total'];
        }
        $this->previousfinalTotal = $finalTotal;
    }

    public function getTotal()
    {
        $finalTotal = 0;
        foreach ($this->travel_advance_request_fields as $item) {
            $finalTotal += $item['total'];
        }
        $this->finalTotal = $finalTotal;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
