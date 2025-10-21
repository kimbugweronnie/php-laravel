<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpLaststatus extends Model
{
    use HasFactory;
   
    protected $table = "tmp_laststatuses";

    protected $fillable = [
        'patientpk',
        'exitreason',
        'causeofdeath',
        'exitdate',
    ];
}
