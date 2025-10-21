<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patient = Patient::factory()->create([
            'creator' => 1,
            'date_created' => '2022-02-01',
            'changed_by' => 1,
            'date_changed' => '2022-02-01',
            'voided_by' => 1,
            'date_voided' => '2022-02-01',
            'void_reason' => 'test',
            'allergy_status' => 'test',
        ]);
        $patient = Patient::factory()->create([
            'creator' => 1,
            'date_created' => '2022-02-01',
            'changed_by' => 1,
            'date_changed' => '2022-02-01',
            'voided_by' => 1,
            'date_voided' => '2022-02-01',
            'void_reason' => 'test1',
            'allergy_status' => 'test1',
        ]);
       
    }
}
