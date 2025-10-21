<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryGroupLink extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "querygrouplinks";

    public $fillable = ['querygrouplinkid','queryid','querygroupid'];

    
    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function querygroup()
    {
        return $this->belongsTo(QueryGroup::class);
    }

   

    

    

   
}
