<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
   
    protected $table = "queries";
   

    public $fillable = ['queryid','queryname','querydescription','querydefinition'];

    public function querydefintion($queryid)
    {
        return $this::where('queryid','=', $queryid)->select('querydefinition')->first();
    }

    public function allpatients()
    {
        return $this::where('queryname','=', 'allpatients')->select('querydefinition')->first();
    }

    public function missedarvpickup()
    {
        return $this::where('queryname','=', 'missedartpickup')->select('querydefinition')->first();
    }

    public function missedappoitments()
    {
        return $this::where('queryname','=', 'missedappointments')->select('querydefinition')->first();
    }

    public function appointments()
    {
        return $this::where('queryname','=', 'appointments')->select('querydefinition')->first();
    }

    public function viralloadpatients()
    {
        return $this::where('queryname','=', 'dueforviralload')->select('querydefinition')->first();
    }

    public function detectableviralload()
    {
        return $this::where('queryname','=', 'detectableviralload')->select('querydefinition')->first();
    }



   
}
