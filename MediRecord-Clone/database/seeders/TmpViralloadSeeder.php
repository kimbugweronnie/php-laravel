<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpViralload;

class TmpViralloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_laststatuses = TmpViralload::factory()->create([
            'patientpk' => 1,
            'vlresultnumeric' => 11,
            'vlresulttext' => 'test',
            'vldate' => '2023-01-01',
            'encounterdate' => '2023-01-01'
        ]);
    }
}
