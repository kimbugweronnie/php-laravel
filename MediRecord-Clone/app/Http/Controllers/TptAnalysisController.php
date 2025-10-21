<?php

namespace App\Http\Controllers;

use App\Services\TptAnalysisService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class TptAnalysisController extends Controller
{
    private $tptanalysisservice;
    public function __construct(TptAnalysisService $tptanalysisservice) {
        $this->tptanalysisservice = $tptanalysisservice;
    }
    
    public function gettptanalysis()
    {
        return $this->tptanalysisservice->gettptanalysis();
    }
}