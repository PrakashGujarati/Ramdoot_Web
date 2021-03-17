<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::count() <= 0) {
            $roles = [
                [
                    "name" => "super_admin", "slug" => "Super-Admin",
                ],
                [
                    "name" => "admin",
                    "slug" => "Admin",
                ],
                [
                    "name" => "teacher", "slug" => "Teacher",
                ],
                [
                    "name" => "student",
                    "slug" => "Student",
                ],
                
            ];
            $created_roles = Role::insert($roles);
            if ($created_roles) {
                foreach (Role::get()->pluck('name')->toArray() as $role) {
                    $this->command->info("role created <fg=black;bg=blue>$role</>");
                }
            }
        }
    }
}
