<?php

namespace App\Services;

use App\Models\ProgramReport;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramReportService extends Controller
{
    private $programreport;
    public function __construct(ProgramReport $programreport) {
        $this->programreport=$programreport;
    }

    public function hmis106reportheader($fromdate,$todate)
    {
        $tmp_patients=$this->programreport->hmis_106_report_header($fromdate,$todate);
        $hmis_106_report_header=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $hmis_106_report_header;    
    }

    public function getcotreportdata($fromdate,$todate)
    {
        $tmp_patients=$this->programreport->get_cot_report($fromdate,$todate);
        $get_cot_summary_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_cot_summary_data;
    }

    public function getcotsummarydata($fromdate,$todate)
    {
        $tmp_patients=$this->programreport->get_cot_summary_report($fromdate,$todate);
        $get_cot_summary_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_cot_summary_data;
    }

    public function getdsddata($fromdate,$todate)
    {
        $tmp_patients=$this->programreport->get_dsd_data($fromdate,$todate);
        $get_dsd_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_dsd_data;   
    }

    public function gethibriddata()
    {
        $tmp_patients=$this->programreport->get_hibrid_data();
        $get_hibrid_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_hibrid_data;
    }

    public function gethmisdata()
    {
        $tmp_patients=$this->programreport->get_hmis_data();
        $get_hmis_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_hmis_data;
    }

    public function gethtsdata($fromdate,$todate)
    { 
        $tmp_patients=$this->programreport->get_hts_data($fromdate,$todate);
        $get_hts_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_hts_data;
    }

    public function getsurgedata($fromdate,$todate)
    {
        $tmp_patients=$this->programreport->get_surge_data($fromdate,$todate);
        $get_dsd_data=is_null($tmp_patients) ? $this->send_response(Null, 200):$this->send_response($tmp_patients, 200);
        return $get_dsd_data;
    }
    
}
