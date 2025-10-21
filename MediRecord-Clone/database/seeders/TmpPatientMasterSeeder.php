<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpPatientMaster;

class TmpPatientMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_patient_master = TmpPatientMaster::factory()->create([
            'patientpk' => 1,
            'facilityname' => 'test',
            'gender' => 'Male',
            'dob' => '2023-01-01',
            'patientname' => 'test',
            'registrationdate' => '2023-01-01',
            'ageenrollment' => 36.2,
            'lastvisitdate' => '2023-01-01',
            'agelastvisit' => 12.4,
            'phonenumber' => '0774567832',
            'district' => 'test',
            'county' => 'test',
            'subcounty' => 'test',
            'parish' => 'test',
            'village' => 'test',
            'maritalstatus' => 'test',
        ]);
    }
}
