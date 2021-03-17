<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::get()->each(function ($role) {
            try {
                $role->givePermissionTo(Permission::get()->pluck('name')->toArray());
            } catch (\Throwable $th) {
                dump($th);
            }
        });
    }
}
