<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpTptpatient extends Model
{
    use HasFactory;
    protected $table = "tmp_tptpatients";
    protected $fillable = [
        'patientpk',
        'tptstatus',
        'tptstartdate',
        'tptcompletiondate'
    ];
}
