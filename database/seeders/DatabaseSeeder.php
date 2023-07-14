<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Faker\Factory;
use Carbon\Carbon;
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
        $start=['صحنايا','السومرية','جديدة عرطوز','اشرفية الوادي'];
        $end=['الهمك','البرامكة',' المزة','مساكن برزة'];
        for($i=0; $i<10 ;$i++)
        {
        \App\Models\line::create([
            'start'=>$start[rand(0, count($start) - 1)],
            'end'=>$end[rand(0, count($end) - 1)],
            'price'=>rand(1000, 5000),
        ]);
    }
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
        $faker=Factory::create();
        for($i=0; $i<10 ;$i++)
        {
        \App\Models\driver::create([
            'full_name'=>$faker->firstname,
            'email'=>$faker->firstname,
            'password'=>$password,
            'gender'=>'male',
            'phone_number'=>'9639'.random_int(10000000,99999999),
            'date_reg'=>Carbon::now()->toDateString(),
            'data_reg_end'=>Carbon::now()->addYear()->toDateString(),
            'age'=>'23',
            'vehicle_number'=>'432',
            'vehicle_type'=>'van',
            'portfolio'=>'test',
            'status'=>'1',
            'num_stu'=>rand(4, 15),
            'alert_count'=>'0',
           
        ]);
    }
    for($i=0; $i<20 ;$i++)
    {
        \App\Models\student::create([
            'full_name'=>$faker->firstname,
            'email'=>$faker->firstname,
            'password'=>$password,
            'gender'=>'male',
            'phone_number'=>'9639'.random_int(10000000,99999999),
     
            'age'=>'23',
            'university'=>'university_damas',
            'location'=>'damas',
            'alert_count'=>'0',
        ]);
    }
    $type=['اياب','ذهاب'];
    $st=Carbon::now();
    $en=Carbon::now()->addMonth();
    $time1 = Carbon::createFromTime(8, 30, 0);
    $time2= Carbon::createFromTime(9, 0, 0);
    $time3 = Carbon::createFromTime(9, 30, 0);

    for($i=0; $i<10 ;$i++)
    {
        \App\Models\trip::create([
            'trip_date'=>Carbon::createFromTimestamp(mt_rand($st->timestamp,$en->timestamp)),
            'time_1'=>$time1->format('H:i'),
            'time_2'=>$time2->format('H:i'),
            'time_3'=>$time3->format('H:i'),
            'time_final'=>'-',
            'status'=>'1',
            'driver_id'=>rand(1,10),
            'line_id'=>rand(1,10),
            'type'=>$type[rand(0, count($type) - 1)],
            ]);
    }


}
} 
