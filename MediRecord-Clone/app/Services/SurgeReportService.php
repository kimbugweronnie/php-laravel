<?php

namespace App\Services;

use App\Models\ReportGroup;
use App\Models\Report;
use App\Models\QueryGroupLink;
use App\Models\Query;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SurgeReportService extends Controller
{
    private $reportgroup;
    private $report;
    private $reports;
    private $querygrouplink;
    private $query;
    private $querygrouplinks;

    public function __construct(ReportGroup $reportgroup, Report $report, QueryGroupLink $querygrouplink,Query $query) {
        $this->reportgroup = $reportgroup;
        $this->report = $report;
        $this->querygrouplink = $querygrouplink;
        $this->query = $query;    
    }
    
    public function surgereport($querygroupid,$fromdate,$todate)
    {
        $querydata = [];
        $error = [];
        $fn = [];
        $data =[];
        $queries=$this->reportgroup->querydata($querygroupid);
        foreach ($queries as $queryid) {
            $querydefintions = $this->reportgroup->querydefintion($queryid->queryid);
            array_push($querydata,[$querydefintions->queryid,$querydefintions->queryname,$querydefintions->querydefinition]);
        }
        foreach ($querydata as $query) {
            if($query[0]==279){
                array_push($error,$query[0],$query[2]);

            }elseif($query[0]==281){
                array_push($error,$query[0],$query[2]);

            }elseif($query[0]==283){
                array_push($error,$query[0],$query[2]);
                
            }elseif($query[0]==285){
                array_push($error,$query[0],$query[2]);
                
            }else{
                array_push($fn,[$query[1],$query[2]]);
            } 
        }
        
        foreach ($fn as $record) {
            if(strpos($record[1], '@fromdate') !== false){
                $record[1] = str_replace('@fromdate', "'$fromdate'", $record[1]);
            }  
            if(strpos($record[1], '@todate') !== false){
                $record[1] = str_replace('@todate', "'$todate'", $record[1]);
            }
            if(strpos($record[1], 'Patient_identifier') !== false ){
                $record[1] = str_replace('Patient_identifier', "patient_identifier",$record[1]);
            }   
            if(strpos($record[1], 'person_Name') !== false ){
            $record[1] = str_replace('person_Name', "person_name",$record[1]);
            }
            if(strpos($record[1], 'OBS') !== false ){
                $record[1] = str_replace('OBS', "obs",$record[1]);
            }
            if(strpos($record[1], 'PERSON_ID') !== false ){
                $record[1] = str_replace('PERSON_ID', "person_id",$record[1]);
            }
            if(strpos($record[1], 'Person_id') !== false ){
                $record[1] = str_replace('Person_id', "person_id",$record[1]);
            }
            if(strpos($record[1], 'P1.person_id') !== false ){
                $record[1] = str_replace('P1.person_id', "p1.person_id",$record[1]);
            }
            if(strpos($record[1], 't1.person_id') !== false ){
                $record[1] = str_replace('t1.person_id', "T1.person_id",$record[1]);
            }
            if(strpos($record[1], 't2.person_id') !== false ){
                $record[1] = str_replace('t2.person_id', "T2.person_id",$record[1]);  
            }
            if(strpos($record[1], 'f1.person_id') !== false ){
                $record[1] = str_replace('f1.person_id', "F1.person_id",$record[1]); 
            }     
            $querydata = DB::select(DB::raw($record[1]));
            array_push($data,[$record[0]=>$querydata]);
        }
        return $this->send_response([$data,$error], 200);
    }
        
        
}