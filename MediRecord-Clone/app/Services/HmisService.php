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

class HmisService extends Controller
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
    

    public function hmisreport($querygroupid,$fromdate,$todate)
    {
        $error = [];
        $fn = [];
        // $bad = [];
        $data =[];
        $querydata = [];
        $queries=$this->reportgroup->querydata($querygroupid);
        foreach ($queries as $queryid) {
            $querydefintions = $this->reportgroup->querydefintion($queryid->queryid);
            array_push($querydata,[$querydefintions->queryid,$querydefintions->queryname,$querydefintions->querydefinition]);
        } 
        foreach ($querydata as $query) {
            if(strpos($query[2],' interval -6 month') !== false ){
                array_push($error,[$query[1],$query[2]]);
            }
            else{
                array_push($fn,[$query[1],$query[2]]);
            } 
        } 
        foreach ($error as $record){
            if(strpos($record[1], '@fromdate') !== false){
                $record[1] = str_replace('@fromdate', "$fromdate", $record[1]);
            }  
            if(strpos($record[1], '@todate') !== false){
                $record[1] = str_replace('@todate', "$todate", $record[1]);
            }
            // array_push($bad,[$query[1],$record[1]]);
        }
        foreach ($fn as $record) {
            if(strpos($record[1], '@fromdate') !== false){
                $record[1] = str_replace('@fromdate', "'$fromdate'", $record[1]);
            }  
            if(strpos($record[1], '@todate') !== false){
                $record[1] = str_replace('@todate', "'$todate'", $record[1]);
            }
            $querydata = DB::select(DB::raw($record[1]));
            array_push($data,[$record[0]=>$querydata]);
        }
        $bad = $this->get48data();
        return $this->send_response([$data,$bad], 200);

    }

}
