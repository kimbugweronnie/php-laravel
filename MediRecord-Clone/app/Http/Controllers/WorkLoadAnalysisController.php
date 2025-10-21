<?php

namespace App\Http\Controllers;

use App\Services\WorkLoadAnalysisService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class WorkLoadAnalysisController 
{
    private $workloadanalysisservice;
    public function __construct(WorkLoadAnalysisService $workloadanalysisservice) {
        $this->workloadanalysisservice = $workloadanalysisservice;
    }
    
    public function getclinicalworkload()
    {
        return $this->workloadanalysisservice->get_clinical_workload();
    }

    public function getvisitsworkload(TmpPatientRequest $request)
    {
        return $this->workloadanalysisservice->get_visits_workload($request->fromdate,$request->todate);
    }

}