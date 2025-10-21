<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(UserService $userservice) {
        $this->userservice = $userservice; 
    }
   
    public function index()
    {
       return $this->users;
    }

    public function store(UserRequest $request)
    {
        return $this->userservice->userregistration($request->validated());
    }
    
    public function login(UserLoginRequest $request)
    { 
        $user=$this->userservice->userlogin($request);
        return $user;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ['message' => 'user logged out']; 
    }

    public function show($id)
    {
        return $this->userservice->getuser($id);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        return $this->userservice->updateuser($request,$id);
    }

    public function destroy($id)
    {
        return $this->userservice->destroy($id);
    }
}
