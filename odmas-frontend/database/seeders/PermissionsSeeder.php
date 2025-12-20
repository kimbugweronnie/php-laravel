<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use \App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'approve']);
        Permission::create(['name' => 'delete']);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create');
        $adminRole->givePermissionTo('view');
        $adminRole->givePermissionTo('edit');
        $adminRole->givePermissionTo('approve');
        $adminRole->givePermissionTo('delete');

        // create roles and assign existing permissions
        $normalUserRole = Role::create(['name' => 'normal-user']);
        $normalUserRole->givePermissionTo('create');
        $normalUserRole->givePermissionTo('view');

        $superAdminRole = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $admin = User::factory()->create([
            'name' => 'fredrick',
            'email' => 'fredrickot@gmail.com',
        ]);
        $admin->assignRole($adminRole);
        
        $normalUser = User::factory()->create([
            'name' => 'normal-user',
            'email' => 'normal-user@gmail.com',
        ]);
        $normalUser->assignRole($normalUserRole);

        $superAdmin = User::factory()->create([
            'name' => 'Super-admin',
            'email' => 'super@example.com',
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
}
