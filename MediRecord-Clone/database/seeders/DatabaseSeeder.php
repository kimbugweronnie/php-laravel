<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            // PatientSeeder::class,
            // TmpPatientMasterSeeder::class,
            // TmpHivPatientSeeder::class,
            // VisitTypeSeeder::class,
            // LocationSeeder::class,
            // VisitSeeder::class,
            // TmphtsSeeder::class,
            // TmpAtPatientSeeder::class,
            // TmpAtRegimenswitchSeeder::class,
            // TmpLaststatusSeeder::class,
            // TmpViralloadSeeder::class,
            // TmpClinicalencounterSeeder::class,
            // TmpTbtpatientSeeder::class,
            // TmpTptpatientSeeder::class
          
        ]);
    }
}
