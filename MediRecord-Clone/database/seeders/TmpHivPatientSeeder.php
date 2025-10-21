<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpHivPatient;

class TmpHivPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_hiv_patients = TmpHivPatient::factory()->create([
            'patientpk' => 1,
            'gender' => 'Male',
            'dob' => '2023-01-01',
            'patientname' => 'test',
            'registrationdate' => '2023-01-01',
            'ageenrollment' => 36.2,
            'lastvisitdate' => '2023-01-01',
            'agelastvisit' => 12.4,
            'dateconfirmedhivpositive' => '2023-01-01',
            'entrypoint' => 'test',
            'transferin' => 'test',
            'transferindate' => '2023-01-01',
        ]);
    }
}
