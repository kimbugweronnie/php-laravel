<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmtctReport extends Model
{
    use HasFactory;
    public function get_pmtct_cascade($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
           

            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }
    
    public function get_pmtct_partner_testing($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function get_pmtct_vl($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function get_pmtct_eid($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    
}


