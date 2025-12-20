<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class IndexTimesheet extends Component
{
    public $timesheet;
    public $warning;
    public $days = [];
    public $activities;
    public $month;
    public $year;
    public $period = '';
    public $current_month;
    public $current_year;
    public $timesheet_records = [];
    public $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    public $years = [2023, 2024, 2025];
    public $profile;

    public function mount()
    {
        // if ($this->getTimesheet() == 'Error' || $this->timeSheetsActivities() == 'Error' || $this->getTimesheets() == 'Error') {
        //     return redirect()->route('error');
        // }
        // if ($this->getTimesheet() == null || $this->timeSheetsActivities() == null || $this->getTimesheets() == null) {
        //     return redirect()->route('login');
        // }
        $this->timesheet = $this->getTimesheet();
        $this->activities = $this->timeSheetsActivities();
        $this->days = $this->getTimesheets();
        $currentDateTime = now();
        $this->current_month = $currentDateTime->format('F');
        $this->current_year = $currentDateTime->year;
        $this->period = $this->month . ' ' . $this->year;
        $this->profile = Session::get('employee_details')['related_role'];
    }

    function filterPerMonthYear()
    {
        if($this->previousTimesheet()['status'] ==  500){
            return redirect()->back()->with('warning', $this->previousTimesheet()['error']);
        }
        $this->timesheet = $this->previousTimesheet();
        $this->days = $this->timesheet['data']['timesheets'];
    }

    public function previousTimesheet()
    {
        if (is_null(Session::get('userDetails'))) {
            return;
        }
        $id = Session::get('userDetails')['id'];
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

    public function getTimesheet()
    {
        if (is_null(Session::get('userDetails'))) {
            return;
        }
        $id = Session::get('userDetails')['id'];
        $currentDateTime = now();
        $this->month = $currentDateTime->format('F');
        $this->year = $currentDateTime->year;
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

    public function getTimesheets()
    {
        if ($this->getTimesheet()['status'] == 500) {
            return redirect()->route('home')->with('warning',$this->getTimesheet()['error']);
        }
        if ($this->getTimesheet()['status'] == 400) {
            return redirect()->route('home')->with('warning',$this->getTimesheet()['error']);
        }
        if ($this->getTimesheet()['status'] == 404) {
            return redirect()->route('home')->with('warning',$this->getTimesheet()['error']);
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

    public function removeRowToItemList($Id)
    {
        array_splice($this->timesheet_records, $Id, 1);
    }

    public function addRowToItemList()
    {
        $this->timesheet_records[] = [
            'related_activity' => '',
            'fund_and_project' => '',
            'time_taken' => '',
            'details' => '',
        ];
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
        // if($activity_display_name === 'Flash Project'){
        // return 50;
        // }
        // if($activity_display_name === 'HIV'){
        //     return 30;
        // }
        // if($activity_display_name === 'UCMB Integrated Work'){
        //     return 20;
        // }else{
        //     return 0;
        // }
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
    public function storeTimesheet($request)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/timesheet/add';
        $data = [];
        $data['related_project'] = 1;
        $data['related_user'] = 1;
        $data['related_activity'] = $request->related_activity;
        $data['detail'] = $request->detail;
        $data['day_recorded'] = $request->day_recorded;
        $data['time_taken'] = $request->time_taken;
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

    public function getToken()
    {
        return Session::get('token');
    }
}