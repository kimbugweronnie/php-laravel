<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'user_role';
    public $timestamps = false;

    protected $fillable = ['user_id','role'];

    public function create_role($user_id,$role)
    {
        return $this::create(['user_id' => $user_id,'role' => $role]);
    }

}
