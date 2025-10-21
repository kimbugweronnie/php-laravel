<?php

namespace App\Http\Controllers;

use App\Services\PmtctReportService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class PmtctReportController extends Controller
{
    private $pmtctreportservice;
    public function __construct(PmtctReportService $pmtctreportservice) {
        $this->pmtctreportservice = $pmtctreportservice;
    }
    
    public function getpmtctcascade(TmpPatientRequest $request)
    {
        return $this->pmtctreportservice->getpmtctcascade($request->fromdate,$request->todate);
    }

    public function getpmtctpartnertesting(TmpPatientRequest $request)
    {
        return $this->pmtctreportservice->getpmtctpartnertesting($request->fromdate,$request->todate);
    }

    public function getpmtctvl(TmpPatientRequest $request)
    {
        return $this->pmtctreportservice->getpmtctvl($request->fromdate,$request->todate);
    }

    public function getpmtcteid(TmpPatientRequest $request)
    {
        return $this->pmtctreportservice->getpmtcteid($request->fromdate,$request->todate);

    }
}
