<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visits";

    protected $fillable = [
        'patientpk', 'visit_type_id', 'visitname','date_stopped','date_started','indication_concept_id',
        'location_id','creator','changedby','voided_by','date_created','date_changed',
        'date_voided','uuid','void_reason',
    ];
}
