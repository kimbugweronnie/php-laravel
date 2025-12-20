<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cost_center.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = $this->getProjects();
        if (is_null($projects)) {
            return redirect()->back()->with('warning', 'No data found');
        } elseif($projects == 'Error') {
            return redirect()->route('error');
        }
        return view('cost_center.create', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $jsonData = $this->storeCostCenter($request);
        // dd($jsonData);
        if($jsonData == 'Error'){
            return redirect()->route('error');
        }
        elseif($jsonData == null){
            return redirect()->route('login');
        }
        elseif ($jsonData['status'] == 201) {
            return redirect()->route('costCenters.index')->with(['sucess' => 'Successfully created cost center']);
        } else {
            return redirect()->route('costCenters.create')->with(['warning' => $jsonData['status']]);
        }
    }

    public function storeCostCenter($request)
    {
        $validatedData = $request->validate([
            "related_project"    => 'required',
            "cost_center_name"    => 'required',
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/projects/cost_centers';
        $data = [];
        $data['related_project'] = $validatedData['related_project'];
        $data['cost_center_name'] = $validatedData['cost_center_name'];
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

    public function getProjects()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            return $jsonData['data'];
        } else {
           return;
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
