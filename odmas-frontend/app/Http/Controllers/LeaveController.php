<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Session::get('userDetails')) {
            $id = Session::get('employee_details')['id'];
            $jsonData = $this->getLeaveRequest($id);
            if($jsonData['status'] == 200) {
                $current_status = $jsonData['data'];

            }
            $leave_lists = $this->getLeaveList();
            return view('leave.index', compact('current_status'));
            
        } else {
            redirect()->route('login');
        }
    }

    public function show($id)
    {
        return view('leave.show', compact('id'));
    }

    public function edit($id)
    {
        return view('leave.edit', compact('id'));
    }

    public function getLeaveRequest($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/requests/leave_details?employee_id=' . $id;
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

    public function getLeaveList()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/requests/leave_request?user_filter=True&status_filter=1';
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

    public function create()
    {
        return view('leave.create');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
