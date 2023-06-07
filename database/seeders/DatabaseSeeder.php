<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $pass='12345678';
        $password=Hash::make($pass);
         \App\Models\admin::create([
             'name' => 'test_admin',
             'email' => 'test@admin.com',
             'password' =>$password,
         ]);
         \App\Models\User::create([
            'name' => 'test_admin',
            'email' => 'test@admin.com',
           
            'password' =>$password, 
        ]);
        \App\Models\driver::create([
            'full_name'=>'ahmas',
            'email'=>'testdriver@gmail.com',
            'password'=>$password,
            'gender'=>'male',
            'phone_number'=>'0957567',
            'date_reg'=>'12/01/2020',
            'data_reg_end'=>'12/01/2020',
            'age'=>'23',
            'vehicle_number'=>'432',
            'vehicle_type'=>'van',
            'portfolio'=>'test',
            'status'=>'1',
            'num_stu'=>'5',
            'alert_count'=>'0',
            'full_name' => 'test_admin',
        ]);
    }
} 
