<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class PublicHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicHolidays = [];
        $jsonData = $this->getPublicHolidays();
        if ($jsonData == 'Error') {
            return redirect()->route("error");
        } elseif ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $publicHolidays = $jsonData['data'];
                return view('public_holiday.index', compact('publicHolidays'));
            } else {
                return redirect()->back()->with('warning', 'No data found');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function create()
    {
        return view('public_holiday.create');
    }

    public function store(Request $request) 
    {
        $jsonData = $this->storePublicHoliday($request);
        if ($jsonData == 'Error') {
            return redirect()->route("error");
        } 
        elseif ($jsonData == null) {
            return redirect()->route("login");
        } 
        elseif ($jsonData['status'] == 201) {
            return redirect()->route("publicHolidays.index");
        } else if ($jsonData['status'] == 400) {
            return redirect()->back()->with('warning', 'Form has errors');
        } else {
            return redirect()->route('login');
        }
    }

    public function storePublicHoliday($request)
    {
        $validatedData = $request->validate([
            "public_holiday"    => "required",
            "holiday_name"    => "required",
            "color"    => "required",
          
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/public_holidays';
        $data = [];
        $data['related_tenant'] = 1;
        $data['public_holiday'] = $validatedData['public_holiday'];
        $data['holiday_name'] = $validatedData['holiday_name'];
        $data['color'] = $request->color;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function getPublicHolidays()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/public_holidays?tenant_id=1';
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

    public function getToken()
    {
        return Session::get('token');
    }
}
