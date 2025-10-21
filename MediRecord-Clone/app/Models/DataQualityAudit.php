<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataQualityAudit extends Model
{
    use HasFactory;

    public function getmissingartstart()
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }
    public function getmissingregimenswitch()
    {
        try {
            $artpatients=DB::select("
                   
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }
         
    public function getvlmissingdate()
    {
        try {
            return DB::select("
            
            ");
        } catch (\Throwable $th) {
        }
    }

    public function gettbdiagnosis()
    {
        try {
            return DB::select("
            
            ");
        } catch (\Throwable $th) {
        }
    }

    public function getmissingtptstartdate()
    {
        try {
            return DB::select("
            
            ");
        } catch (\Throwable $th) {
        }
    }

    public function getdirtydates()
    {
       try {
            return DB::select("
            
            ");
       } catch (\Throwable $th) {
       }  
    }

}