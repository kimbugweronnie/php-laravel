<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClockInAndOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clock_in_and_out.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createClockIn()
    {
        return view('clock_in_and_out.create_clock_in');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createClockOut($id)
    {
        $clockInAndOutTime = $this->getSpecificClockInsAndOut($id);
        if ($clockInAndOutTime) {
            return view('clock_in_and_out.create_clock_out', compact('clockInAndOutTime'));
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getLocation(Request $request)
    {
        $ip = $request->ip;
        $api = config('app.apiKey');

        $geo_url = 'https://api.ipgeolocation.io/ipgeo?apiKey=' . $api . '&ip=' . $ip . '&fields=geo';
        $response = Http::withHeaders([])->get($geo_url);
        $jsonData = $response->json();
        return $jsonData;
    }
    public function storeClockIn(Request $request)
    {
        $jsonData = $this->saveClockIn($request);
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData == null) {
                return redirect()->route('login');
            } elseif ($jsonData['status'] == 201) {
                Session::put('clockInData', $jsonData['data']['id']);
                return redirect()->route('home')->with('success', 'Successfully clocked in');
            } else {
                if ($jsonData['status'] == 400) {
                    return redirect()
                        ->route('home')
                        ->with('error', $jsonData['error']);
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function isValidDate($date, $format = 'Y-m-d')
    {
        $dateTime = Carbon::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }

    public function saveClockIn(Request $request)
    {
        $currentTime = now()->addHours(3)->format('H:i');
        $currentDay = now()->addHours(3)->format('Y-m-d');
        $url = 'https://api.odms.savannah.ug/api/v1/clock_in_clock_out/clock_in';
        $data = [];
        $data['related_user'] = Session::get('userDetails')['id'];
        $data['clock_in_time'] = $currentTime;
        $data['day_recorded'] = $currentDay;
        $data['clock_in_geo_tag'] = $currentDay;
        $get_location = $this->getLocation($request);
        if (isset($get_location['message'])) {
            $data['location'] = null;
        } else {
            $data['location'] = $get_location['city'];
        }
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

    /**
     * Store a newly created resource in storage.
     */
    public function storeClockOut()
    {
        $current_hour = now()->addHours(3)->format('H');
        $jsonData = $this->saveClockOut();
        if ($jsonData) {
            if ($jsonData == 'Error') {
                return redirect()->route('error');
            } elseif ($jsonData == null) {
                return redirect()->route('login');
            } elseif ($jsonData['status'] == 201) {
                return redirect()->route('home')->with('success', 'Successfully clocked out');
            } elseif ($jsonData['status'] == 400) {
                return redirect()
                    ->route('home')
                    ->with('error', $jsonData['error']);
            } elseif ($jsonData['status'] == 404) {
                return redirect()->route('home')->with('success', 'Successfully clocked out');
            } else {
                return;
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function saveClockOut()
    {
        $currentDay = now()->addHours(3)->format('Y-m-d');
        $currentTime = now()->addHours(3)->format('H:i');
        $url = 'https://api.odms.savannah.ug/api/v1/clock_in_clock_out/clock_out/clock_out_by_date';
        $data = [];
        $data['day_recorded'] = $currentDay;
        $data['clock_out_time'] = $currentTime;
        $data['clock_in_geo_tag'] = $currentDay;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url, $data);
                return $response->json();
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return;
        }
    }

    public function getSpecificClockInsAndOut($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/clock_in_clock_out/get/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            return $jsonData;
        } else {
            return;
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
