<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('time_sheet.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('time_sheet.create');
    }

    public function userTimesheets()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/user_requests?request_category=TIMESHEET';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                $timesheets = $jsonData['data'];
                return view('time_sheet.timesheets', compact('timesheets'));
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function show($id)
    {
        return view('time_sheet.show', compact('day'));
    }

    public function timesheetApproval($month, $year)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/requests';
        $data = [];
        $id = Session::get('employee_details')['id'];
        $data['employee_id'] = $id;
        $data['timesheet_month'] = $month;
        $data['timesheet_year'] = $year;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                $jsonData = $response->json();
                if ($jsonData['status'] == 201) {
                    return redirect()->back()->with('success', 'Successfully submitted timesheet for approval');
                } elseif ($jsonData['status'] == 404) {
                    return redirect()
                        ->back()
                        ->with('error', strtoupper($jsonData['error']));
                } else {
                    return redirect()->back()->with('danger', 'Cant create timesheet appproval request at this time');
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function getTimesheetDocument($id)
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
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function downloadPDF($month, $year, $id)
    {
        $timesheet = $this->getTimesheet($month, $year);
        $timesheetRequest = $this->getTimesheetDocument($id);
        $profile = Session::get('employee_details')['related_role'];
        if ($timesheet == 'Error') {
            return redirect()->route('error');
        }
        if ($timesheet == null) {
            return redirect()->route('login');
        }
        $days = $timesheet['data']['timesheets'];
        $pdf = Pdf::loadView('pdf.timesheet', [
            'timesheet' => $this->getTimesheet($month, $year),
            'days' => $this->getTimesheets($month, $year),
            'activities' => $this->timeSheetsActivities(),
            'profle' => $profile,
            'timesheetapproval' => $timesheetRequest['approval_steps'],
        ])->setPaper('a4', 'landscape');

        $pdf->setOptions([
            'margin-left' => 0.5,
            'margin-right' => 5.5,
            'margin-top' => 0.5,
            'margin-bottom' => 0.5,
        ]);

        $title = "timesheet for $month $year";
        $names = $timesheet['data']['related_user']['first_name'] . ' ' . $timesheet['data']['related_user']['last_name'] . ' ' . $title;
        $pdfContent = $pdf->stream($names . '.pdf')->getContent();
        return response()->make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $names . '.pdf"',
            'setPaper' => 'A4',
        ]);
    }

    public function getTimesheets($month, $year)
    {
        if ($this->getTimesheet($month, $year) == 'Error') {
            return redirect()->route('error');
        }
        if ($this->getTimesheet($month, $year) == null) {
            return redirect()->route('login');
        }
        $timesheet = $this->getTimesheet($month, $year);
        return $timesheet['data']['timesheets'];
    }

    public function timeSheetsActivities()
    {
        $activities = $this->getTimesheetActivities();
        if ($activities == 'Error') {
            return redirect()->route('error');
        } elseif ($activities == null) {
            return redirect()->route('login');
        } elseif (isset($activities['data'])) {
            return $activities['data'];
        } else {
            return redirect()->route('login');
        }
    }

    public function getTimesheetActivities()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/activities';
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
            return;
        }
    }

    public function getTimesheet($month, $year)
    {
        $id = Session::get('userDetails')['id'];
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/list/' . $id . '?month=' . $month . '&year=' . $year;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData;
            } catch (\Throwable $error) {
                return 'Error';
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
