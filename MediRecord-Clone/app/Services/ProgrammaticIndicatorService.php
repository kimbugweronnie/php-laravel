<?php

namespace App\Services;

use App\Models\ProgrammaticIndicator;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgrammaticIndicatorService extends Controller
{
    private $programmaticIndicator;
    public function __construct(ProgrammaticIndicator $programmaticIndicator) {
        $this->programmaticIndicator = $programmaticIndicator;
    }
    
    public function get_all_artpatient()
    {
        $tpatient=$this->programmaticIndicator->get_all_artpatient();
        $get_all_artpatient=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $get_all_artpatient;
    }

    public function get_all_art_terminations()
    {
        $tpatient=$this->programmaticIndicator->get_all_art_terminations();
        $get_all_art_terminations=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $get_all_art_terminations;
    }

    public function get_art_start($fromdate,$todate)
    {
        $tpatient=$this->programmaticIndicator->get_art_start($fromdate,$todate);
        $get_all_artpatient=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $get_all_artpatient;
    }

    public function get_enrollments_by_entrypoint($fromdate,$todate)
    {
        $tpatient=$this->programmaticIndicator->get_enrollments_by_entrypoint($fromdate,$todate);
        $get_pediatric_patients=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $this->send_response($tpatient, 200);
    }

    public function get_enrollments_by_month($fromdate,$todate)
    {
        $tpatient=$this->programmaticIndicator->get_enrollments_by_month($fromdate,$todate);
        $get_pediatric_patients=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $this->send_response($tpatient, 200);
    }

    public function currentlyonsecondline()
    {
        $tpatient=$this->programmaticIndicator->currentlyonsecondline();
        $currentlyonsecondline=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $this->send_response($tpatient, 200);
    }

    public function get_forms_computerized()
    {
        $tpatient=$this->programmaticIndicator->get_forms_computerized();
        $get_pediatric_patients=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $this->send_response($tpatient, 200);
    }
    
    public function get_patients_starting_art($fromdate,$todate)
    {
        $tpatient=$this->programmaticIndicator->get_patients_starting_art($fromdate,$todate);
        $get_pediatric_patients=is_null($tpatient) ? $this->send_response(Null, 200):$this->send_response($tpatient, 200);
        return $this->send_response($tpatient, 200);
    }
}
