<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() === 0) {
            $roles = Role::get()->pluck('name')->toArray();
            foreach ($roles as $role) {
                $user = User::create([
                    'email' => "$role@gmail.com",
                    'password' => Hash::make("123456789"),
                    'name' => "$role"
                ]);
//                $user->syncRoles($roles);
                $user->syncRoles([$role]);
                if ($user) {
                    $name = "<fg=black;bg=yellow> " . optional($user)->email . " </>";

                    $this->command->info("User created " . $name . " default password is: 123456789");
                }
            }
        }

        $roles = Role::select('name')->get()->pluck('name');
        foreach ($roles as $name) {
            $user = User::where('email', 'like', "$name%")->first();
            if ($user) {
                $user->assignRole($name);
            }
        }
    }
}
