<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TmpPatientMaster extends Model
{
    use HasFactory;
    protected $table = "tmp_patient_masters";

    protected $fillable = [
        'patientpk','facilityname','gender','dob','patientname','registrationdate',
        'ageenrollment' ,'lastvisitdate','agelastvisit','phonenumber' ,'district','county','subcounty','parish',
        'village','maritalstatus',
    ];
       
    public function get_tmp_patients_masters()
    {
        return $this::all(); 
    }

    public function get_tmp_patients_master($id)
    {
        return $this::where('id',$id)->first();
    }

    public function hmis_106_report_header($fromdate,$todate)
    {
        $faciltyname = $this::select('facilityname')->first();
        return $faciltyname;
        // return $this::whereBetween('lastvisitdate', [$todate, $todate])->select('facilityname')->first();
    }


    public function cot_report()
    {
        $faciltyname = $this::select('facilityname')->first();
        return $faciltyname;
    }

    public function cot_report_summary()
    {
        $faciltyname = $this::select('facilityname')->first();
        return $faciltyname;
    }

    public function hts_data($fromdate,$todate,$hibrid)
    {
        $data = DB::table('tmp_hts as a')
            ->select(
                'b.gender',
                DB::raw("fn_getagegroup(datediff(a.visitdate, b.dob)/365.0,'HIBRID') as agegroup"),
                DB::raw("'tested' as category"),
                DB::raw("count(distinct a.patientpk) as total")
            )
            ->join('tmp_patientmaster as b', 'a.patientpk', '=', 'b.patientpk')
            ->whereBetween('a.visitdate', [DB::raw("cast($fromdate as date)"), DB::raw("cast($todate as date)")])
            ->where('a.facilityentrypoint', 'Ward')
            ->where('a.finalhivtestresult', 'HIV+')
            ->where(function($query) use ($fromdate) {
                $query->whereNull('a.previousresult')
                      ->orWhere('a.previousresult', 'HIV-')
                      ->orWhere('a.previousresultdate', '>=', DB::raw("cast($fromdate as date)"));
            })
            ->whereExists(function($query) use ($fromdate, $todate) {
                $query->select(DB::raw(1))
                      ->from('tmp_hivpatients as b')
                      ->whereRaw('a.patientpk = b.patientpk')
                      ->whereBetween('b.registrationdate', [DB::raw("cast($fromdate as date)"), DB::raw("cast($todate as date)")]);
            })
            ->groupBy(DB::raw("fn_getagegroup(datediff(a.visitdate, b.dob)/365.0,'HIBRID')"), 'b.gender')
            ->get();

            $newPositive = clone $data;
            $linked = clone $data;
            $data = $data->union($newPositive->update(['category' => 'newpositive']))
             ->union($linked->update(['category' => 'linked']));

    }
}
