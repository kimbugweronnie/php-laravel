<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;

class PatientController extends Controller
{
    private $patientservice;
    public function __construct(PatientService $patientservice) {
        $this->patientservice = $patientservice;
    }
    
    public function index()
    {
        return $this->sendresponse($this->patientservice->getpatients(), 200);
    }

    public function show($id)
    {
        return $this->patientservice->getpatient($id);
    }

    
}
