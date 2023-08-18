<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\trip;
use App\Models\student;
use App\Models\suggestion;
use App\Models\student_trip;
use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\TripCancel_admin;
use App\Notifications\TripCancel_students;
use Carbon\Carbon;
use App\Notifications\status_TripStudents;
use App\Notifications\status_TripAdmin;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Notifications\Reservation_Confirm;
class algorithm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:algorithm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //route api -alghorithm ------
        $response = Http::post(route('Trips_Algorithm'));

        // Handle the response as per your requirement
        // For example, you can log or display the response
        $this->info($response->body());
        
       
    }
}
