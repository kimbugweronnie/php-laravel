<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use \App\Models\User;
use \App\Models\Roles;

class PermissionSeeder extends Seeder
{
    
    public function run()
    {
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // // create permissions
        // Permission::create(['name' => 'edit']);
        // Permission::create(['name' => 'view']);
        // Permission::create(['name' => 'delete']);
        // Permission::create(['name' => 'approve']);

        // create roles and assign existing permissions
        $roles = Roles::all();
        // foreach ($roles as $role) {
        //     Role::create(['guard_name' => $role->role, 'name' => $role->role]);
        // }

        $role1 = Role::where('name','Application: Administers System')->first();

        $user = User::factory()->create([
            'email' => 'user1@gmail.com',
            'password' => 'admin',
            'system_id' => '1',
            'username' => 'TestUser',
            'salt' => 'test',
            'secret_question' => 'test',
            'secret_answer' => 'test',
            'creator' => 1,
            'date_created' => '2023-01-01',
            'changed_by' => 1,
            'date_changed' => '2023-01-01',
            'person_id' => 1,
            'retired' => 1,
            'retired_by' => 1,
            'retire_reason' => 'test',
            'uuid' => '5cc18975-2f3b-11e7-8ccb-28d2440db56c'
        ]);
        $user->assignRole($role1);
        
    }

}
