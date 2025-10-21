<?php
namespace App\Http\Controllers;

use App\Services\ProgrammaticIndicatorService;
use App\Models\ProgrammaticIndicator;
use App\Http\Requests\TmpPatientRequest;
use App\Http\Requests\DsdRequest;
use Illuminate\Http\Request;

class ProgrammaticIndicatorController 
{
    private $programmaticindicatorservice;
    public function __construct(ProgrammaticIndicatorService $programmaticindicatorservice) {
        $this->programmaticindicatorservice = $programmaticindicatorservice;
    }
    
    public function getallartpatient()
    {
        return $this->programmaticindicatorservice->getallartpatient();
    }

    public function getallartterminations()
    {
        return $this->programmaticindicatorservice->getallartterminations();
    }

    public function getartstart(TmpPatientRequest $request)
    {
        return $this->programmaticindicatorservice->getartstart($request->fromdate,$request->todate);
    }

    public function getenrollmentsbyentrypoint(TmpPatientRequest $request)
    {
        return $this->programmaticindicatorservice->getenrollmentsbyentrypoint($request->fromdate,$request->todate);
    }

    public function getenrollmentsbymonth(TmpPatientRequest $request)
    {
        return $this->programmaticindicatorservice->getenrollmentsbymonth($request->fromdate,$request->todate);
    }

    public function getformscomputerized()
    {
        return $this->programmaticindicatorservice->getformscomputerized();
    }
    
    public function getpatientsstartingart(TmpPatientRequest $request)
    {
        return $this->programmaticindicatorservice->getpatientsstartingart($request->fromdate,$request->todate);
    }

    public function currentlyonsecondline()
    {
        return $this->programmaticindicatorservice->currentlyonsecondline();
    }
}
