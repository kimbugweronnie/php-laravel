<?php

namespace App\Services;

use App\Models\Query;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TreatmentAdherenceService extends Controller
{
    private $report;
    private $query;
    public function __construct(Query $query) {
        $this->query = $query;
    }
    
    public function missedarvpickup($todate,$numdays)
    {
        $querystatement=$this->query->missedarvpickup();
        if(strpos($querystatement->querydefinition, '@numdays') !== false){
            $querystatement->querydefinition = str_replace('@numdays', $numdays, $querystatement->querydefinition);
        }
        if(strpos($querystatement->querydefinition, '@todate') !== false){
            $querystatement->querydefinition = str_replace('@todate',  "'$todate'", $querystatement->querydefinition);
        }
        $querydata = DB::select(DB::raw($querystatement->querydefinition));
        $data = is_array($querydata) ? $this->send_response($querydata, 200) : $this->send_message(Null, 404);
        return $data;
    }

    public function missedappointments($todate,$numdays)
    {
        $querystatement=$this->query->missedappoitments();
        if(strpos($querystatement->querydefinition, '@numdays') !== false){
            $querystatement->querydefinition = str_replace('@numdays', $numdays, $querystatement->querydefinition);
        }
        if(strpos($querystatement->querydefinition, '@todate') !== false){
            $querystatement->querydefinition = str_replace('@todate', "'$todate'", $querystatement->querydefinition);
        }
        $querydata = DB::select(DB::raw($querystatement->querydefinition));
        $data = is_array($querydata) ? $this->send_response($querydata, 200) : $this->send_message(Null, 404);
        return $data;
    }

    public function appointments($appointmentdate)
    {
        $querystatement=$this->query->appointments();
        if(strpos($querystatement->querydefinition, '@appointmentdate') !== false){
            $querystatement->querydefinition = str_replace('@appointmentdate', "'$appointmentdate'", $querystatement->querydefinition);
        }
        $querydata = DB::select(DB::raw($querystatement->querydefinition));
        $data = is_array($querydata) ? $this->send_response($querydata, 200) : $this->send_message(Null, 404);
        return $data;
    }
}
