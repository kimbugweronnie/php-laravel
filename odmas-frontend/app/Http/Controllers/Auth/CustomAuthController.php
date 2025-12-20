<?php

namespace App\Http\Controllers\Auth;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

//api.odms.savannah.ug

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $url = 'https://api.odms.savannah.ug/api/v1/authenticate';
        if (!$request->username || !$request->password) {
            return redirect()->back()->with('error', 'Field may not be blank.');
        }
        $credentials = [];
        $credentials['username'] = $request->username;
        $credentials['password'] = $request->password;
        try {
            $response = Http::post($url, $credentials);
            $jsonData = $response->json();
        } catch (\Throwable $error) {
            return redirect()->route('login');
        }
        $response = Http::post($url, $credentials);
        if ($jsonData['status'] == 200) {
            session(['token' => $jsonData['data']['token']['token']]);
            session(['userDetails' => $jsonData['data']['user_details']]);
            $projects = $this->getAttachedProjects($jsonData['data']['employee_details']['id'], $jsonData['data']['token']['token']);
            if ($projects == 'Error') {
                return redirect()->route('login');
            }
            if (isset($jsonData['data']['employee_details'])) {
                session(['employee_details' => $jsonData['data']['employee_details']]);
                session(['projects' => $projects]);
            }
            return redirect()->route('home')->with('success', 'Your logged in successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', $jsonData['error']);
        }
    }

    public function getAttachedProjects($id, $accessToken)
    {
        $projects = [];
        $url = 'https://api.odms.savannah.ug/api/v1/projects/participants/attached_projects?employee_id=' . $id;
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $attached_projects = $response->json();
                foreach ($attached_projects['data'] as $project) {
                    array_push($projects, $project['related_project']);
                }
                return $projects;
            } catch (\Throwable $error) {
                return 'Error';
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function error()
    {
        return view('auth.error');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect('dashboard')->withSuccess('You have been registered successfully');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect('login')->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Cache::flush();
        return Redirect('login');
    }
}
