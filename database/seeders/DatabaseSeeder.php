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
            'email'=>$faker->firstname.'@gmail.com',
            'password'=>$password,
            'gender'=>'male',
            'phone_number'=>'9639'.random_int(10000000,99999999),
            'date_reg'=>Carbon::now()->toDateString(),
            'data_reg_end'=>Carbon::now()->addYear()->toDateString(),
            'age'=>'23',
            'vehicle_number'=>'432',
            'vehicle_type'=>'van',
            'portfolio'=>'doc-1691922701.jpg',
            'status'=>'1',
            'num_stu'=>'8',
            'alert_count'=>'0',
           
        ]);
    }

    for($i=0; $i<20 ;$i++)
    {
        \App\Models\student::create([
            'full_name'=>$faker->firstname,
            'email'=>$faker->firstname.'@gmail.com',
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
    $tm=Carbon::now()->addDay();
    $time1 = Carbon::createFromTime(8, 30, 0);
    $time2= Carbon::createFromTime(9, 0, 0);
    $time3 = Carbon::createFromTime(9, 30, 0);

    $time4 = Carbon::createFromTime(10, 0, 0);
    $time5= Carbon::createFromTime(10, 30, 0);
    $time6 = Carbon::createFromTime(11, 0, 0);

    \App\Models\trip::create([
        'trip_date'=>$tm,
        'time_1'=>$time1->format('H:i'),
        'time_2'=>$time2->format('H:i'),
        'time_3'=>$time3->format('H:i'),
        'time_final'=>$time2->format('H:i'),
        'status'=>'حالية',
        'driver_id'=>'1',
        'line_id'=>'1',
      
        ]);

        for($i=6; $i<10 ;$i++)
        {
            \App\Models\student_trip::create([
                'main_time'=>$time2->format('H:i'),
                'time_desire_1'=>$time1->format('H:i'),
                'time_desire_2'=>$time3->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>1,
            ]);
        
        }
    \App\Models\trip::create([
        'trip_date'=>$tm,
        'time_1'=>$time4->format('H:i'),
        'time_2'=>$time5->format('H:i'),
        'time_3'=>$time6->format('H:i'),
        'time_final'=>$time4->format('H:i'),
        'status'=>'حالية',
        'driver_id'=>'2',
        'line_id'=>'1',
        
        ]);
        for($i=1;$i<5;$i++)
        {
            \App\Models\student_trip::create([
                'main_time'=>$time4->format('H:i'),
                'time_desire_1'=>$time5->format('H:i'),
                'time_desire_2'=>$time6->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>2,
            ]);
        }

            \App\Models\trip::create([
            'trip_date'=>$tm,
            'time_1'=>$time1->format('H:i'),
            'time_2'=>$time2->format('H:i'),
            'time_3'=>$time3->format('H:i'),
            'time_final'=>'-',
            'status'=>'قادمة',
            'driver_id'=>4,
            'line_id'=>2,
            
            ]);
            
            \App\Models\trip::create([
                'trip_date'=>$tm,
                'time_1'=>$time4->format('H:i'),
                'time_2'=>$time5->format('H:i'),
                'time_3'=>$time6->format('H:i'),
                'time_final'=>'-',
                'status'=>'قادمة',
                'driver_id'=>5,
                'line_id'=>2,
                
            ]);

    for($i=0; $i<10 ;$i++)
    {
        \App\Models\trip::create([
            'trip_date'=>Carbon::createFromTimestamp(mt_rand($st->timestamp,$en->timestamp)),
            'time_1'=>$time1->format('H:i'),
            'time_2'=>$time2->format('H:i'),
            'time_3'=>$time3->format('H:i'),
            'time_final'=>'-',
            'status'=>'قادمة',
            'driver_id'=>rand(5,10),
            'line_id'=>rand(5,10),
            
            ]);
    }
}

} 
