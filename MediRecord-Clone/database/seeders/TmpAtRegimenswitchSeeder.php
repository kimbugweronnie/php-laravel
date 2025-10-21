<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpAtRegimenswitch;

class TmpAtRegimenswitchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_at_regimenswitches = TmpAtRegimenswitch::factory()->create([
            'patientpk' => 1,
            'startregimen' => 'Test',
            'firstlinesub_regimen' => 'test',
            'firstlinesub_dateswitched' => '2023-01-01',
            'firstlinesub_reasonswitched' => 'test',
            'secondline_regimen' => 'test',
            'secondline_dateswitched' => '2023-01-01',
            'secondline_reasonswitched' => 'test',
            'thirdline_regimen' => 'test',
            'thirdline_dateswitched' => '2023-01-01',
            'thirdline_reasonswitched' => 'test',
        ]);
    }
}
