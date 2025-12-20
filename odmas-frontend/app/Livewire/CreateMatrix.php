<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CreateMatrix extends Component
{
    public $week_start_date;
    public $week_end_date;
    public $total;
    public $title;
    public $date;
    public $id;
    public $team;
    public $travel_matrix_details = [];
    public $employees = [];
    public $travelReqs;

    public function render()
    {
        return view('livewire.create-matrix');
    }

    public function removeRowToRecordList($Id)
    {
        array_splice($this->travel_matrix_details, $Id, 1);
    }

    public function addRowToRecordList()
    {
        $this->travel_matrix_details[] = [
            'related_travel_request' => $this->id,
            'destination_details' => '',
            'team' => '',
            'driver_or_alternative' => '',
            'remarks' => '',
        ];
    }

    function travelMatrix()
    {
        $jsonData = $this->storeTravelMatrix();
        if ($jsonData) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('travels.index')->with('success', 'Sucessfully created travel request');
            } else {
                if ($jsonData['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $jsonData['error']);
                }
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
    }

    public function mount($id)
    {
        $this->employees = $this->getEmployees();
        $this->id = $id;
    }

    public function getEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/common/employees?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                return $response->json()['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    function storeTravelMatrix()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/travel_matrix';
        $validatedData = $this->validate([
            'week_start_date' => ['required', 'string'],
            'week_end_date' => ['required', 'string'],
        ]);

        if (count($this->travel_matrix_details) > 0) {
            foreach ($this->travel_matrix_details as $index => $fields) {
                $this->validate([
                    'travel_matrix_details.' . $index . '.destination_details' => ['string'],
                    'travel_matrix_details.' . $index . '.team' => ['required', 'string'],
                    'travel_matrix_details.' . $index . '.driver_or_alternative' => ['string'],
                    'travel_matrix_details.' . $index . '.remarks' => ['string'],
                ]);
            }
        }
        $data = [];
        $data['year'] = Carbon::now()->year;
        $data['week_from'] = $validatedData['week_start_date'];
        $data['week_to'] = $validatedData['week_end_date'];
        $data['travel_matrix_details'] = $this->travel_matrix_details;
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

    public function getTraveReqs()
    {
        $projectId = Session::get('projectId');
        if ($projectId) {
            $jsonData = $this->getTravelReq($projectId);
            if ($jsonData) {
                if (!empty($jsonData['data'])) {
                    $this->travelReqs = $jsonData['data'];
                } else {
                    $this->travelReqs = [];
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }
    }

    public function getTravelReq($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/travel_requisition?project_id=' . $projectId . '&status_filter=2';
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

    public function getToken()
    {
        return Session::get('token');
    }
}
