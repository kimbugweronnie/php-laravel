<?php

namespace App\Http\Controllers;

use App\Services\VlReportService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class VlReportController extends Controller
{
    private $vlreportservice;
    public function __construct(VlReportService $vlreportservice) {
        $this->vlreportservice = $vlreportservice;
    }
    
    public function getvlcascadeload()
    {
        return $this->vlreportservice->getvlcascadeload();
    }

    public function gethighvlreport(TmpPatientRequest $request)
    {
        return $this->vlreportservice->gethighvlreport($request->fromdate,$request->todate);
    }

    public function hmis106reportheader(TmpPatientRequest $request)
    {
        return $this->vlreportservice->hmis106reportheader($request->fromdate,$request->todate);
    }
}