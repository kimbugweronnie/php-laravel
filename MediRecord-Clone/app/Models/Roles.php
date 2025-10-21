<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'roles';

    protected $fillable = ['name','guard_name','id'];
       
    public function get_roles()
    {
        return $this::all();    
    }

    public function getnames()
    {
        $roles = [];
        $names = $this::all(['name']);
        foreach ($names as $name) {
            array_push($roles, $name['name']);  
        }
        return $roles;
    }

    public function role($name)
    {
        $role = $this::where('name',$name)->first();
        return $role;
    }
}
