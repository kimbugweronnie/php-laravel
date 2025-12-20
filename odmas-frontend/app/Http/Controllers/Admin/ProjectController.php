<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->getProjects();
        if($projects == 'Error'){
            return redirect()->route('error');
        }
        elseif (is_null($projects)) {
            return redirect()->route('login');
        }
        else {
            return view('projects.index', compact('projects'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = $this->getEmployees();
        if($employees == 'Error'){
            return redirect()->route('error');
        }
        elseif (is_null($employees)) {
            return redirect()->route('login');
        }
        else{
            return view('projects.create', compact('employees'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $jsonData = $this->storeProject($request);
        if($jsonData == 'Error'){
            return redirect()->route('error');
        }
        elseif($jsonData == null){
            return redirect()->route('login');
        }
        elseif ($jsonData['status'] == 201) {
            return redirect()->route('projects.index')->with(['sucess' => 'Successfully created project']);
        } else {
            return redirect()->route('projects.create')->with(['error' => $jsonData['status']]);
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
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $project = $jsonData['data'];
                        return view('projects.show', compact('project'));
                    } else {
                        return redirect()->back()->with('warning', 'No data found');
                    }
                } else {
                    return redirect()->back()->with('error', $jsonData['error']);
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit($projectId)
    {
        $getProject = 'https://api.odms.savannah.ug/api/v1/projects/get/' . $projectId;
        $employees = $this->getEmployees();
        if (is_null($employees)) {
            return redirect()->route('login');
        }
        if($employees == 'Error') {
            return redirect()->route('error');
        }
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($getProject);
                $jsonData = $response->json();
                if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        $project = $jsonData['data'];
                        return view('projects.edit', compact(['project', 'employees']));
                    } else {
                        return redirect()->back()->with('warning', 'No data found');
                    }
                } else {
                    return redirect()->back()->with('danger', $jsonData['error']);
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $projectId)
    {
        $editedResponse = $this->updateProject($request, $projectId);
        if($editedResponse == 'Error'){
            return redirect()->route('error');
        }
        elseif($editedResponse == null){
            return redirect()->route('login');
        }
        elseif ($editedResponse['status'] == 200) {
            if (!empty($editedResponse['data'])) {
                $project = $editedResponse['data'];
            } else {
                return redirect()->back()->with('warning', 'No data found');
            }
        } else {
            return redirect()->route('login');
        }
        return view('projects.show', compact('project'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function destroy($projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/delete/' . $projectId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url);
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
        $projects = $this->getProjects();
        if($projects == 'Error'){
            return redirect()->route('error');
        }
        if (!$projects) {
            return redirect()->route('login');
        }
        return view('projects.index', compact('projects'));
    }

    public function storeProject($request)
    {
        $validatedData = $request->validate([
            "project_name"    => 'required',
            "project_number"    => 'required',
            "donor"    => 'required',
            "project_participant"    =>['required','integer','min:1'],
        ]);
        $url = 'https://api.odms.savannah.ug/api/v1/projects';
        $data = [];
        $data['related_tenant'] = 1;
        $data['project_name'] = $validatedData['project_name'];
        $data['project_number'] = $validatedData['project_number'];
        $data['donor'] = $validatedData['donor'];
        $data['project_participant'] = $validatedData['project_participant'];
        $data['added_by'] = $this->userId();
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
    
    public function updateProject($request, $projectId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/edit/' . $projectId;
        $data = [];
        $data['related_tenant'] = 1;
        $data['project_name'] = $request->project_name;
        $data['project_number'] = $request->project_number;
        $data['donor'] = $request->donor;
        $data['added_by'] = $this->userId();
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
            try{
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

    public function getEmployees()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/employees?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
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

    public function userId() 
    {
        $userId = null;
        if (Session::get('userDetails')) { 
            return Session::get('userDetails')['id'];
        } else {
            return redirect()->route('login');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
