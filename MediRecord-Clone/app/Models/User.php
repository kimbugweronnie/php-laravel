<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use \App\Models\Roles;
use \App\Models\PersonalAccessToken;
use \App\Models\UserRole;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,InteractsWithMedia;

    protected $connection = 'mysql';
    protected $table = 'users';
    public $timestamps = false;

    protected $primaryKey = 'user_id';

    protected $guard_name = [
        "Anonymous",
        "Application: Administers System",
        "Application: Configures Appointment Scheduling",
        "Application: Configures Forms",
        "Application: Configures Metadata",
        "Application: Edits Existing Encounters",
        "Application: Enters ADT Events",
        "Application: Enters Vitals",
        "Application: Has Super User Privileges",
        "Application: Manages Atlas",
        "Application: Manages Provider Schedules",
        "Application: Records Allergies",
        "Application: Registers Patients",
        "Application: Requests Appointments",
        "Application: Schedules And Overbooks Appointments",
        "Application: Schedules Appointments",
        "Application: Sees Appointment Schedule",
        "Application: Uses Capture Vitals App",
        "Application: Uses Patient Summary",
        "Application: Writes Clinical Notes",
        "Authenticated",
        "Base Reporting Data Manager",
        "Base Role",
        "Counselor",
        "Data Clerk",
        "EID Data Manager",
        "General Data Manager",
        "HIV Clinic",
        "HIV Data Management",
        "HTS Data Manager",
        "MCH Clinic",
        "MCH Data Manager",
        "Midwife",
        "OPD Clinic",
        "OPD Data Manager",
        "Organizational: Clinician",
        "Organizational: Doctor",
        "Organizational: Hospital Administrator",
        "Organizational: Laboratory",
        "Organizational: Nurse",
        "Organizational: Registration Clerk",
        "Organizational: System Administrator",
        "Organizational:Pharmacy",
        "Privilege Level: Full",
        "Privilege Level: High",
        "Provider",
        "Reception",
        "SMC Data Manager",
        "System Developer",
        "TB Clinic",
        "TB Data Manager",
        "Triage"
    ];

    protected $fillable = [
        'email',
        'password' ,
        'system_id',
        'username' ,
        // 'salt',
        // 'secret_question',
        // 'secret_answer',
        'creator',
        'date_created',
        // 'changed_by',
        // 'date_changed',
        'person_id',
        // 'retired',
        // 'retired_by',
        // 'retire_reason',
        'uuid'
    ];

    
    protected $hidden = ['password'];



    public function setPasswordAttribute($password) 
    { 
        return $this->attributes['password'] = bcrypt($password); 
    }


    // public function create_user($request)
    // {
    //     return $this::create($request); 
    // }

    public function create_user($request,$uuid,$person_id,$system_id,$creator,$date_created)
    {
        return $this::create($request + [
            'uuid' => $uuid,
            'person_id' => $person_id,
            'system_id' => $system_id,
            'creator' => $creator,
            'date_created' => $date_created
        ]);
    }

    public function user_by_email($email)
    {
        return $this::where('email',$email)->first();  
    }

    public function get_user($id)
    {
        return $this::where('id',$id)->first();  
    }

    public function get_users()
    {
        return $this::all(); 
    }
    public function get_token($token)
    {
        return PersonalAccessToken::where('token','=',$token)->get(); 
    }

    public function update_user($request,$id)
    {
        return $this::where('id','=',$id)->update($request);
    }

    public function role($id)
    {
        return UserRole::where('user_id','=',$id)->select('role')->first()["role"];
    }

   

}