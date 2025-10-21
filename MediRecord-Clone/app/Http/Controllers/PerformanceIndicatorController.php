<?php

namespace App\Http\Controllers;

use App\Services\PerformanceIndicatorService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class PerformanceIndicatorController 
{
    private $performanceindicatorservice;
    public function __construct(PerformanceIndicatorService $performanceindicatorservice) {
        $this->performanceindicatorservice = $performanceindicatorservice;
    }
    
    public function getarttransferin()
    {
        return $this->performanceindicatorservice->getarttransferin();
    }

    public function getmonthsonart()
    {
        return $this->performanceindicatorservice->getmonthsonart();
    }

    public function getmonthsonpreart()
    {
        return $this->performanceindicatorservice->getmonthsonpreart();
    }

    public function getregimenswitch()
    {
        return $this->performanceindicatorservice->getregimenswitch();
    }

    public function getactivetbatenrollment()
    {
        return $this->performanceindicatorservice->getactivetbatenrollment();
    }

    public function getactivetbnotonart()
    {
        return $this->performanceindicatorservice->getactivetbnotonart();
    }
}
