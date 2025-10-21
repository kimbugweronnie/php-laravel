<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpAtPatient;

class TmpAtPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_at_patients = TmpAtPatient::factory()->create([
            'patientpk' => 1,
            'gender' => 'Male',
            'registrationdate' => '2023-01-01',
            'ageartstart' => 12.4,
            'agelastvisit' => 12.4,
            'transferindate' => '2023-01-01',
            'transferinonart' => 'test',
            'startartdate' => '2023-01-01',
            'bwho' => 123,
            'bwhodate' => '2023-01-01',
            'bwha' => 'test',
            'bwhadate' => '2023-01-01',
            'pregnantatartstart' => 'test',
            'lactatingatartstart' => 'test',
            'breastfeedingatartstart' => 'test',
            'lastartdate' => '2023-01-01',
            'startregimen' => 'test',
            'lastregimenline' => 'test',
            'expectedreturn' =>'2023-01-01'
        ]);
    }
}
