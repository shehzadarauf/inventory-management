<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>'1234',
            'api_token' => Str::random(60)
        ]);
        Admin::create([
            'name'=>'Admin2',
            'email'=>'admin2@mail.com',
            'password'=>'1234',
            'api_token' => Str::random(60)
        ]);
    }
}
