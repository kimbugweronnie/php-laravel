<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvals = $this->getApprovals();
        if ($approvals) {
            if ($approvals == 'Error') {
                return redirect()->route('error');
            } elseif ($approvals == 'No approvals') {
                $approvals = [];
                return view('approval.index', compact('approvals'));
            } else {
                return view('approval.index', compact('approvals'));
            }
        } else {
        }
    }

    public function approvalHistory(){

        $approvals = $this->getPastApprovals();
        if ($approvals) {
            if ($approvals == 'Error') {
                return redirect()->route('error');
            } elseif ($approvals == 'No approvals') {
                $approvals = [];
                return view('approval.history', compact('approvals'));
            } else {
                return view('approval.history', compact('approvals'));
            }
        } else {
        }

    }

    public function getPastApprovals(){
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approvals/history';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    return 'No approvals';
                }
                if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        return $jsonData['data'];
                    } else {
                        return 'No approvals';
                    }
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');;
        }

    }

    public function create()
    {
        return view('approval.create');
    }

    public function approvalDelegate(Request $request)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/delegate';
        $validatedData = $request->validate([
            'approval_step_id' => 'required',
            'related_employee' => ['required', 'integer', 'min:1'],
        ]);
        $data = [];
        $data['approval_step_id'] = $validatedData['approval_step_id'];
        $data['delegated_to'] = $validatedData['related_employee'];

        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    return redirect()->route('approvals.index')->with('success', 'successfully delegated');
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function timesheetApproval($id)
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
                    $employee_id = $jsonData['data']['related_document_request']['added_by']['id'];
                    $month = $jsonData['data']['timesheet_month'];
                    $year = $jsonData['data']['timesheet_year'];
                    return view('time_sheet.edit', compact('id', 'employee_id', 'month', 'year'));
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return;
        }
        // return view('approval.create');
    }

    public function approvedTimesheet($id)
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
                    $employee_id = $jsonData['data']['related_document_request']['added_by']['id'];
                    $month = $jsonData['data']['timesheet_month'];
                    $year = $jsonData['data']['timesheet_year'];
                    return view('time_sheet.show', compact('id', 'employee_id', 'month', 'year'));
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
        // return view('approval.create');
    }

    public function show()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approvals/history';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    return 'No approvals';
                }
                if ($jsonData['status'] == 200) {
                    $approvals = $jsonData['data'];
                    return view('approval.history', compact('approvals'));
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getApprovals()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approvals';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    return 'No approvals';
                }
                if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        return $jsonData['data'];
                    } else {
                        return 'No approvals';
                    }
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return;
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
