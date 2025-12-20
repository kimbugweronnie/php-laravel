<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = [];
        $accessToken = $this->getToken();
        if(!$accessToken){
            return redirect()->route('login');
        }
        $jsonData = $this->getEmployees();
        if($jsonData == 'Error'){
            return redirect()->route('error');
        }
        elseif($jsonData == null){
            return redirect()->route('login');
        }
        elseif($jsonData['status'] == 200){
            if (!empty($jsonData['data'])) {
                $employees = $jsonData['data'];
                return view('employees.index', compact('employees'));
            } else {
                return redirect()->back()->with('warning', 'No data found');
            }
        }
    }

    public function accessSetting(){
        return redirect()->route('error');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    public function show($id)
    {
        $jsonData = $this->getEmployee($id);
        $employee = $jsonData["data"];
        $projects_attached = $jsonData["data"]["projects_attached"];
        return view('employees.show',compact(['employee','projects_attached']));
    }

    public function edit($id)
    {
        return view('employees.edit',compact('id'));
    }

    public function editLevelsOfEffort($id)
    {
        return view('employees.edit-employee-levels-of-effort',compact('id'));
    }

    public function editPassword($id)
    {
        return view('employees.edit-employee-password',compact('id'));
    }

    
    public function getEmployee($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id='.$id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function deleteEmployee(Request $request)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees/individual?employee_id='.$request->employee_id.'&method=delete&attribute=user';
        $accessToken = $this->getToken();
        $data =[];
        $data['username'] = $request->username;
        if ($accessToken) {
            try {
                 $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url,$data);

               $jsonData = $response->json();
                if($response['status'] == 200){
                    return redirect()->route('employees.index')->with('success', 'Successfully deleted user');
                }else{
                    return redirect()->back()->with('alert', 'Unable to  deleted user');
                }
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
            try{
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

    public function getToken()
    {
        return Session::get('token');
    }
}
