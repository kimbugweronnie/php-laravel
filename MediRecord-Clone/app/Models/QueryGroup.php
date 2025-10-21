<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryGroup extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "querygroups";

    public $fillable = ['querygroupid','querygroupname'];

    
    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function querygrouplinks()
    {
        return $this->hasMany(QueryGroupLink::class);
    }


   
}
