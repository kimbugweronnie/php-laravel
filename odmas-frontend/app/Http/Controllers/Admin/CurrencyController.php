<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = [];
        $jsonData = $this->getCurrencies();
        if ($jsonData == 'Error') {
            return redirect()->route("error");
        } 
        if ($jsonData == null) {
            return redirect()->route("login");
        } 
        if ($jsonData['status'] == 200) {
            if (!empty($jsonData['data'])) {
                $currencies = $jsonData['data'];
                return view('currency.index', compact('currencies'));
            } else {
                return redirect()->back()->with('warning', 'No data found');
            }
        } else {
            return redirect()->route('login');
        }
    }
    
    public function create()
    {
        return view('currency.create');
    }

    public function store(Request $request) 
    {
        $jsonData = $this->storeCurrency($request);
        if ($jsonData == 'Error') {
            return redirect()->route("error");
        } 
        elseif ($jsonData == null) {
            return redirect()->route("login");
        } 
        elseif ($jsonData['status'] == 201) {
            return redirect()->route("currencies.index");
        } else if ($jsonData['status'] == 400) {
            return redirect()->back()->with('warning', 'Form has errors');
        } else {
            return redirect()->route('login');
        }
    }

    public function storeCurrency($request)
    {
        $validatedData = $request->validate([
            "currency_name"    => "required",
            "currency_symbol"    => "required",
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/currency_settings';
        $data = [];
        $data['related_tenant'] = 1;
        $data['currency_name'] = $validatedData['currency_name'];
        $data['currency_symbol'] = $validatedData['currency_symbol'];
        
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function getCurrencies()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/currency_settings?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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
