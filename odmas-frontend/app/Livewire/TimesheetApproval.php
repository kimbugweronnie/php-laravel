<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class TimesheetApproval extends Component
{
    public $timesheet = [];
    public $activities = [];
    public $days = [];
    public $profile;
    public $employee_id;
    public $month;
    public $year;
    public $timesheetRequest = [];
    public $approval_step_id = '';
    public $related_document_request = '';
    public $related_document_approval_step = '';
    public $comment = '';
    public $period;

    public function mount($id, $employee_id, $month, $year)
    {
        $this->timesheet = $this->getTimesheet();
        $this->activities = $this->timeSheetsActivities();
        $this->days = $this->getTimesheets();
        $this->period = $this->month . ' ' . $this->year;
        $this->profile = Session::get('employee_details')['related_role'];
        $this->timesheetRequest = $this->getTimesheetDocument($id);

        foreach ($this->timesheetRequest['approval_steps'] as $approver) {
            if ($approver['next_step']) {
                $this->approval_step_id = $approver['id'];
                $this->related_document_request = $approver['related_document_request'];
                $this->related_document_approval_step = $approver['related_document_approval_step']['id'];
            }
        }
    }

    public function getTimesheet()
    {
        $id = $this->employee_id;
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/list/' . $id . '?month=' . $this->month . '&year=' . $this->year;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                return $jsonData;
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function approveRequest()
    {
        if ($this->comment) {
            $this->sendAppproval(1);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function ReferBackRequest()
    {
        if ($this->comment) {
            $this->sendAppproval(3);
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function sendAppproval($status)
    {
        if ($this->comment) {
            $url = 'https://api.odms.savannah.ug/api/v1/projects/requests/approve';
            $data = [];
            $data['approval_step_id'] = $this->approval_step_id;
            $data['related_document_request'] = $this->timesheetRequest['related_document_request']['id'];
            $data['related_document_approval_step'] = $this->related_document_approval_step;
            $data['status'] = $status;
            $data['comment'] = $this->comment;
            $accessToken = $this->getToken();
            if ($accessToken) {
                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                    ])->post($url, $data);
                    $jsonData = $response->json();
                    if ($jsonData['status'] == 404) {
                        session()->flash('error', $jsonData['error']);
                    }
                    $this->comment = '';
                    return redirect()->route('approvals.index');
                } catch (\Throwable $error) {
                    return redirect()->route('error');
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            session()->flash('error', 'Please write a comment.');
        }
    }

    public function getTimesheets()
    {
        if ($this->getTimesheet() == 'Error') {
            return redirect()->route('error');
        }
        if ($this->getTimesheet() == null) {
            return redirect()->route('login');
        }
        $timesheet = $this->getTimesheet();
        return $timesheet['data']['timesheets'];
    }

    public function getTimesheetActivities()
    {
        $id = Session::get('userDetails')['id'];
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/activities?employee_id=' . $id;
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

    public function getTotalTimeTaken($days, $activity_display_name)
    {
        $total_time = 0;
        foreach ($days as $day) {
            if (!empty($day['timesheet']['timesheet_records'])) {
                foreach ($day['timesheet']['timesheet_records'] as $record) {
                    if ($record['related_project_or_activity']['display_name'] === $activity_display_name) {
                        $total_time += $record['time_taken'];
                    }
                }
            }
        }
        return $total_time;
    }

    public function percentageToChange($days, $activity_display_name)
    {
        $count = 0;
        foreach ($days as $day) {
            if (!empty($day['timesheet']['timesheet_records'])) {
                foreach ($day['timesheet']['timesheet_records'] as $record) {
                    if ($record['related_project_or_activity']['display_name'] === $activity_display_name) {
                        $count += 1;
                    }
                }
            }
        }
        if ($count === 0) {
            return 0;
        } else {
            return $this->assignedPercentage($days, $activity_display_name);
        }
    }

    public function assignedPercentage($days, $activity_display_name)
    {
        if ($activity_display_name === 'Flash Project') {
            return 50;
        }
        if ($activity_display_name === 'HIV') {
            return 30;
        }
        if ($activity_display_name === 'UCMB Integrated Work') {
            return 20;
        } else {
            return 0;
        }
    }

    public function totalHoursTaken($days)
    {
        $total_hours = 0;
        foreach ($days as $day) {
            $total_hours += $day['hours'];
        }
        return $total_hours;
    }

    public function totalExpectedHours($days)
    {
        $count = 0;
        $total_expected = 0;
        foreach ($days as $day) {
            if (strpos($day['day_string'], 'Saturday') !== false || strpos($day['day_string'], 'Sunday') !== false) {
                $count += 0;
            } else {
                $count += 1;
            }
        }
        $total_expected = $count * 8;
        return $total_expected;
    }

    public function percentTimeWorked($day)
    {
        $percent_time_worked = ($day['hours'] / 8) * 100;
        return $percent_time_worked;
    }

    public function totalHoursPercentage($days)
    {
        $total_hours_percentage = ($this->totalHoursTaken($days) / $this->totalExpectedHours($days)) * 100;
        return round($total_hours_percentage);
    }

    public function getTimeTaken($timesheet_records, $activity_display_name)
    {
        $time_taken = 0;
        foreach ($timesheet_records as $record) {
            if ($record['related_project_or_activity']['display_name'] === $activity_display_name) {
                $time_taken = $record['time_taken'];
            }
        }
        return $time_taken;
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
