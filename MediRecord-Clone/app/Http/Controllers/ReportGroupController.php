<?php

namespace App\Http\Controllers;
use App\Services\ReportGroupService;
use App\Services\TreatmentAdherenceService;
use App\Services\ViralLoadMonitoryingService;
use App\Services\SurgeReportService;
use App\Services\DsdmService;
use App\Services\HibridService;
use App\Services\Hmisv2Service;
use App\Services\HmisService;
use App\Services\CotReportService;
use App\Services\HtsService;
use App\Services\CotSummaryReportService;
use Illuminate\Http\Request;
use App\Http\Resources\ReportGroupResource;

class ReportGroupController extends Controller
{

  private $reportgroupservice;
  private $treatmentadherenceservice;
  private $viralloadmonitoryservice;
  private $surgereportservice;
  private $hibridservice;
  private $hmisv2service;
  private $hmisservice;
  private $cotreportservice;
  private $cotsummaryreportservice;
  private $htsservice;
  public function __construct(ReportGroupService $reportgroupservice, 
  TreatmentAdherenceService $treatmentadherenceservice, 
  ViralLoadMonitoryingService $viralloadmonitoryservice, SurgeReportService $surgereportservice, 
  DsdmService $dsdmservice,HibridService $hibridservice,Hmisv2Service $hmisv2service,
  HmisService $hmisservice, CotReportService $cotreportservice,CotSummaryReportService $cotsummaryreportservice,HtsService $htsservice) {
      $this->reportgroupservice = $reportgroupservice;
      $this->treatmentadherenceservice = $treatmentadherenceservice;
      $this->viralloadmonitoryservice = $viralloadmonitoryservice;
      $this->surgereportservice = $surgereportservice;
      $this->dsdmservice = $dsdmservice;
      $this->hibridservice = $hibridservice;
      $this->hmisv2service = $hmisv2service;
      $this->hmisservice = $hmisservice;
      $this->htsservice = $htsservice;
      $this->cotreportservice = $cotreportservice;
      $this->cotsummaryreportservice = $cotsummaryreportservice; 
  }

  public function report(Request $request)
  {
    return $this->reportgroupservice->reportsdata(); 
  }
  
  public function reportsdata(Request $request)
  {
    if($request->querygroupid == 31 || $request->querygroupid == 30 ){
      return $this->cotreportservice->cotreport($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 15){
      return $this->hmisservice->hmisreport($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 33){
      return $this->dsdmservice->dsdmreport($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 34){
      return $this->hibridservice->hibridreport($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 35){
      return $this->hmisv2service->hmisv2report($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 36){
      return $this->htsservice->htsreport($request->querygroupid,$request->fromdate,$request->todate);
    }
    elseif($request->querygroupid == 44){
      return $this->surgereportservice->surgereport($request->querygroupid,$request->fromdate,$request->todate);
    }
    else{
      return $this->reportgroupservice->getdatawithparameters($request->querygroupid,$request->fromdate,$request->todate);
    }
    // if($request->todate){
    //   return $this->reportgroupservice->getdatawithparameters($request->querygroupid,$request->fromdate,$request->todate);
    // }

    // return $this->reportgroupservice->querystatement($request->querygroupid);
  }

  public function surgereport(Request $request)
  {
    
  }

  public function dsdmreport(Request $request)
  {
    return $this->dsdmservice->dsdmreport($request->querygroupid,$request->fromdate,$request->todate);
  }

  public function hybridreport(Request $request)
  {
    
  }

  // public function hmisreport(Request $request)
  // {
  //   return $this->hmisservice->hmisreport($request->querygroupid,$request->fromdate,$request->todate);
  // }

  public function hmisv2report(Request $request)
  {
    
  }

  public function cotreport(Request $request)
  {
    return $this->cotreportservice->cotreport($request->querygroupid,$request->fromdate,$request->todate);
  }

  public function cotsummaryreport(Request $request)
  {
   
    return $this->cotsummaryreportservice->cotsummaryreport($request->querygroupid,$request->fromdate,$request->todate);
  }

  public function htsreport(Request $request)
  {
    
  }

  public function testing(Request $request)
  {
    return $this->reportgroupservice->test($request->queryid,$request->fromdate,$request->todate);
  }

  public function missedarvpickup(Request $request)
  {
    return $this->treatmentadherenceservice->missedarvpickup($request->todate,$request->numdays);
  }

  public function missedappointments(Request $request)
  {
    return $this->treatmentadherenceservice->missedappointments($request->todate,$request->numdays);
  }

  public function appointments(Request $request)
  {
    return $this->treatmentadherenceservice->appointments($request->appointmentdate);
  }

  public function viralloadpatients(Request $request)
  {
    return $this->viralloadmonitoryservice->viralloadpatients($request->fromdate,$request->todate);
  }

  public function detectableviralload()
  {
    return $this->viralloadmonitoryservice->detectableviralload();
  }

}
