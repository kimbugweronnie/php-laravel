<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpTptpatient;

class TmpTptpatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_tptpatients = TmpTptpatient::factory()->create([
            'patientpk' => 1,
            'tptstatus' => 'Test',
            'tptstartdate' => '2023-01-01',
            'tptcompletiondate' => '2023-01-01'
        ]);
    }
}
