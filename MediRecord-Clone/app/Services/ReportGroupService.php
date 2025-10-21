<?php


namespace App\Services;

use App\Models\ReportGroup;
use App\Models\Report;
use App\Models\QueryGroupLink;
use App\Models\Query;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportGroupResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class ReportGroupService extends Controller
{
    private $reportgroup;
    private $report;
    private $reports;
    private $querygrouplink;
    private $query;
    private $querygrouplinks;

    public function __construct(ReportGroup $reportgroup, Report $report, QueryGroupLink $querygrouplink,Query $query) {
        $this->reportgroup = $reportgroup;
        $this->report = $report;
        $this->querygrouplink = $querygrouplink;
        $this->query = $query;    
    }

    public function reportgroups()
    {
        return $this->reportgroup->reportgroups();
    }
    
    public function test($queryid,$fromdate,$todate)
    {
       
        $query = $this->getqueries();  
        
        
        if(strpos($query, '@fromdate') !== false){
            $query = str_replace('@fromdate', "'$fromdate'", $query);
        }  
        if(strpos($query, '@todate') !== false){
            $query = str_replace('@todate', "'$todate'", $query);
        }
        $querydata = DB::select($query);
        return $querydata;

        // $queryid = $this->query->querydefintion($queryid);  
        
        // if(strpos($queryid['querydefinition'], '@fromdate') !== false){
        //     $queryid['querydefinition'] = str_replace('@fromdate', "'$fromdate'", $queryid['querydefinition']);
        // }  
        // if(strpos($queryid['querydefinition'], '@todate') !== false){
        //     $queryid['querydefinition'] = str_replace('@todate', "'$todate'", $queryid['querydefinition']);
        // }
        // $querydata = DB::select(DB::raw($queryid['querydefinition']));
        // return $querydata;
    }

    public function getreportgroup($reportgroupid)
    {
        return ReportGroupResource::collection($this->reportgroup->reportgroup($reportgroupid));   
    }

    public function getreports($reportgroupid)
    {
        $reports=$this->reportgroup->reports($reportgroupid); 
        return $reports;  
    }
    
    public function reportsdata()
    {
        return ReportGroupResource::collection($this->reportgroups()); 
    }

    public function querystatement($querygroupid)
    {
        $query=$this->reportgroup->querydata($querygroupid);
        $querystatement=$this->reportgroup->querydefintion($query[0]->queryid);
        return $querystatement;
    }

    public function getdata($querygroupid)
    {
        $data = [];
        $querystatement = $this->querystatement($querygroupid);
        $querydata = DB::select(DB::raw($querystatement->querydefinition));
        $reportname = $this->reportgroup->reportname($querygroupid);
        $name = $reportname ? $reportname->reportname : null;
        array_push($data,['reportname'=> $name,"querygroupid"=>$querygroupid,"contentdata"=>$querydata]);
        return $this->send_response($data, 200);
    }

    public function getquerydata($querygroupid)
    {
        $querydata = [];
        $queryids=$this->reportgroup->querydata($querygroupid);
        foreach ($queryids as $queryid) {
            $querydefintions = $this->reportgroup->querydefintion($queryid->queryid);
            array_push($querydata,[$querydefintions->queryid,$querydefintions->queryname,$querydefintions->querydefinition]);
        }
        return $querydata;
    }

    public function queryid($querygroupid,$fromdate,$todate)
    {
        $queries=$this->reportgroup->querydata($querygroupid);
        return $queries[0]->queryid;
    }

    public function querydefintion($querygroupid,$fromdate,$todate)
    {
        $queryid=$this->queryid($querygroupid,$fromdate,$todate);
        $query = $this->reportgroup->querydefintion($queryid);
        return $query['querydefinition'];
    }

    public function handlefn($querygroupid,$fromdate,$todate)
    {
        $querydefintion = $this->querydefintion($querygroupid,$fromdate,$todate);
        if(strpos($querydefintion, '@fromdate') !== false){
            $querydefintion = str_replace('@fromdate', "'$fromdate'", $querydefintion);
        }  
        if(strpos($querydefintion, '@todate') !== false){
            $querydefintion = str_replace('@todate', "'$todate'", $querydefintion);
        }
        if(strpos($querydefintion, 'Patient_identifier') !== false ){
            $querydefintion = str_replace('Patient_identifier', "patient_identifier",$querydefintion);
        }   
        if(strpos($querydefintion, 'person_Name') !== false ){
        $querydefintion = str_replace('person_Name', "person_name",$querydefintion);
        }
        if(strpos($querydefintion, 'OBS') !== false ){
            $querydefintion = str_replace('OBS', "obs",$querydefintion);
        }
        if(strpos($querydefintion, 'PERSON_ID') !== false ){
            $querydefintion = str_replace('PERSON_ID', "person_id",$querydefintion);
        }
        if(strpos($querydefintion, 'Person_id') !== false ){
            $querydefintion = str_replace('Person_id', "person_id",$querydefintion);
        }
        if(strpos($querydefintion, 'P1.person_id') !== false ){
            $querydefintion = str_replace('P1.person_id', "p1.person_id",$querydefintion);
        }
        if(strpos($querydefintion, 't1.person_id') !== false ){
            $querydefintion = str_replace('t1.person_id', "T1.person_id",$querydefintion);
        }
        if(strpos($querydefintion, 't2.person_id') !== false ){
            $querydefintion = str_replace('t2.person_id', "T2.person_id",$querydefintion);  
        }
        if(strpos($querydefintion, 'f1.person_id') !== false ){
            $querydefintion = str_replace('f1.person_id', "F1.person_id",$querydefintion); 
        }     
        $querydata = DB::select(DB::raw($querydefintion));
        return $querydata;
    }


    public function handlepr($querygroupid,$fromdate,$todate)
    {
        $querydata = [];
        $querydefintion = $this->querydefintion($querygroupid,$fromdate,$todate);
        $statement="`$querydefintion`";
        if($fromdate){
            DB::select(DB::raw("SET @p0='$fromdate';"));        
        }
        if($todate){
            DB::select(DB::raw("SET @p1='$todate';"));    
        }
        if($fromdate){
            $querydata=DB::select(DB::raw("CALL $statement(@p0,@p1);"));       
        }else if ($todate){
            $querydata=DB::select(DB::raw("CALL $statement(@p1);"));   
        }else{
            $querydata=DB::select(DB::raw("CALL $statement();")); 
        }
        return $querydata;  
    }
   
    public function getdatawithparameters($querygroupid,$fromdate,$todate)
    {
        $querydata = [];
        $data = [];
        $querydefintion = $this->querydefintion($querygroupid,$fromdate,$todate);
        if(strpos($querydefintion, 'pr_') !== false ){
            $querydata = $this->handlepr($querygroupid,$fromdate,$todate);
        }else{
            $querydata = $this->handlefn($querygroupid,$fromdate,$todate);
        }
        $reportname = $this->reportgroup->reportname($querygroupid);
        $name = $reportname ? $reportname->reportname : null;
        array_push($data,['reportname'=> $name,"querygroupid"=>$querygroupid,"contentdata"=>$querydata]);
        return $this->send_response($data, 200);
    }  

    public function reportsfilter($reportgroupid)
    {
        $reportsdata=[];
        foreach ($this->reports as $report) {
            if($report->reportgroupid===$reportgroupid){
                array_push($reportsdata, ['reportname' => $report->reportname, 'querygroupid' => $report->querygroupid]);  
            }  
        }
        return $reportsdata;  
    }

    public function handlefunctions($fromdate,$todate)
    {
        DB::select(DB::raw($querystatement->querydefinition));

    }

    public function getqueries()
    {
        return "select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m6.stopped) stopped
        , sum(m6.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m6.stopped) + sum(m6.died) + sum(m6.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m6.stopped) + sum(m6.died) + sum(m6.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)) m6,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m6emtct.stopped) stopped
        , sum(m6emtct.died) died
        , sum(m6emtct.missedappointment) missedappointment
        , sum(m6emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m6emtct.stopped) + sum(m6emtct.died) + sum(m6emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m6emtct.stopped) + sum(m6emtct.died) + sum(m6emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m6emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -6 month) and date_add(cast(@todate as date), interval - 6 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m12.stopped) stopped
        , sum(m12.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m12.stopped) + sum(m12.died) + sum(m12.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m12.stopped) + sum(m12.died) + sum(m12.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)) m12,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m12emtct.stopped) stopped
        , sum(m12emtct.died) died
        , sum(m12emtct.missedappointment) missedappointment
        , sum(m12emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m12emtct.stopped) + sum(m12emtct.died) + sum(m12emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m12emtct.stopped) + sum(m12emtct.died) + sum(m12emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m12emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -12 month) and date_add(cast(@todate as date), interval - 12 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m24.stopped) stopped
        , sum(m24.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m24.stopped) + sum(m24.died) + sum(m24.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m24.stopped) + sum(m24.died) + sum(m24.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)) m24,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m24emtct.stopped) stopped
        , sum(m24emtct.died) died
        , sum(m24emtct.missedappointment) missedappointment
        , sum(m24emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m24emtct.stopped) + sum(m24emtct.died) + sum(m24emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m24emtct.stopped) + sum(m24emtct.died) + sum(m24emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m24emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -24 month) and date_add(cast(@todate as date), interval - 24 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m36.stopped) stopped
        , sum(m36.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m36.stopped) + sum(m36.died) + sum(m36.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m36.stopped) + sum(m36.died) + sum(m36.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)) m36,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m36emtct.stopped) stopped
        , sum(m36emtct.died) died
        , sum(m36emtct.missedappointment) missedappointment
        , sum(m36emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m36emtct.stopped) + sum(m36emtct.died) + sum(m36emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m36emtct.stopped) + sum(m36emtct.died) + sum(m36emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m36emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -36 month) and date_add(cast(@todate as date), interval - 36 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m48.stopped) stopped
        , sum(m48.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m48.stopped) + sum(m48.died) + sum(m48.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m48.stopped) + sum(m48.died) + sum(m48.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)) m48,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m48emtct.stopped) stopped
        , sum(m48emtct.died) died
        , sum(m48emtct.missedappointment) missedappointment
        , sum(m48emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m48emtct.stopped) + sum(m48emtct.died) + sum(m48emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m48emtct.stopped) + sum(m48emtct.died) + sum(m48emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m48emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -48 month) and date_add(cast(@todate as date), interval - 48 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m60.stopped) stopped
        , sum(m60.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m60.stopped) + sum(m60.died) + sum(m60.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m60.stopped) + sum(m60.died) + sum(m60.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)) m60,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m60emtct.stopped) stopped
        , sum(m60emtct.died) died
        , sum(m60emtct.missedappointment) missedappointment
        , sum(m60emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m60emtct.stopped) + sum(m60emtct.died) + sum(m60emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m60emtct.stopped) + sum(m60emtct.died) + sum(m60emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m60emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -60 month) and date_add(cast(@todate as date), interval - 60 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m72.stopped) stopped
        , sum(m72.died) died
        , sum(missedappointment) missedappointment
        , sum(ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m72.stopped) + sum(m72.died) + sum(m72.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m72.stopped) + sum(m72.died) + sum(m72.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val mediancd4
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)) m72,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        , (SELECT @rownum:=0) r
        where startartdate between date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        ,(SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)
        and (c.exitdate is null or c.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
        union all
        select
        (sum(originalcohort) + sum(transferin)) - sum(transferout) netcohort
        , sum(m72emtct.stopped) stopped
        , sum(m72emtct.died) died
        , sum(m72emtct.missedappointment) missedappointment
        , sum(m72emtct.ltfu) ltfu
        , ((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m72emtct.stopped) + sum(m72emtct.died) + sum(m72emtct.ltfu)) alive
        , (((sum(originalcohort) + sum(transferin)) - sum(transferout)) - (sum(m72emtct.stopped) + sum(m72emtct.died) + sum(m72emtct.ltfu)))
        /((sum(originalcohort) + sum(transferin)) - sum(transferout)) percentalive
        , sum(lastcd4lt500) lastcd4lt500
        , mediancd4.median_val
        from (select a.patientpk
        , case when a.transferinonart is null then 1 else 0 end as originalcohort
        , case when a.transferinonart is not null then 1 else 0 end as transferin
        , case when c.exitreason = 'transfer out' and c.exitdate <= cast(@todate as date) then 1 else 0 end as transferout
        , 0 stopped
        , case when c.exitreason = 'death' and c.exitdate <= cast(@todate as date) then 1 else 0 end as died
        , case when datediff(cast(@todate as date), expectedreturn) >= 14 and c.exitdate is null then 1 else 0 end as missedappointment
        , case when c.exitreason like 'lost%' and c.exitdate <= cast(@todate as date) then 1 else 0 end as ltfu
        , case when (c.exitdate is null or c.exitdate > cast(@todate as date)) and b.lastcd4 < 500
        and b.lastcd4date > a.startartdate then 1 else 0 end as lastcd4lt500
        from tmp_artpatients a left join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus c on a.patientpk = c.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')) m72emtct,
        (SELECT avg(t1.lastcd4) as median_val
        FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.lastcd4
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        ,  (SELECT @rownum:=0) r
        where startartdate between
        date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ORDER BY b.lastcd4) as t1
        , (SELECT count(a.patientpk) as total_rows
        FROM tmp_artpatients a inner join tmp_lastcd4 b on a.patientpk = b.patientpk
        left join tmp_laststatus d on a.patientpk = d.patientpk
        where startartdate between
        date_add(cast(@fromdate as date), interval -72 month) and date_add(cast(@todate as date), interval - 72 month)
        and (a.pregnantatartstart = 'YES' or a.lactatingatartstart = 'YES')
        and (d.exitdate is null or d.exitdate > cast(@todate as date))
        and b.lastcd4date > a.startartdate
        ) as t2
        WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4";
    }

    

    

}


   
