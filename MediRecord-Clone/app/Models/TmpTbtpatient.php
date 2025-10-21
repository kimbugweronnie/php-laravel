<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpTbtpatient extends Model
{
    use HasFactory;
    protected $table = "tmp_tbtpatients";
    protected $fillable = [
        'patientpk',
        'districttbnumber',
        'visityear',
        'tbtxstartdate',
        'tbtxenddate'
    ];
}
