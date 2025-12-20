<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ShowTravelMatrix extends Component
{
    public $days;
    public $rate;
    public $total;
    public $title;
    public $date;
    public $date_of_travel;
    public $origin_location;
    public $destination_location;
    public $transport_mode;
    public $number_of_travelers;
    public $time_of_day;
    public $name_of_persons;
    public $designation;
    public $estimated_total = 0;
    public $travel_advance_request_fields = [];
    public $pre_trip_request_fields = [];

    public function render()
    {
        return view('livewire.create-travel');
    }

    public function travelRequest()
    {
        $jsonData = $this->storeTravel();
        if ($jsonData) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('travels.index')->with('success', 'Sucessfully created travel request');
            } else {
                if ($jsonData['status'] == 400) {
                    return redirect()
                        ->route('travels.create')
                        ->with('error', $jsonData['error']);
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function storeTravel()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/travel_requisition';
        $data = [];
        $data['title'] = $this->title;
        $data['date'] = $this->date;
        $data['related_project_document'] = 4;
        $data['rate'] = $this->rate;
        $data['total'] = $this->total;
        $data['name_of_persons'] = $this->name_of_persons;
        $data['designation'] = $this->designation;
        array_push($this->pre_trip_request_fields, [
            'date_of_travel' => $this->date_of_travel,
            'origin_location' => $this->origin_location,
            'destination_location' => $this->destination_location,
            'transport_mode' => $this->transport_mode,
            'time_of_day' => $this->time_of_day,
            'number_of_travelers' => $this->number_of_travelers,
        ]);
        $data['pre_trip_request_fields'] = $this->pre_trip_request_fields;
        array_push($this->travel_advance_request_fields, [
            'name_of_persons' => $this->name_of_persons,
            'designation' => $this->designation,
            'days' => $this->days,
            'rate' => $this->rate,
            'total' => $this->total,
        ]);
        $data['travel_advance_request_fields'] = $this->travel_advance_request_fields;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url, $data);
            return $response->json();
        } else {
            return redirect()->route('login');
        }
    }

    public function mount()
    {
    }

    public function removeRowTotripList($Id)
    {
        array_splice($this->pre_trip_request_fields, $Id, 1);
    }
    public function removeRowToAdvanceList($Id)
    {
        array_splice($this->travel_advance_request_fields, $Id, 1);
    }

    function calculateTotal()
    {
        $days = $this->days;
        $rate = $this->rate;
        $this->estimated_total = $days * $rate;
        $this->fetchTotal();
    }

    function fetchTotal()
    {
        $this->total = $this->estimated_total;
    }

    public function calculateTotalCost($key)
    {
        $days = $this->travel_advance_request_fields[$key]['days'];
        $rate = $this->travel_advance_request_fields[$key]['rate'];
        $this->travel_advance_request_fields[$key]['total'] = $days * $rate;
        $this->getTotal();
    }

    public function getTotal()
    {
        $finalTotal = 0;
        foreach ($this->travel_advance_request_fields as $item) {
            $finalTotal += $item['total'];
        }
        $this->finalTotal = $finalTotal;
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

    public function getToken()
    {
        return Session::get('token');
    }
}
