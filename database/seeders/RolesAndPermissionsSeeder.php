<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); 

        // create permissions
         Permission::create([ 'name' => 'create books']);
         Permission::create(['name' => 'edit books']);
         Permission::create(['name' => 'delete books']);

         //create user permission
         Permission::create(['name' => 'create user']);
         Permission::create(['name' => 'edit user']);
         Permission::create(['name' => 'delete user']);

         $superAdmin = 'super-admin';
         $systemAdmin = 'system-admin';
         $bookowner = 'book-owner';

         Role::create(['name' => $superAdmin])
            ->givePermissionTo(Permission::all());

            Role::create(['name' => $systemAdmin])
            ->givePermissionTo(['create books','edit books','delete books','create user']);

            Role::create(['name' => $bookowner])
            ->givePermissionTo(['create books','edit books','delete books']);
         
    }
}
