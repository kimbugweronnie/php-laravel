<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CreateLeave extends Component
{
    use WithFileUploads;

    public $leave_days_required;
    public $leave_start_date;
    public $address_while_on_leave;
    public $type_of_leave;
    public $related_employee;
    public $employees;
    public $employee_id;
    public $employee_firstname;
    public $employee_lastname;

    public function mount()
    {
        $this->employees = $this->getEmployees();
        $this->employee_id = Session::get('employee_details')['id'];
        $this->employee_firstname = Session::get('userDetails')['first_name'];
        $this->employee_lastname = Session::get('userDetails')['last_name'];
    }

    public function getUserObligations() {
        
        if(!$this->related_employee){
            return;
        }
        $employeeId = Session::get('employeeId');
        if($employeeId){
            Session::forget('employeeId');
            Session::put('employeeId', $this->related_employee);
        }
        else{
            Session::put('employeeId', $this->related_employee);
        }
        $id = Session::get('employeeId');
        $url = 'https://api.odms.savannah.ug/api/v1/requests/user_obligations?employee_id='.$id;

        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    session()->flash('warning', $jsonData['error']);
                    return redirect()->back()->with('warning', $jsonData['error']);
                }
                return $jsonData;
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
        
        
    }

    public function leaveRequest()
    {
        $jsonData = $this->storeLeave();
        if ($jsonData) {
            if ($jsonData['status'] == 201) {
                return redirect()->route('leave.index')->with('success', 'Sucessfully created leave request');
            } elseif ($jsonData['status'] == 404) {
                return redirect()
                    ->route('leave.create')
                    ->with('error', $jsonData['error']);
            
            } elseif ($jsonData == null) {
                return redirect()
                    ->route('leave.create')
                    ->with('error', 'Unable to create request for this employee');
            }
             elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->route('leave.create')
                    ->with('error', $jsonData['error']);
            } else {
                return redirect()->back()->with('error', 'You have already applied for leave');
            }
        } else {
            return redirect()->back()->with('warning', "Request wasn't successfully");
        }
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
                $jsonData = $response->json();
                return $jsonData['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    function storeLeave()
    {
        $validatedData = $this->validate([
            'leave_days_required' => ['required', 'integer'],
            'leave_start_date' => ['required', 'date'],
            'address_while_on_leave' => ['required', 'string'],
            'type_of_leave' => ['required', 'string'],
            'related_employee' => ['required', 'integer', 'min:1'],
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/requests/leave_request?user_filter=True';
        $data = [];
        $data['related_employee'] = $validatedData['related_employee'];
        // dd($validatedData['related_employee']);
        $data['leave_days_required'] = $validatedData['leave_days_required'];
        $data['leave_start_date'] = $validatedData['leave_start_date'];
        $data['address_while_on_leave'] = $validatedData['address_while_on_leave'];
        $data['leave_type'] = $validatedData['type_of_leave'];
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
        return view('livewire.create-leave');
    }

    public function getToken()
    {
        return Session::get('token');
    }

      
       
}
