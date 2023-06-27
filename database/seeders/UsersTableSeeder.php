<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([
           'name' => Str::random(10),
           'email' => Str::random(10).'@gmail.com',
           'password' => bcrypt('password'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
       ]);


    }
}
