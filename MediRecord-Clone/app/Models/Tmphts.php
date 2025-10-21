<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmphts extends Model
{
    use HasFactory;
    protected $table = "tmphts";

    protected $fillable = [
        'patientpk',
        'visitid',
        'visitname',
        'deliverymodel',
        'visitdate',
        'deliverymodel',
        'approach',
        'communitytestingpoint',
        'facilityentrypoint',
        'pmtcttesting',
        'subcounty',
        'testingreason',
        'previousresult',
        'previousresultdate',
        'finalhivtestresult',
        'counsellor',  
    ];
}
