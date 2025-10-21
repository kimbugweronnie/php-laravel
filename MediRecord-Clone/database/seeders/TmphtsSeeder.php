<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Tmphts;

class TmphtsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tmphts = Tmphts::factory()->create([
            'patientpk' => 1,
            'visitid' => 1,
            'visitname' => 'test',
            'deliverymodel' => 'test',
            'visitdate' => '2023-01-01',
            'deliverymodel' => 'test',
            'approach' => 'test',
            'communitytestingpoint' => 'test',
            'facilityentrypoint' => 'test',
            'pmtcttesting' => 'test',
            'subcounty' => 12.4,
            'testingreason' => '0774567832',
            'previousresult' => 'test',
            'previousresultdate' => 'test',
            'finalhivtestresult' => 'test',
            'counsellor' => 'test',
        ]);
    }
}
