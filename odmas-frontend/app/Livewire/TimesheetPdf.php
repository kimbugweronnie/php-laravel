<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class TimesheetPdf extends Component
{
    public $timesheet = [];
    public $activities = [];
    public $days = [];
    public $profile;

    public function mount($month, $year)
    {
        $this->timesheet = $this->getTimesheet($month, $year);
        $this->activities = $this->getTimesheetActivities();
        $this->days = $this->timesheet['data']['timesheets'];
        $this->profile = Session::get('employee_details')['related_role'];
    }

    public function getTimesheet($month, $year)
    {
        if (is_null(Session::get('userDetails'))) {
            return redirect()->route('login');
        }
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
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.timesheet-pdf');
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
                return $response->json()['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function tranformDay($day)
    {
        $dayOfWeek = date('l', strtotime($day['day']));
        return $dayOfWeek;
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
