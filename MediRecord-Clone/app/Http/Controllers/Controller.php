<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function send_response($result, $status)
    {
    	$response = ['success' => true, 'data'=> $result,'status' => $status,];
        return response()->json($response, 201);
    }

    public function send_message($result, $status)
    {
    	$response = [
            'success' => false,
            'data'    => $result,
            'status' => $status,
        ];
        return response()->json($response, $status);
    }

    public function validation_response($result, $status)
    {
    	$response = [
            'success' => false,
            'data'    => $result,
            'status' => $status,
        ];
        return response()->json($response, 422);
    }

    public function sucess_message($result, $status)
    {
    	$response = [
            'success' => false,
            'data'    => $result,
            'status' => $status,
        ];
        return response()->json($response, 500);
    }
    public function get48data()
    {
        return DB::select("
        select
concat(monthname(date_add(cast(2017-12-19 as date), interval -6 month))
,' - ', monthname(date_add(cast(2019-12-19 as date), interval - 6 month))
, ' ', year(date_add(cast(2019-12-19 as date), interval - 6 month))) cohort
, sum(m6.originalcohort) originalcohort
, sum(m6.bcd4lt500)/sum(m6.originalcohort) bcd4lt500
, mediancd4.median_val mediancd4
, sum(transferin) transferin
, sum(transferout) transferout
from (select a.patientpk
, case when a.transferinonart is null then 1 else 0 end as originalcohort
, case when b.bcd4 < 500 then 1 else 0 end as bcd4lt500
, case when a.ageartstart >= 5 then b.bcd4 else null end as bcd4
, case when a.transferinonart is not null then 1 else 0 end as transferin
, case when c.exitreason = 'transfer out' and c.exitdate <= cast(2019-12-19 as date) then 1 else 0 end as transferout
from tmp_artpatients a left join tmp_bcd4 b on a.patientpk = b.patientpk
left join tmp_laststatus c on a.patientpk = c.patientpk
where startartdate between
date_add(cast(2017-12-19 as date), interval -6 month) and date_add(cast(2019-12-19 as date), interval - 6 month)) m6,
(SELECT avg(t1.bcd4) as median_val
FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.bcd4
FROM tmp_artpatients a inner join tmp_bcd4 b on a.patientpk = b.patientpk, (SELECT @rownum:=0) r
where startartdate between date_add(cast(2017-12-19 as date), interval -6 month) and date_add(cast(2019-12-19 as date), interval - 6 month)
ORDER BY b.bcd4) as t1
,(SELECT count(a.patientpk) as total_rows
FROM tmp_artpatients a inner join tmp_bcd4 b on a.patientpk = b.patientpk
where startartdate between date_add(cast(2017-12-19 as date), interval -6 month) and date_add(cast(2019-12-19 as date), interval - 6 month)	) as t2
WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4

union
select
concat(monthname(date_add(cast(2017-12-19 as date), interval -12 month))
,' - ', monthname(date_add(cast(2019-12-19 as date), interval - 12 month))
, ' ', year(date_add(cast(2019-12-19 as date), interval - 12 month))) cohort
, sum(m12.originalcohort) originalcohort
, sum(m12.bcd4lt500)/sum(m12.originalcohort) bcd4lt500
, mediancd4.median_val
, sum(transferin) transferin
, sum(transferout) transferout
from (select
a.patientpk
, case when a.transferinonart is null then 1 else 0 end as originalcohort
, case when b.bcd4 < 500 then 1 else 0 end as bcd4lt500
, case when a.ageartstart >= 5 then b.bcd4 else null end as bcd4
, case when a.transferinonart is not null then 1 else 0 end as transferin
, case when c.exitreason = 'transfer out' and c.exitdate <= cast(2019-12-19 as date) then 1 else 0 end as transferout
from tmp_artpatients a left join tmp_bcd4 b on a.patientpk = b.patientpk
left join tmp_laststatus c on a.patientpk = c.patientpk
where startartdate between
date_add(cast(2017-12-19 as date), interval -12 month) and date_add(cast(2019-12-19 as date), interval - 12 month)) m12,
(SELECT avg(t1.bcd4) as median_val
FROM (SELECT @rownum:=@rownum+1 as `row_number`, b.bcd4
FROM tmp_artpatients a inner join tmp_bcd4 b on a.patientpk = b.patientpk, (SELECT @rownum:=0) r
where startartdate between
date_add(cast(2017-12-19 as date), interval -12 month) and date_add(cast(2019-12-19 as date), interval -12 month)
ORDER BY b.bcd4) as t1
, (SELECT count(a.patientpk) as total_rows
FROM tmp_artpatients a inner join tmp_bcd4 b on a.patientpk = b.patientpk
where startartdate between
date_add(cast(2017-12-19 as date), interval -12 month) and date_add(cast(2019-12-19 as date), interval -12 month)) as t2
WHERE t1.row_number in ( floor((total_rows+1)/2), floor((total_rows+2)/2) )) mediancd4
GROUP BY
mediancd4.median_val
;
           "
        );

    }

}
