<?php

namespace App\Services;

use App\Models\Query;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ViralLoadMonitoryingService extends Controller
{
    private $query;
    public function __construct(Query $query) {
        $this->query = $query;
    }

    public function viralloadpatients($fromdate,$todate)
    {
        DB::select(DB::raw("SET @p0='$fromdate';"));
        DB::select(DB::raw("SET @p1='$todate';"));
        $querydata = DB::select(DB::raw("CALL ''"));
        $data = is_array($querydata) ? $this->sendresponse($querydata, 200) : $this->sendmessage(Null, 404);
        return $data; 
    }

    public function detectableviralload()
    {
        $querystatement=$this->query->detectableviralload();
        $querydata = DB::select(DB::raw($querystatement->querydefinition));
        $data = is_array($querydata) ? $this->sendresponse($querydata, 200) : $this->send_message(Null, 404);
        return $data; 
    }
}