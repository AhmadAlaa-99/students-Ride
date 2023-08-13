<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\trip;
use App\Models\driver;

class statiticsController extends Controller
{
    public function home()
    {
        $trips = trip::where('status','حالية')->with('driver','line')->get();
        $dri=driver::where('financial','!=','0')->get();
        return view('dashboard.home', compact('trips','dri'));
    }
}
