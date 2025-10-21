<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpTbtpatient;

class TmpTbtpatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_tbtpatients = TmpTbtpatient::factory()->create([
            'patientpk' => 1,
            'districttbnumber' => 'Test',
            'visityear' => 2008,
            'tbtxstartdate' => '2023-01-01',
            'tbtxenddate' => '2023-01-01'
        ]);
    }
}
