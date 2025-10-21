<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammaticIndicator extends Model
{
    use HasFactory;
    public function getallartpatient()
    {
        try {
            $artpatients=DB::select("
           
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }
    
    public function getallartterminations()
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function getartstart($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function currentlyonsecondline()
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }


    public function getenrollmentsbyentrypoint($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function getenrollmentsbymonth($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
           
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function getformscomputerized()
    {
        try {
            $artpatients=DB::statement("");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function getpatientsstartingart($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }
}
