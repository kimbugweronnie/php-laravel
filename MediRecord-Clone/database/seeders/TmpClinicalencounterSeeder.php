<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpClinicalencounter;

class TmpClinicalencounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_clinicalencounters = TmpClinicalencounter::factory()->create([
            'patientpk'=> 1,
            'visitid' => 1,
            'visitname'=>'test',
            'visitdate'=>'2023-01-01',
            'scheduled' => 'test',
            'height' => 36.2,
            'weight' => 36.2,
            'bmi' => 36.2,
            'muac' => 'test',
            'nutritionassessment' => 'test',
            'nutritionsupport' => 'test',
            'tbstatus' => 'test',
            'tptstatus' => 'test',
            'tptstartdate'=> '2023-01-01',
            'tptcompletiondate'=> '2023-01-01',
            'whostage' => 111,
            'wabstage'=>'test',
            'arvadherence'=>'test',
            'dsdm'=>'test',
            'pregnant'=>'test',
            'infantfeedingmethod'=>'test',
            'cacxscreening'=>'test',
            'attendingclinician'=>'test',
            'appointmentdate'=> '2023-01-01'
        ]);
    }
}
