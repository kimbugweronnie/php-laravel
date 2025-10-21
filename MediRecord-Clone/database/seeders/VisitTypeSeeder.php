<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\VisitType;

class VisitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visit_types = VisitType::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'creator' => 1,
            'changedby' => 1,
            'datechanged' => '2023-01-01',
            'date_created' => '2023-01-01',
            'date_retired' => '2023-01-01',
            'retired' => 0,
            'retiredby' => 1,
            'uuid' => '1111111',
            'retired_reason' => 'test',
        ]);
    }
}
