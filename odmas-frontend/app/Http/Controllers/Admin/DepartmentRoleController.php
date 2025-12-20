<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class DepartmentRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('department.index');
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $role = $response->json()['data'];
                return view('department.show', compact('role'));
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
    public function edit($roleId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles/' . $roleId;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $response = $response->json();
                $role = $response['data'];
                $departments = $this->getDepartments();
                $roles = $this->getRoles();
                return view('roles.edit', compact(['role','departments','roles']));
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getDepartments() 
    {
        $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments?tenant_id=1';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->connectTimeout(3)->get($url);
                $jsonData = $response->json();
                return $jsonData['data'];
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
    public function update(Request $request, $roleId)
    {
        $editedResponse = $this->updateRole($request, $roleId);
        if($editedResponse['status'] != 200) {
            return redirect()->back()->with('danger', $editedResponse['error']);
        }elseif( $editedResponse == 'Error'){
            return redirect()->route('error');
        }
        $role = $editedResponse['data'];
        return view('roles.show', compact('role'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
  
    public function destroy($roleId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/project_role/delete/' . $roleId;
        $accessToken = $this->getToken();
        
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->delete($url);
                $roles = $this->getRoles();
                if($roles == 'Error'){
                    return redirect()->route('error');
                }
                if (is_null($roles)) {
                    return redirect()->back()->with('warning', 'No data found');
                }
                return view('roles.index', compact('roles'));
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function storeRole($request)
    {
        $userDetails = null;
        if (Session::get('userDetails')) {
            $userDetails = Session::get('userDetails');
        } else {
            return redirect()->route('login');
        }
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles';
        $data = [];
        $data['related_project'] = $request->related_project;
        $data['role_name'] = $request->role_name;
        $data['reports_to'] = $request->reports_to;
        $data['added_by'] = $userDetails['id'];
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
    
    public function updateRole($request, $roleId)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/project_role/edit/' . $roleId;
        $data = [];
        $data['id'] = $roleId;
        $data['role_name'] = $request->role_name;
        $data['reports_to'] = $request->reports_to ? $request->reports_to : "";
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
            return redirect()->route('error');
        }
    }

    

    public function getRoles()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/projects/roles?project_id=1';
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
            return redirect()->route('error');
        }
    }

    public function getToken()
    {
        return Session::get('token');
    }
}

