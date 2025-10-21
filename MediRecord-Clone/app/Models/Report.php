<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
   
    protected $table = "reports";


    public $fillable = ['reportid','reportdisplayname','reportgroupid','querygroupid','exceltemplatename','reportpassword'];

    public function names()
    {
        return $this::select('reportgroupname')->get();
    }

    public function reports($reportgroupid)
    {
        return $this::where('reportgroupid','=', $reportgroupid)->select('reportname','querygroupid')->get();
    }
    
    public function reportgroup()
    {
        return $this->belongsTo(ReportGroup::class);
    }

    public function querygroup()
    {
        return $this->hasOne(QueryGroup::class);
    }

    public function querygroups()
    {
        return QueryGroup::where('querygroupid','=', $this->querygroupid)->select('querygroupname')->first()->querygroupname;
    }
    
    public function querygrouplinks($querygroupid)
    {
        return QueryGroupLink::where('querygroupid','=', $querygroupid)->select('queryid')->first()->queryid;
    }
    
    



}
