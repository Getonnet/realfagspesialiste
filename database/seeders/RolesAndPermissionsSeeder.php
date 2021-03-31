<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        $data = array(
            array('name'=>'Teacher List', 'guard_name' => 'web'),
            array('name'=>'Teacher View', 'guard_name' => 'web'),
            array('name'=>'Teacher Create', 'guard_name' => 'web'),
            array('name'=>'Teacher Edit', 'guard_name' => 'web'),
            array('name'=>'Teacher Delete', 'guard_name' => 'web'),
            array('name'=>'Teacher Payment', 'guard_name' => 'web'),
            array('name'=>'Teacher Student Assign', 'guard_name' => 'web'),

            array('name'=>'Student List', 'guard_name' => 'web'),
            array('name'=>'Student View', 'guard_name' => 'web'),
            array('name'=>'Student Create', 'guard_name' => 'web'),
            array('name'=>'Student Edit', 'guard_name' => 'web'),
            array('name'=>'Student Delete', 'guard_name' => 'web'),

            array('name'=>'Subject List', 'guard_name' => 'web'),
            array('name'=>'Subject Create', 'guard_name' => 'web'),
            array('name'=>'Subject Edit', 'guard_name' => 'web'),
            array('name'=>'Subject Delete', 'guard_name' => 'web'),

            array('name'=>'Package List', 'guard_name' => 'web'),
            array('name'=>'Package Create', 'guard_name' => 'web'),
            array('name'=>'Package Edit', 'guard_name' => 'web'),
            array('name'=>'Package Delete', 'guard_name' => 'web'),

            array('name'=>'Purchase List', 'guard_name' => 'web'),
            array('name'=>'Purchase View', 'guard_name' => 'web'),
            array('name'=>'Purchase Delete', 'guard_name' => 'web'),

            array('name'=>'Reports Time log', 'guard_name' => 'web'),
            array('name'=>'Reports General', 'guard_name' => 'web'),

            array('name'=>'User List', 'guard_name' => 'web'),
            array('name'=>'User Create', 'guard_name' => 'web'),
            array('name'=>'User Edit', 'guard_name' => 'web'),
            array('name'=>'User Delete', 'guard_name' => 'web'),

            array('name'=>'Role List', 'guard_name' => 'web'),
            array('name'=>'Role Permission', 'guard_name' => 'web'),
            array('name'=>'Role Create', 'guard_name' => 'web'),
            array('name'=>'Role Edit', 'guard_name' => 'web'),
            array('name'=>'Role Delete', 'guard_name' => 'web')
        );

        // create permissions
        Permission::insert($data);

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());
    }
}
