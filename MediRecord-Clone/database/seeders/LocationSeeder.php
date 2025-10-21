<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::factory()->create([
            'name' => 'test',
            'description' => 'test',
            'address' => 'test',
            'address2' => 'test',
            'city_village' => 'test',
            'state_province' => 'test',
            'postalcode' => 'test',
            'country' => 'test',
            'latitude' => 'test',
            'longtitude' => 'test',
            'county_district' => 'test',
            'address3' => 'test',
            'address4' => 'test',
            'address5' => 'test',
            'address7' => 'test',
            'address8' => 'test',
            'address9' => 'test',
            'address10' => 'test',
            'address11' => 'test',
            'address12' => 'test',
            'address13' => 'test',
            'address14' => 'test',
            'creator' => 1,
            'changedby' => 1,
            'datechanged' => '2023-01-01',
            'date_created' => '2023-01-01',
            'date_retired' => '2023-01-01',
            'retired' => 0,
            'retiredby' => 1,
            'uuid' => '1111111',
            'retired_reason' => 'test',
            'parent_location' => 1,
            'uuid' => '12112312'
        ]);
        
            
    }
}
