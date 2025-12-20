<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;
use Illuminate\Support\Facades\Http;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('activity.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activity.create');
    }

    public function show($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/get/' . $id;
        $accessToken = $this->getToken();
        $activity = null;
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $activityResp = $response->json();
                if ($activityResp['status'] == 400) {
                    return redirect()
                        ->back()
                        ->with('error', $activityResp['error']);
                }
                $activity = $activityResp['data'];
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
        return view('activity.show', compact(['activity']));
    }

    public function edit($id)
    {
        return view('activity.edit', compact('id'));
    }

    public function destroy($activityId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/activity/delete/' . $activityId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url);
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully');
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

    public function getTimestamp($date)
    {
        $timestamp = date('Y-m-d', strtotime($date));
        return $timestamp;
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
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
