<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $connection = 'openmrs';
    protected $table = 'role';

    protected $fillable = ['role','description','uuid'];
       
    public function get_roles()
    {
        return $this::all(); 
    }
}
