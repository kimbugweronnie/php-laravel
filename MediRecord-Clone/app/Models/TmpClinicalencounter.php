<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpClinicalencounter extends Model
{
    use HasFactory;
    protected $table = "tmp_clinicalencounters";
    protected $fillable = [
        'patientpk',
        'visitid',
        'visitname',
        'visitdate',
        'scheduled',
        'height',
        'weight',
        'bmi',
        'muac',
        'nutritionassessment',
        'nutritionsupport',
        'tbstatus',
        'tptstatus',
        'tptstartdate',
        'tptcompletiondate',
        'whostage',
        'wabstage',
        'arvadherence',
        'dsdm',
        'pregnant',
        'infantfeedingmethod',
        'cacxscreening',
        'attendingclinician',
        'appointmentdate',
        'attendingclinician'
    ];
}
