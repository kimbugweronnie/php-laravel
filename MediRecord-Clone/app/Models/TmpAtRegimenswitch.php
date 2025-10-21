<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpAtRegimenswitch extends Model
{
    use HasFactory;

    protected $table = "tmp_at_regimenswitches";
    protected $fillable = [
        'patientpk',
        'startregimen',
        'firstlinesub_regimen',
        'firstlinesub_dateswitched',
        'firstlinesub_reasonswitched',
        'secondline_regimen',
        'secondline_dateswitched',
        'secondline_reasonswitched',
        'thirdline_regimen',
        'thirdline_dateswitched',
        'thirdline_reasonswitched',
    ];
}
