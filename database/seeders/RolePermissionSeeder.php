<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.update']);
        Permission::create(['name' => 'user.delete']);
        Permission::create(['name' => 'user.view']);
        Permission::create(['name' => 'absen.scan']);
        Permission::create(['name' => 'absen.viewSelf']);
        Permission::create(['name' => 'absen.viewAll']);



        Permission::create(['name' => 'event.view']);
        Permission::create(['name' => 'event.create']);
        Permission::create(['name' => 'event.update']);
        Permission::create(['name' => 'event.delete']);


        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'user'])->givePermissionTo(['absen.scan', 'absen.viewSelf', 'event.view']);
    }
}
