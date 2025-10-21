<?php

namespace App\Http\Controllers;

use App\Services\ScragReportService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class ScragReportController
{
    private $scragreportservice;
    public function __construct(ScragReportService $scragreportservice) {
        $this->scragreportservice = $scragreportservice;
    }
    
    public function getscragnew(TmpPatientRequest $request)
    {
        return $this->scragreportservice->getscragnew($request->fromdate,$request->todate);
    }

    public function getscragunsuppressed(TmpPatientRequest $request)
    {
        return $this->scragreportservice->getscragunsuppressed($request->fromdate,$request->todate);
    }
}