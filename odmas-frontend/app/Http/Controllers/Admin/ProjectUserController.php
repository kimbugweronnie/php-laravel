<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jsonData = $this->getProjects();
        $projects = $jsonData['data'];
        if (is_null($projects)) {
            return redirect()->back()->with('warning', 'No data found');
        }elseif($projects == 'Error'){
            return redirect()->route('error');
        }else {
            return view('users.index', compact('projects'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = $this->getEmployees();
        $projects = $this->getProjects();
        $stations = $this->getStations();
        if (is_null($employees) || is_null($projects) || is_null($stations)) {
            return redirect()->back()->with('warning', 'No data found');
        }
        return view('users.create', compact(['employees', 'projects', 'stations']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $jsonData = $this->storeProject($request);
        if ($jsonData['status'] == 201) {
            return redirect()->route('users.index');
        } else {
            return redirect()->back()->with('warning', 'Wasn\'t successful');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $projectId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $project = $response->json();
        } else {
           return redirect()->route('login');
        }
        return view('users.show', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit($projectId)
    {
        $getProject = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $projectId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $employees = $this->getEmployees();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($getProject);
            $project = $response->json();
        } else {
           return redirect()->route('login');
        }
        
        return view('users.edit', compact(['project', 'employees']));
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $projectId)
    {
        $editedResponse = $this->updateProject($request, $projectId);
        $project = $editedResponse['data'];
        return view('users.show', compact('project'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function destroy($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/delete/' . $projectId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url);
            $projects = $this->getProjects();
        } else {
           return redirect()->route('login');
        }

        return view('users.index', compact('projects'));
    }

    public function storeProject($request)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
        $data = [];
        $data['related_tenant'] = 1;
        $data['project_name'] = $request->project_name;
        $data['project_number'] = $request->project_number;
        $data['donor'] = $request->donor;
        $data['project_participant'] = $request->project_participant;
        $data['added_by'] = 1;
        
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url, $data);
            return $response->json();
        } else {
            return redirect()->route('login');
        }
    }
    
    public function updateProject($request, $projectId)
    {
        $userDetails = null;
        if (Session::get('userDetails')) {
            $userDetails = Session::get('userDetails');
        } else {
            return redirect()->route('login');
        }

        $url = 'https://api.odms.savannah.ug/api/v1/projects/edit/' . $projectId;
        $accessToken = $this->getToken();
        $data = [];
        $data['related_tenant'] = 1;
        $data['project_name'] = $request->project_name;
        $data['project_number'] = $request->project_number;
        $data['donor'] = $request->donor;
        $data['added_by'] = $userDetails['id'];
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url, $data);
            return $response->json();
        } else {
            return redirect()->route('error');
        }
    }

    public function getStations()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/project_stations?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            return $jsonData['data'];
        } else {
            return redirect()->route('error');
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
            return redirect()->route('error');
        }
    }

    public function getEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
            $jsonData = $response->json();
            return $jsonData['data'];
        } else {
            return redirect()->route('error');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}


