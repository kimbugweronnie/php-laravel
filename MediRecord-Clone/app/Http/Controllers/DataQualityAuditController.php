<?php

namespace App\Http\Controllers;

use App\Services\DataQualityAuditService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class DataQualityAuditController 
{
    private $dataqualityauditservice;
    public function __construct(DataQualityAuditService $dataqualityauditservice) {
        $this->dataqualityauditservice = $dataqualityauditservice;
    }

    public function getmissingartstart()
    {
        return $this->dataqualityauditservice->get_missing_art_start();
    }

    public function getdirtydates()
    {
        return $this->dataqualityauditservice->get_dirty_dates();
    }

    public function getmissingregimenswitch()
    {
        return $this->dataqualityauditservice->get_missing_regimen_switch();
    }

    public function getvlmissingdate()
    {
        return $this->dataqualityauditservice->get_vl_missingdate();
    }

    public function gettbdiagnosis()
    {
        return $this->dataqualityauditservice->get_tb_diagnosis();
    }

    public function getmissingtptstartdate()
    {
        return $this->dataqualityauditservice->get_missingtpt_startdate();
    }
    
}
