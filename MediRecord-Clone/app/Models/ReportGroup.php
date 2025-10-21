<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportGroup extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "reportgroups";

    public $fillable = ['reportgroupid','reportgroupname', 'position'];

    public function reportgroups()
    {
        return $this::select('reportgroupid','reportgroupname')->get();
    }

    public function reportgroupname()
    {
        return $this::select('reportgroupname','reportgroupid')->get();
    }

    public function reportgroup($reportgroupid)
    {
        return $this::where('reportgroupid','=', $reportgroupid)->select('reportgroupname','reportgroupid')->get();
    }

    public function reports($reportgroupid)
    {
        return Report::where('reportgroupid','=', $reportgroupid)->select('reportname', 'reportid','querygroupid','exceltemplatename')->get();
    }

    public function queryid($querygroupid)
    {
        return QueryGroupLink::where('querygroupid','=', $querygroupid)->select('queryid')->first();
    }

    public function querydata($querygroupid)
    {
        return QueryGroupLink::where('querygroupid','=', $querygroupid)->select('queryid')->get();
    }

    public function reportname($querygroupid)
    {
        return Report::where('querygroupid','=', $querygroupid)->select('reportname')->first();
    }


    public function querydefintion($queryid)
    {
        return Query::where('queryid','=', $queryid)->select('queryid','queryname','querydefinition')->first();
    }
}
