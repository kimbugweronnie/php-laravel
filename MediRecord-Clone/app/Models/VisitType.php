<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    use HasFactory;
    protected $table = "visit_types";

    protected $fillable = [
        'name','description','date_stopped','indication_concept_id','datechanged','date_retired',
        'creator','changedby','retired','retiredby', 'uuid' ,'retired_reason','date_created'
    ];
}
