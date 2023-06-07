<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\student;
use App\Models\suggestion;
use App\Models\admin;
class SettingsController extends Controller
{
    public function alerts()
    {
        $drivers=driver::where('alert_count','<>',0)->get();
        $students=student::where('alert_count','<>',0)->get();
        return view('dashboard.settings.alerts')->with([
            'drivers'=>$drivers,
            'students'=>$students,
        ]);
    }

    public function suggestions()
    {
        $suggestions=suggestion::with('trip')->get();
        return view('dashboard.settings.suggestions')->with([
            'suggestions'=>$suggestions,
            
        ]);
    }
    public function profile_admin()
    {
        $account=admin::first();
        return view('dashboard.settings.profile')->with([
            'account'=>$account,]);
    }
    public function update_password()
    {

    }
    public function update_profile()
    {

    }
    public function notifications()
    {
        return view('dashboard.settings.notifications');
    }
}
