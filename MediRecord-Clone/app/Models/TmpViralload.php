<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpViralload extends Model
{
    use HasFactory;
    protected $table = "tmp_viralloads";

    protected $fillable = [
        'patientpk',
        'vlresultnumeric',
        'vlresulttext',
        'vldate',
        'encounterdate'
    ];
}
