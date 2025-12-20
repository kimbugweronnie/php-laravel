<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateTravel extends Component
{
    public $days = 0;
    public $rate = 0;
    public $travel_sda_rate = 0;
    public $total = 0;
    public $title = '';
    public $description = '';
    public $date = '';
    public $date_of_travel = '';
    public $origin_location = '';
    public $destination_location = '';
    public $transport_mode = '';
    public $number_of_travelers = '';
    public $time_of_day = '';
    public $name_of_persons = '';
    public $designation = '';
    public $estimated_total = 0;
    public $projectUsers = [];
    public $head_of_section_id = '';
    public $regional_team_lead_id = '';
    public $travel_advance_request_fields = [];
    public $pre_trip_request_fields = [];
    public $option = '';
    public $contigency = '';
    public $communication = '';
    public $travel_contingency_amount = 0;
    public $travel_contingency_description = '';
    public $travel_other_communication = '';
    public $travel_other_communication_ammount = 0;
    public $tempId = '';
    public $temp = '';
    public $projectHeadOfSections = [];
    
    public function render()
    {
        return view('livewire.create-travel');
    }

    public function mount()
    {
        $jsonData = $this->getProjectUsers();
        $jsonDataHeadOfSections = $this->getHeadOfSections();
        $this->tempId = Session::get('travelId');

        if ($this->tempId) {
            $jsonDataTemp = $this->getTemp($this->tempId);
            if ($jsonDataTemp) {
                if($jsonDataTemp == 'Error'){
                   return redirect()->back()->with('error', 'Service Unavailable. Please try again later');
                }
                elseif($jsonDataTemp['status'] == 400){
                    return redirect()->back()->with('error', $jsonDataTemp['error']);
                }
                elseif($jsonDataTemp['status'] == 404){
                    return redirect()->back()->with('error', $jsonDataTemp['error']);
                }
                elseif ($jsonDataTemp['status'] == 200) {
                    if (!empty($jsonDataTemp['data'])) {
                        $this->temp = $jsonDataTemp['data'];
                    } else {
                        return redirect()->back()->with('warning', 'No data available');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Select a project');
                }
            } elseif(empty($jsonDataTemp)) {
                return redirect()->back()->with('warning', 'No data available');
            } else {
               return redirect()->back()->with('warning', 'No data available');
            }
        } else {
            return redirect()->back()->with('warning', 'Select a project');
        }

        if ($jsonData) {
            if($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData['status'] == 200) {
                $this->projectUsers = $jsonData['data'];
            } elseif($jsonData['status'] == 400) {
                return redirect()->back()->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->route('login');
        }

        if ($jsonDataHeadOfSections) {
            if($jsonDataHeadOfSections == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonDataHeadOfSections['status'] == 200) {
                $this->projectHeadOfSections = $jsonDataHeadOfSections['data'];
            } elseif($jsonDataHeadOfSections['status'] == 400) {
                return redirect()->back()->with('error', $jsonDataHeadOfSections['error']);
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getTemp($tempId) 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/documents/'. $tempId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function travelRequest()
    {
        $jsonData = $this->storeTravel();
        if ($jsonData) {
            if($jsonData == 'Error') {
                return redirect()->route('travels.index')->with('error', "Request wasn't successfully");
            } elseif ($jsonData['status'] == 201) {
                return redirect()->route('travels.index')->with('success', "Sucessfully created travel request");
            } elseif($jsonData['status'] == 400) {
                return redirect()->route('travels.index')->with('error', $jsonData['error']);
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        } 
    }
 
    
    public function hasContigency()
    {
        if($this->contigency == "yes"){
            return "yes";
        }
        if($this->contigency == "no"){
           $this->travel_contingency_amount = 0;
           $this->travel_contingency_description = "";
           return  "no";
        }
    }

    public function hasOtherCommunication()
    {
        if($this->communication == "yes"){
            return "yes";
        }
        if($this->communication == "no"){
            $this->travel_other_communication_ammount = 0;
           $this->travel_other_communication = "";
           return  "no";
        }
    }

    public function storeTravel()
    { 
        $validatedData = $this->validate([
            "title"    => ['required','string'],
            "description"    => ['string', 'required'],
            "date"    => ['date', 'required'],
            "date_of_travel"    => ['date', 'required'],
            "origin_location"    => ['string', 'required'],
            "destination_location" => ['string', 'required'],
            "transport_mode" => ['string', 'required','in:Vehicle'],
            "number_of_travelers"    => ['required','integer','min:1'],
            "time_of_day"    => ['required','date_format:H:i'],
            "head_of_section_id" =>['nullable','integer'],
            "regional_team_lead_id" =>['nullable', 'integer'],
            "name_of_persons"    =>['string', 'required'],
            "designation"    => ['string', 'required'],
            "travel_other_communication"    => ['nullable', 'string'],
            "travel_other_communication_ammount"    => ['nullable', 'integer'],
            "travel_contingency_description"    => ['nullable', 'string'],
            "travel_contingency_amount"    => ['nullable', 'integer'],
            "days"    => ['numeric','min:1'],
            "rate"    => ['numeric','min:1'],
            "total"    => ['numeric','min:1']
        ]);
        
        if($this->travel_other_communication){
            $this->validate([ "travel_other_communication" => ['required', 'string']]);
            $this->validate([ "travel_other_communication_ammount" => ['required', 'min:0']]);
        }
        
        if($this->travel_contingency_description){
            $this->validate([ "travel_contingency_description" => ['required', 'string']]);
            $this->validate([ "travel_contingency_amount" => ['required', 'min:0']]);
        }

        if (count($this->pre_trip_request_fields) > 0) {
            foreach ($this->pre_trip_request_fields as $index => $fields) {
                $this->validate([
                    'pre_trip_request_fields.' . $index . '.date_of_travel' => ['required','date'],
                    'pre_trip_request_fields.' . $index . '.origin_location' => ['required','string'],
                    'pre_trip_request_fields.' . $index . '.destination_location' => ['required','string'],
                    'pre_trip_request_fields.' . $index . '.transport_mode' => ['required','string'],
                    'pre_trip_request_fields.' . $index . '.time_of_day' => ['required','date_format:H:i'],
                    'pre_trip_request_fields.' . $index . '.number_of_travelers' => ['required','integer','min:1']
                ]);
            }
        }

        if (count($this->travel_advance_request_fields) > 0) {
            foreach ($this->travel_advance_request_fields as $index => $fields) {
                $this->validate([
                    'travel_advance_request_fields.' . $index . '.name_of_persons' => ['required','string'],
                    'travel_advance_request_fields.' . $index . '.designation' => ['required','string'],
                    'travel_advance_request_fields.' . $index . '.days' => ['numeric','min:1'],
                    'travel_advance_request_fields.' . $index . '.rate' => ['numeric','min:1'],
                    'travel_advance_request_fields.' . $index . '.total' => ['numeric','min:1'],
                ]);
            }
        }
       
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/travel_requisition';
        $data = [];
        $data['title'] = $validatedData['title'];
        $data['description'] = $validatedData['description'];
        $data['date'] = $validatedData['date'];
        if($this->travel_other_communication){
            $data['travel_other_communication'] = $validatedData['travel_other_communication'];
            $data['travel_other_communication_ammount'] = $validatedData['travel_other_communication_ammount'];
        }
        
        if($this->travel_contingency_description){
            $data['travel_contingency_description'] = $validatedData['travel_contingency_description'];
            $data['travel_contingency_amount'] = $validatedData['travel_contingency_amount'];
        }
       
        $tempId = Session::get('travelId');
        $data['related_project_document'] = $tempId;
       
        array_push($this->pre_trip_request_fields,[
            'date_of_travel' => $validatedData['date_of_travel'],
            'origin_location'=> $validatedData['origin_location'],
            'destination_location' =>$validatedData['destination_location'],
            'transport_mode' => $validatedData['transport_mode'],
            'time_of_day'=> $validatedData['time_of_day'],
            'number_of_travelers'=> $validatedData['number_of_travelers'],
        ]);
        $data['pre_trip_request_fields'] = $this->pre_trip_request_fields;

        array_push($this->travel_advance_request_fields,[
            'name_of_persons' => $validatedData['name_of_persons'],
            'designation'=> $validatedData['designation'],
            'days' => $validatedData['days'],
            'rate' =>$validatedData['rate'],
            'total'=> $validatedData['total']
        ]);
        $data['travel_advance_request_fields'] = $this->travel_advance_request_fields;
        
        if($validatedData["head_of_section_id"]){
            $data['is_head_of_section'] = true;
            $data['head_of_section_id'] =  $validatedData["head_of_section_id"];
        }else{
            $data['is_head_of_section'] = false;
            $data['head_of_section_id'] = 0;
        }

        if($validatedData["regional_team_lead_id"]) {
            $data['is_regional_team_lead'] = true;
            $data['regional_team_lead_id'] = $validatedData["regional_team_lead_id"];
        } else {
            $data['is_regional_team_lead'] = false;
            $data['regional_team_lead_id'] = 0;
        }
      
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function calculateSubtotal()
    {
        $finalTotal = 0;
        $finalTotal =  $finalTotal + $this->total;
        foreach ($this->travel_advance_request_fields as $item) {
            $finalTotal += $item['total'];
        }
        $finalTotal + $this->total;
        return $finalTotal;
    }

    public function removeRowTotripList($Id)
    {
        array_splice($this->pre_trip_request_fields, $Id, 1);
    }

    public function removeRowToAdvanceList($Id)
    {
        array_splice($this->travel_advance_request_fields, $Id, 1);
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
        $this->travel_advance_request_fields[$key]['total'] = floatval($days) * $rate;
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
            'origin_location'=> '',
            'destination_location' => '',
            'transport_mode' =>  '',
            'time_of_day'=> '',
            'number_of_travelers'=> 0
        ];
    }

    public function addRowToAdvanceList()
    {
        $this->travel_advance_request_fields[] = [
            'name_of_persons' => '',
            'designation'=> '',
            'days' => 0,
            'rate' =>  0,
            'total'=> 0
        ];
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
