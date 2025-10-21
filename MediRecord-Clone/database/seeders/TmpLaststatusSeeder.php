<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\TmpLaststatus;

class TmpLaststatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmp_laststatuses = TmpLaststatus::factory()->create([
            'patientpk' => 1,
            'exitreason' => 'Test',
            'causeofdeath' => 'test',
            'exitdate' => '2023-01-01'
        ]);
    }
}
