<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Faker\Factory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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
        $faker=Factory::create();
        $permissions = [            
        'ادارة عمليات الخطوط',
       'تصفح قسم الاقتراحات',
        'ادارة عمليات السائقين',
        'ادارة عمليات الرحلات',
        'تصفح بيانات الطلاب',
        'تصفح قسم الانذارات',
        'تصفح قسم الاشعارات',
        'ادارة بيانات المستخدمين ',
        'ادارة الصلاحيات ',
    ];
    foreach ($permissions as $permission) {
    Permission::create(['name' => $permission]);
    }
    $pass='12345678';
    $password=Hash::make($pass);
    $user=\App\Models\User::create([
        'name' => 'test_admin',
        'email' => 'test@admin.com',
        'password' =>$password, 
        'roles_name' => ["owner"],
        'Status' => 'مفعل',
    ]);
 
   
        $role = Role::create(['name' => 'owner']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
        \App\Models\driver::create([
            'full_name'=>'alaa mohammed',
            'email'=>'alaa@gmail.com',
            'password'=>$password,
            'gender'=>'male',
            'phone_number'=>'9639'.random_int(10000000,99999999),
            'date_reg'=>Carbon::now()->toDateString(),
            'data_reg_end'=>Carbon::now()->addYear()->toDateString(),
            'age'=>'23',
            'vehicle_number'=>'75345',
            'vehicle_type'=>'van',
            'portfolio'=>'doc1691922701.jpg',
            'status'=>'1',
            'num_stu'=>'8',
            'alert_count'=>'2',
        ]);
        for($i=0; $i<6 ;$i++)
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
                'alert_count'=>'2',
            ]);
        }
        for($i=0; $i<6 ;$i++)
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

        // \App\Models\User::factory(10)->create();
        $start=['صحنايا','السومرية','جديدة عرطوز','اشرفية الوادي','جديدة البلد','الزاهرة الجديدة','الزاهرة القديمة','القنيطرة','الهمك','جديدة الفضل'];
        $end=['صحنايا','السومرية','جديدة عرطوز','اشرفية الوادي','جديدة البلد','الزاهرة الجديدة','هندسسة زراعة','مجمع المزة','مجمع الهمك','مجمع البرامكة'];
        
        for($i=0; $i<12 ;$i++) 
        { 
            if (!empty($start) && !empty($end)) {
                $randomStartIndex = array_rand($start); 
                $randomEndIndex = array_rand($end); 
                $randomStart = $start[$randomStartIndex]; 
                $randomEnd = $end[$randomEndIndex]; 
        
                \App\Models\line::create([ 
                    'start' => $randomStart, 
                    'end' => $randomEnd,
                    'price'=>rand(1000, 5000), 
                ]); 
        
                // Remove the used values from the arrays 
                unset($start[$randomStartIndex]); 
                unset($end[$randomEndIndex]); 
        
                // Reset the array keys 
                $start = array_values($start); 
                $end = array_values($end); 
            }
        }
      
      
   
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
        'trip_date'=>$st,
        'time_1'=>$time1->format('H:i'),
        'time_2'=>$time2->format('H:i'),
        'time_3'=>$time3->format('H:i'),
        'time_final'=>$time2->format('H:i'),
        'status'=>'حالية',
        'driver_id'=>'1',
        'line_id'=>'1',
        'num_stu'=>'8',
        ]);
          
    \App\Models\trip::create([
        'trip_date'=>$st,
        'time_1'=>$time4->format('H:i'),
        'time_2'=>$time5->format('H:i'),
        'time_3'=>$time6->format('H:i'),
        'time_final'=>$time4->format('H:i'),
        'status'=>'حالية',
        'driver_id'=>'1',
        'line_id'=>'2',
        'num_stu'=>'8',
        ]);


        \App\Models\trip::create([
            'trip_date'=>$tm,
            'time_1'=>$time1->format('H:i'),
            'time_2'=>$time2->format('H:i'),
            'time_3'=>$time3->format('H:i'),
            'time_final'=>'-',
            'status'=>'قادمة',
            'driver_id'=>'1',
            'line_id'=>'3',
            'num_stu'=>'8',
            ]);
            \App\Models\trip::create([
                'trip_date'=>$tm,
                'time_1'=>$time6->format('H:i'),
                'time_2'=>$time4->format('H:i'),
                'time_3'=>$time5->format('H:i'),
                'time_final'=>'-',
                'status'=>'قادمة',
                'driver_id'=>'1',
                'line_id'=>'4',
                'num_stu'=>'8',
                ]);

                $now = Carbon::now();
               
                
                    \App\Models\trip::create([
                        'trip_date'=>$now->addDays(2),
                        'time_1'=>$time1->format('H:i'),
                        'time_2'=>$time2->format('H:i'),
                        'time_3'=>$time3->format('H:i'),
                        'time_final'=>'-',
                        'status'=>'قادمة',
                        'driver_id'=>'1',
                        'line_id'=>'5',
                        'num_stu'=>'8',
                        ]);
                     
                        
                            \App\Models\trip::create([
                                'trip_date'=>$now->addDays(2),
                                'time_1'=>$time4->format('H:i'),
                                'time_2'=>$time5->format('H:i'),
                                'time_3'=>$time6->format('H:i'),
                                'time_final'=>'-',
                                'status'=>'قادمة',
                                'driver_id'=>'1',
                                'line_id'=>'6',
                                'num_stu'=>'8',
                                ]);

                                \App\Models\trip::create([
                                    'trip_date'=>'2023-08-01',
                                    'time_1'=>$time1->format('H:i'),
                                    'time_2'=>$time2->format('H:i'),
                                    'time_3'=>$time3->format('H:i'),
                                    'time_final'=>$time2->format('H:i'),
                                    'status'=>'منتهية',
                                    'driver_id'=>'1',
                                    'line_id'=>'7',
                                    'num_stu'=>'8',
                                    ]);
                                  
        for($i=1; $i<3 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time2->format('H:i'),
                'time_desire_1'=>$time1->format('H:i'),
                'time_desire_2'=>$time3->format('H:i'),
                'status'=>'1',
                'student_id'=>$i,
                'trip_id'=>1,           
            ]);
        }
        for($i=3; $i<5 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time4->format('H:i'),
                'time_desire_1'=>$time3->format('H:i'),
                'time_desire_2'=>$time5->format('H:i'),
                'status'=>'1',
                'student_id'=>$i,
                'trip_id'=>2,           
            ]);
        }


        for($i=5; $i<7 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time2->format('H:i'),
                'time_desire_1'=>$time1->format('H:i'),
                'time_desire_2'=>$time3->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>3,           
            ]);
        }
        \App\Models\student_trip::create([
            'main_time'=>$time3->format('H:i'),
            'time_desire_1'=>$time2->format('H:i'),
            'time_desire_2'=>$time1->format('H:i'),
            'status'=>'0',
            'student_id'=>7,
            'trip_id'=>3,           
        ]);

        for($i=8; $i<10 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time6->format('H:i'),
                'time_desire_1'=>$time5->format('H:i'),
                'time_desire_2'=>$time4->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>4,           
            ]);
        }
        for($i=8; $i<10 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time6->format('H:i'),
                'time_desire_1'=>$time5->format('H:i'),
                'time_desire_2'=>$time4->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>4,           
            ]);
        }
        for($i=10; $i<13 ;$i++)
        {
                \App\Models\student_trip::create([
                'main_time'=>$time2->format('H:i'),
                'time_desire_1'=>$time1->format('H:i'),
                'time_desire_2'=>$time3->format('H:i'),
                'status'=>'0',
                'student_id'=>$i,
                'trip_id'=>7,           
            ]);
        }


}

} 
