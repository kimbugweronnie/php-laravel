<?php

namespace App\Http\Controllers;

use App\Services\ProgramReportService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class ProgramReportController 
{
    private $programreportservice;
    public function __construct(ProgramReportService $programreportservice) {
        $this->programreportservice = $programreportservice;
    }

    public function index()
    {
        return $this->programreportservice->gettmppatientmaster();
    }

    public function hmis106reportheader(TmpPatientRequest $request)
    {
        return $this->programreportservice->hmis106reportheader($request->fromdate,$request->todate);
    }

    public function getcotreportdata(TmpPatientRequest $request)
    {
        return $this->programreportservice->getcotsummarydata($request->fromdate,$request->todate);
    }

    public function getcotsummarydata(TmpPatientRequest $request)
    {
        return $this->programreportservice->getcotsummarydata($request->fromdate,$request->todate);   
    }

    public function getdsddata(TmpPatientRequest $request)
    {
        return $this->programreportservice->getdsddata($request->fromdate,$request->todate); 
    }
    
}
