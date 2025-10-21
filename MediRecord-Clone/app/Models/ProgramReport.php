<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProgramReport extends Model
{
    use HasFactory;

    public function hmis_106_report_header($fromdate,$todate)
    {
        try {
            $artpatients=DB::select("
            ");
            return $artpatients;
        } catch (\Throwable $th) {   
        }
    }

    public function get_cot_report($fromdate,$todate)
    {
        try {
            return DB::select("select (select facilityname from tmp_patientmaster limit 1) facilityname
            , concat(cast($fromdate as date),' - ', cast($todate as date)) enddate");
        } catch (\Throwable $th) {  
        }  
    }

    public function get_cot_summary_report($fromdate,$todate)
    {
        try {
            return DB::select("select (select facilityname from tmp_patientmaster limit 1) facilityname
            , concat(cast($fromdate as date),' - ', cast($todate as date)) enddate");
        } catch (\Throwable $th) {  
        }  
    }


    public function get_dsd_data($fromdate,$todate)
    {
        try {
            return DB::select("select (select facilityname from tmp_patientmaster limit 1) facilityname
            , cast($fromdate as date) startdate, cast($todate as date) enddate");
        } catch (\Throwable $th) {
        }
    }

    public function get_hibrid_data()
    {
        try {
            return DB::statement("pr_loadmissedappointments");
        } catch (\Throwable $th) {
        }
    }

    public function get_hmis_data()
    {
        try {
            return DB::statement("pr_loadmissedappointments");
        } catch (\Throwable $th) {
        }
    }

    public function get_hts_data($fromdate,$todate)
    {
       try {
            return DB::select("
            
            ");
       } catch (\Throwable $th) {
       }  
    }

    public function get_surge_data($fromdate,$todate)
    {
        try {
            return DB::select(
            "select case
            when a.finalhivtestresult = 'HIV-' then 'negative'
            when a.finalhivtestresult = 'HIV+' and (a.previousresult is null or a.previousresult = 'HIV-' or a.previousresultdate >= cast($fromdate as date)) then 'firstpositive'
            when a.finalhivtestresult = 'HIV+' and (a.previousresult = 'HIV+' and a.previousresultdate < cast($fromdate as date)) then 'repeatpositive' else null end as result
            , a.gender
            , case when a.ageattest < 15 then '<15' else '15+' end as agegroup
            , count(distinct a.patientpk) total
            from
            (
            select b.patientpk
            , b.gender
            , b.dob
            , a.visitdate
            , datediff(a.visitdate, b.dob)/365.0 ageattest
            , a.deliverymodel
            , a.testingreason
            , a.previousresult
            , a.previousresultdate
            , a.finalhivtestresult
            from tmp_hts a
            inner join tmp_patientmaster b on a.patientpk = b.patientpk
            where a.visitdate between cast($fromdate as date) and cast($todate as date)
            ) a
            where a.testingreason in ('Index Client Testing','Assisted Partner Notification')
            and a.deliverymodel = 'Facility Based (HCT)'
            group by case
            when a.finalhivtestresult = 'HIV-' then 'negative'
            when a.finalhivtestresult = 'HIV+' and (a.previousresult is null or a.previousresult = 'HIV-' or a.previousresultdate >= cast($fromdate as date)) then 'firstpositive'
            when a.finalhivtestresult = 'HIV+' and (a.previousresult = 'HIV+' and a.previousresultdate < cast($fromdate as date)) then 'repeatpositive' else null end
            , a.gender
            , case when a.ageattest < 15 then '<15' else '15+' end");
        } catch (\Throwable $th) {
        }
    }

    public function get_patient_tpt($fromdate,$todate)
    {
        try {
            return DB::select("");
        } catch (\Throwable $th) {  
        }   
    }

    public function get_cummulative_clients($fromdate)
    {
        try {
            return DB::select("");
        } catch (\Throwable $th) {  
        }   
    }

    public function get_clinical_workload()
    {
        try {
            return DB::select("");
        } catch (\Throwable $th) {  
        }   
    }
    public function get_antitb_treatment($fromdate,$todate)
    {
        try {
            return DB::select("
            ");
        } catch (\Throwable $th) {  
        }  
    }
   


}
