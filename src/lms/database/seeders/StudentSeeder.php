<?php

namespace Database\Seeders;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   DB::table('users')->truncate();
        \App\Models\User::factory()
        ->count(100)
        ->create();
        $students=User::all();
        foreach($students as $student)
        {
            $role = Sentinel::findRoleBySlug('user');
        $role->users()->attach($student);
        }
        
    }
}
