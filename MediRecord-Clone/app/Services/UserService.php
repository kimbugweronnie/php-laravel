<?php
namespace App\Services;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\LoginResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UserService extends Controller
{
    private $user;
    private $roles;
    private $userRole;
    public function construct(User $user, Roles $roles,UserRole $userRole) {
        $this->user = $user;
        $this->roles = $roles;
        $this->userRole = $userRole;
    }

    public function userregistration($request)
    {
        $uuid = Str::uuid()->toString();
        // $personid = auth()->user()->id;
        $personid = 1;
        $systemid = 1;
        // $creator = auth()->user()->id;
        $creator = 1;
        $datecreated = "2018-12-31";
        $createduser= $this->user->createuser($request,$uuid,$personid, $systemid,$creator,$datecreated);
        $assignrole = $this->userRole->createrole($createduser['userid'],$request['role']);
        return $this->sendresponse($createduser,201);
    }

    public function userlogin(UserLoginRequest $request)
    {
        return $this->authcheck($request->email,$request->password);
    }

    public function authcheck($email,$password)
    {
        $user=$this->user->userbyemail($email); 
        if(!$user){
            return $this->sendmessage("No user with email $email", 401);
        }
        if(Auth::attempt(['email' => $email,'password' => $password]) == 0){
            return $this->sendmessage('Wrong Password', 401);
        }else{ 
            return $this->createtoken($email);
        }
    }

    public function createtoken($email)
    {
        $user=$this->user->userbyemail($email);
        $accesstoken = auth()->user()->createToken('anything',[ "*"],now()->addHours(2),$user->userid,"App\\Models\\User");
        $user->token = $accesstoken->plainTextToken;
        $user->role = $this->user->role($user["userid"]);
        $user->tokenexpiry = $accesstoken->accessToken->expiresat;
        return $this->sendresponse(new LoginResource($user), 201);
    }

    public function getusers()
    {
        return UserResource::collection($this->user->all());  
    }

    public function getroles()
    {
        return $this->roles->getnames();
    }

    public function getrole($name)
    {
        $role = $this->roles->role($name);
        return $role;
    }
    
    public function getuser($id)
    {
        $user=$this->user->getuser($id);
        return $this->sendresponse(new UserResource($user), 200);
    }

    public function updateuser(UserUpdateRequest $request,$id)
    { 
        $this->user->updateuser($request->validated(),$id);
        return $this->getuser($id);
    }

   

    public function destroy($id)
    {
        $this->user::destroy($id);
        return $this->sendresponse("User has been deleted", 200);  
    }

}