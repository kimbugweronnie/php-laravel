<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "locations";

    protected $fillable = [
        'name','description','address','address2','city_village','description','state_province' ,'postalcode',
        'country','latitude','longtitude','description','county_district','address3','address4','address5',
        'address7','address8','address9','address10','address11','address12','address13','address14','creator','changedby','datechanged',
        'date_created','date_retired','retired','retiredby','uuid','retired_reason','parent_location','uuid'

    ];
}
