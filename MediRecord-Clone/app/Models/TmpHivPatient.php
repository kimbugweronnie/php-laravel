<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpHivPatient extends Model
{
    use HasFactory;
    protected $table = "tmp_hiv_patients";

    protected $fillable = [
    'patientpk','gender','dob','patientname','registrationdate' ,'ageenrollment' ,
    'lastvisitdate' ,'agelastvisit' ,'dateconfirmedhivpositive','entrypoint','transferin','transferindate',
    ];
       
}
