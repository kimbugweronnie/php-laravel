<?php

namespace App\Livewire;

use Session;
use Livewire\Component;

use Illuminate\Support\Facades\Http;

class EditProjectRole extends Component
{
    public $projectroles = [];
    public $projects = [];
    public $role;
    public $role_name;
    public $reports_to = '';
    public $related_project;

    public function render()
    {
        return view ('livewire.edit-project-role');
    }

    public function mount($id)
    {
       
        $this->role = $this->getRole($id); 
        $this->role_name = $this->role['role_name'];
     
    }

    public function getRole($id)
    {
         $url = 'https://api.odms.savannah.ug/api/v1/tenants/departments/roles/' . $id;
        $accessToken = $this->getToken();
        if ($accessToken) {
            try{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $role = $response->json();
                return $role['data'];
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

   
    public function editProjectRole()
    {
        $editedResponse = $this->updateRole();
        if($editedResponse['status'] != 200) {
            return redirect()->back()->with('danger', $editedResponse['error']);
        }elseif( $editedResponse == 'Error'){
            return redirect()->route('error');
        
        }elseif($editedResponse == null){
            return redirect()->route('login');
        }
        $role = $editedResponse['data'];
        return redirect()->route('projectRoles.index')->with('success', 'Successfully updated a project role');
    }

    public function updateRole()
    {
        $validatedData = $this->validate([
            "role_name"    => 'nullable',
            "reports_to" => ['nullable','integer','min:1']
        ]);

        $url = 'https://api.odms.savannah.ug/api/v1/project_role/edit/' . $this->role['id'];
        $data = [];
        $data['id'] =  $this->role['id'];
        $data['role_name'] = $validatedData['role_name'] ?  $validatedData['role_name'] : $this->role['role_name'];
        $data['reports_to'] = $validatedData['reports_to'] ?  $validatedData['reports_to']  : "";
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

    public function getToken()
    {
        return Session::get('token');
    }

}