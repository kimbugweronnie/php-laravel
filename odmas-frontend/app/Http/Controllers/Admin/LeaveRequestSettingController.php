<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class LeaveRequestSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveRequestSettings = [];
        $jsonData = $this->getLeaveRequestSettings();
        if ($jsonData == 'Error') {
            return redirect()->route("error");
        } 
        elseif ($jsonData == null) {
            return redirect()->route("login");
        } 
        elseif ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $leaveRequestSettings = $jsonData['data'];
                return view('leave_setting.index', compact('leaveRequestSettings'));
            } else {
                return redirect()->back()->with('warning', 'No data found');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function store(Request $request) 
    {

    }

    public function getLeaveRequestSettings()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/leave_settings?tenant_id=1';
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

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "mandatory_leave_days"    => "required",
            "paternity_leave_days"    => "required",
            "maternity_leave_days"    => "required",
            "sick_leave_days"    => "required",
          
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/tenants/leave_settings/edit?tenant_id=1';
        $data = [];
        $data['mandatory_leave_days'] = $validatedData['mandatory_leave_days'];
        $data['paternity_leave_days'] = $validatedData['paternity_leave_days'];
        $data['maternity_leave_days'] = $validatedData['maternity_leave_days'];
        $data['sick_leave_days'] = $validatedData['sick_leave_days'];
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return redirect()->back()->with("success", "Settings updated successfully!");
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
