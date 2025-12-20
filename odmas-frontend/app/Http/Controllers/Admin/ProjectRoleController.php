<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ProjectRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->getProjects();
        $roles = $this->getRoles();
        if (is_null($roles) || is_null($projects)) {
            return redirect()->route('login');
        }elseif($projects == 'Error'|| $roles == 'Error'){
            return redirect()->route('error');
        }else{
            return view('roles.index', compact(['projects', 'roles']));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    public function edit($id)
    {
        return view('roles.edit',compact('id'));
    }

    public function show($id)
    {
        return view('roles.show',compact('id'));
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
            return redirect()->route('login');
        }
    }

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

    public function destroy($id)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/project_role/delete/' . $id;
        $accessToken = $this->getToken();
        $data = [];
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post($url,$data);
                return view('roles.index');
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
    
    public function getToken()
    {
        return Session::get('token');
    }
}

