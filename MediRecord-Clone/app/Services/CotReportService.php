<?php
namespace App\Services;
use App\Models\ReportGroup;
use App\Models\Report;
use App\Models\QueryGroupLink;
use App\Models\Query;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\PatientUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PatientResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \Carbon\Carbon;
use App\Services\TemplateService;
use Response;

class CotReportService extends Controller
{
    private $reportgroup;
    private $report;
    private $reports;
    private $querygrouplink;
    private $query;
    private $querygrouplinks;
    private $templateservice;

    public function __construct(ReportGroup $reportgroup, Report $report, QueryGroupLink $querygrouplink,Query $query,TemplateService $templateservice) {
        $this->reportgroup = $reportgroup;
        $this->report = $report;
        $this->querygrouplink = $querygrouplink;
        $this->query = $query; 
        $this->templateservice = $templateservice;   
    }
    public function getqueries($querygroupid,$fromdate,$todate)
    {
        $queries=$this->reportgroup->querydata($querygroupid);
        return $queries;
    }

    public function getquerydefinition($querygroupid,$fromdate,$todate)
    {
        $querydata = [];
        $queries=$this->getqueries($querygroupid,$fromdate,$todate);
        foreach ($queries as $queryid) {
            $querydefintions = $this->reportgroup->querydefintion($queryid->queryid);
            array_push($querydata,$querydefintions->querydefinition);
        }
        return $querydata;
    }
    

    public function report($querygroupid,$fromdate,$todate)
    {
        $data = [];
        $contentdata = [];
        $querydefinitions=$this->getquerydefinition($querygroupid,$fromdate,$todate);
        foreach ($querydefinitions as $querydefinition) {
            if(strpos($querydefinition, 'pr_') !== false ){
                $pr = $this->handlepr($querydefinition,$querygroupid,$fromdate,$todate);
                array_push($contentdata,$pr);
            }else{
                $fn = $this->handlefn($querydefinition,$querygroupid,$fromdate,$todate);
                array_push($contentdata,$fn);
            } 
        }
        return $contentdata;   
    } 

    public function cotreport($querygroupid,$fromdate,$todate)
    {
        $content = [];
        $contentdata = [];
        $data = [];
        $report = [];
        $reportname = $this->reportgroup->reportname($querygroupid);
        $name = $reportname ? $reportname->reportname : null;
        if($querygroupid == 31){
            $contentdata = $this->report($querygroupid,$fromdate,$todate);
            $facilityname = $contentdata[0];
            $contentdata = array_slice($contentdata,1);
            foreach ($contentdata as $totals) {
                if(isset($totals[0]->total)){
                    foreach ($totals as $total) {
                        array_push($data,$total);
                    }
                }
            }
            array_push($content,['facilityname'=> $facilityname,'data'=> $data]);
            array_push($report,['reportname'=> $name,"querygroupid"=>$querygroupid,"contentdata"=>$content]);
            return $this->send_response($report, 200);
        }
        if($querygroupid == 30){
            $contentdata = $this->report($querygroupid,$fromdate,$todate);
            $facilityname = $contentdata[0];
            $contentdata = array_slice($contentdata,1);
            foreach ($contentdata as $totals) {
                foreach ($totals as $total) {
                    array_push($data,$total);
                }
            }
            array_push($content,['facilityname'=> $facilityname,'data'=> $data]);
            array_push($report,['reportname'=> $name,"querygroupid"=>$querygroupid,"contentdata"=>$content]);
            return $this->send_response($report, 200);
        }else{
            $contentdata = $this->report($querygroupid,$fromdate,$todate);
            array_push($report,['reportname'=> $name,"querygroupid"=>$querygroupid,"contentdata"=>$contentdata[0]]);
            return $this->send_response($report, 200);
        }
        
    }


    public function handlefn($querydefinition,$querygroupid,$fromdate,$todate)
    {
        $data = [];
        if(strpos($querydefinition, '@fromdate') !== false){
            $querydefinition = str_replace('@fromdate', "'$fromdate'", $querydefinition);
        }  
        if(strpos($querydefinition, '@todate') !== false){
            $querydefinition = str_replace('@todate', "'$todate'", $querydefinition);
        }
        if(strpos($querydefinition, 'Patient_identifier') !== false ){
            $querydefinition = str_replace('Patient_identifier', "patient_identifier",$querydefinition);
        }   
        if(strpos($querydefinition, 'person_Name') !== false ){
        $querydefinition = str_replace('person_Name', "person_name",$querydefinition);
        }
        if(strpos($querydefinition, 'OBS') !== false ){
            $querydefinition = str_replace('OBS', "obs",$querydefinition);
        }
        if(strpos($querydefinition, 'PERSON_ID') !== false ){
            $querydefinition = str_replace('PERSON_ID', "person_id",$querydefinition);
        }
        if(strpos($querydefinition, 'Person_id') !== false ){
            $querydefinition = str_replace('Person_id', "person_id",$querydefinition);
        }
        if(strpos($querydefinition, 'P1.person_id') !== false ){
            $querydefinition = str_replace('P1.person_id', "p1.person_id",$querydefinition);
        }
        if(strpos($querydefinition, 't1.person_id') !== false ){
            $querydefinition = str_replace('t1.person_id', "T1.person_id",$querydefinition);
        }
        if(strpos($querydefinition, 't2.person_id') !== false ){
            $querydefinition = str_replace('t2.person_id', "T2.person_id",$querydefinition);  
        }
        if(strpos($querydefinition, 'f1.person_id') !== false ){
            $querydefinition = str_replace('f1.person_id', "F1.person_id",$querydefinition); 
        }     
        $querydata = DB::select(DB::raw($querydefinition));
        return $querydata;
        
    }


    public function handlepr($querydefintion,$querygroupid,$fromdate,$todate)
    {
        $data = [];
        $querydata = [];
        $statement="`$querydefintion`";
        if($fromdate){
            DB::select(DB::raw("SET @p0='$fromdate';"));        
        }
        if($todate){
            DB::select(DB::raw("SET @p1='$todate';"));    
        }
        if($fromdate){
            $querydata=DB::select(DB::raw("CALL $statement(@p0,@p1);"));       
        }else if ($todate){
            $querydata=DB::select(DB::raw("CALL $statement(@p1);"));   
        }else{
            $querydata=DB::select(DB::raw("CALL $statement();")); 
        }
        return $querydata;
    } 

    public function getexcel()
    {
        $date=date("d/M/Y",strtotime('3 hours'));
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        return Response::download($filepath);
   
    }
    
    

   







}