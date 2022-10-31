<?php

namespace Database\Seeders;

use App\Models\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
            ],
            [
                'name' => 'Lecturer',
                'slug' => 'lecturer',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
            ],
            [
                'name' => 'Class_manager',
                'slug' => 'class_manager',
            ],
        ];

        Role::insert($roles);

        $users = [
            [
                'first_name' => fake()->name(),
                'email' => 'admin@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],
            [
                'first_name' => fake()->name(),
                'email' => 'lecturer@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],
            [
                'first_name' => fake()->name(),
                'email' => 'user@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],
            [
                'first_name' => fake()->name(),
                'email' => 'manager@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'classmanager@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'lecturer1@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'lecturer2@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'lecturer3@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'lecturer4@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'user1@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'user2@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],

            [
                'first_name' => fake()->name(),
                'email' => 'user3@example.com',
                'phone' => fake()->phoneNumber(),
                'birthday' => fake()->date(),
                'address' => fake()->address(),
            ],
        ];

        foreach ($users as $userItem) {
            //$user  =  \App\Models\User::factory()->create($userItem);
            $userItem['password'] = '1234567@';
            $user = Sentinel::registerAndActivate($userItem);
            switch ($userItem['email']) {
                case 'admin@example.com':
                    $role = Sentinel::findRoleBySlug('admin');
                    $role->users()->attach($user);
                    break;
                case 'lecturer@example.com':
                    $role = Sentinel::findRoleBySlug('lecturer');
                    $role->users()->attach($user);
                    break;
                case 'user@example.com':
                    $role = Sentinel::findRoleBySlug('user');
                    $role->users()->attach($user);
                    break;
                case 'manager@example.com':
                    $role = Sentinel::findRoleBySlug('manager');
                    $role->users()->attach($user);
                    break;
                case 'classmanager@example.com':
                    $role = Sentinel::findRoleBySlug('class_manager');
                    $role->users()->attach($user);
                    break;

                case 'lecturer1@example.com':
                    $role = Sentinel::findRoleBySlug('lecturer');
                    $role->users()->attach($user);
                    break;

                case 'lecturer2@example.com':
                    $role = Sentinel::findRoleBySlug('lecturer');
                    $role->users()->attach($user);
                    break;
                case 'lecturer3@example.com':
                    $role = Sentinel::findRoleBySlug('lecturer');
                    $role->users()->attach($user);
                    break;
                case 'lecturer4@example.com':
                    $role = Sentinel::findRoleBySlug('lecturer');
                    $role->users()->attach($user);
                    break;

                case 'user1@example.com':
                    $role = Sentinel::findRoleBySlug('user');
                    $role->users()->attach($user);
                    break;
                case 'user2@example.com':
                    $role = Sentinel::findRoleBySlug('user');
                    $role->users()->attach($user);
                    break;
                case 'user3@example.com':
                    $role = Sentinel::findRoleBySlug('user');
                    $role->users()->attach($user);
                    break;
            }
        }
    }
}
