<?php

namespace App\Http\Controllers;

use App\Services\PediatricsService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class PediatricsController 
{
    private $pediatricsservice;
    public function __construct(PediatricsService $pediatricsservice) {
        $this->pediatricsservice = $pediatricsservice;
    }
    
    public function getpediatricpatients()
    {
        return $this->pediatricsservice->getpediatricpatients();
    }

}