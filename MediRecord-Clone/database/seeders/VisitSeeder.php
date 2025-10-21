<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Visit;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visits = Visit::factory()->create([
            'patientpk' => 1,
            'visit_type_id' => 1,
            'visitname' => 'test',
            'date_started' => '2023-01-01',
            'date_stopped' => '2023-01-01',
            'indication_concept_id' => 1,
            'location_id' => 1,
            'creator' => 1,
            'changedby' => 1,
            'voided_by' => 1,
            'date_created' => '2023-01-01',
            'date_changed' => '2023-01-01',
            'date_voided' => '2023-01-01',
            'uuid' => 'test',
            'void_reason' => 'test',
        ]);
    }
}
