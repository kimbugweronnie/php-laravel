<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpAtPatient extends Model
{
    use HasFactory;
    protected $table = "tmp_at_patients";
    
    protected $fillable = [
        'patientpk',
        'gender',
        'registrationdate',
        'ageartstart',
        'agelastvisit',
        'transferindate',
        'transferinonart',
        'startartdate',
        'bwho',
        'bwhodate',
        'bwha',
        'bwhadate',
        'pregnantatartstart',
        'lactatingatartstart',
        'breastfeedingatartstart',
        'lastartdate', 
        'startregimen',
        'lastregimen',
        'lastregimenline',
        'expectedreturn'
    ];
}
