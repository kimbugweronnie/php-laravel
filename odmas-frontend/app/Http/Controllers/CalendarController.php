<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('calendar.index');
    }

    public function events()
    {
        $events = [];
        $activities = $this->getActivities();
        $holidays = $this->getHolidays();

        foreach ($holidays as $holiday) {
            $event = [
                'id' => $holiday['id'],
                'title' => $holiday['holiday_name'],
                'description' => 'holiday',
                'start' => $this->getTimestamp($holiday['public_holiday']),
                'end' => $this->getTimestamp($holiday['public_holiday']),
                'color' => '#ffff00',
            ];
            array_push($events, $event);
        }
        foreach ($activities as $activity) {
            $event = [
                'id' => $activity['id'],
                'title' => $activity['activity_name'],
                'description' => $activity['recurring_frequency'],
                'start' => $this->getTimestamp($activity['start_date']),
                'end' => $this->getTimestamp($activity['end_date']),
                'color' => '#4db8ff',
            ];
            array_push($events, $event);
        }
        return response()->json($events);
    }

    public function getTimestamp($date)
    {
        $timestamp = date('Y-m-d', strtotime($date));
        return $timestamp;
    }

    public function getActivities()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/list?search=false';
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

    public function getHolidays()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/public_holidays?tenant_id=1';
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

    public function getToken()
    {
        return Session::get('token');
    }
}
