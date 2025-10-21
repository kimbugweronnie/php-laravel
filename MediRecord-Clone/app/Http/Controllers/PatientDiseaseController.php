<?php

namespace App\Http\Controllers;

use App\Services\PatientDiseaseService;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class PatientDiseaseController
{
    private $patientdiseaseservice;
    public function __construct(PatientDiseaseService $patientdiseaseservice) {
        $this->patientdiseaseservice = $patientdiseaseservice;
    }

    public function gethivrelatedcancer()
    {
        return $this->patientdiseaseservice->gethivrelatedcancer();
    }

    public function getcryptococcalmeningitis()
    {
        return $this->patientdiseaseservice->getcryptococcalmeningitis();
    }

    public function gettbscreening()
    {
        return $this->patientdiseaseservice->gettbscreening();
    }
    
    public function gettbtreatment()
    {
        return $this->patientdiseaseservice->gettbtreatment();
    }

    public function getcacxscreening()
    {
        return $this->patientdiseaseservice->getcacxscreening();
    }
   

    


}
