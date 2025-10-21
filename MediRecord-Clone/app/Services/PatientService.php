<?php	
namespace App\Services;	
use App\Models\Query;	
use App\Http\Requests\PatientRequest;	
use App\Http\Requests\PatientUpdateRequest;	
use Illuminate\Support\Facades\Auth;	
use App\Http\Resources\PatientResource;	
use App\Http\Controllers\Controller;	
use Illuminate\Support\Facades\DB;	

class PatientService extends Controller	
{	
    private $query;	
    public function __construct(Query $query) {	
        $this->query = $query;	
    }	

    public function getpatients()	
    {	
        $query=$this->query->allpatients();	
        $querydata = DB::select(DB::raw($query->querydefinition));	
        return $querydata;	
    }
}