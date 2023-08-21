<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use App\Models\student;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $account=User::first();
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
      $notifications=auth()->user()->unreadNotifications()->get()->count();
        return view('dashboard.settings.notifications',compact('notifications'));
    }
    public function mark_As_read($id)
    {
        Auth::user()->notifications()->find($id)->markAsRead();
        return view('dashboard.settings.notifications');

    }
    public function mark_all_read()
    {

        Auth::user()->notifications()->delete();
        return view('dashboard.settings.notifications');
    }
}
