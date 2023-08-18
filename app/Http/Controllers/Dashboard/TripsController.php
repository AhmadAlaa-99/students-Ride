<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\trip;
use App\Models\suggestion;
use App\Models\student_trip;
use App\Models\line;
use App\Models\driver;
class TripsController extends Controller
{

  /**
     * Display all lines
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $trips = trip::with('driver','line')->where('status','قادمة')->get();
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.index', compact('trips','lines','drivers'));
    }
    /**
     * Show form for creating line
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.create')->with([
            'lines'=>$lines,
            'drivers'=>$drivers,
        ]);
    }
    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Line $line,Request $request) 
    {     
        //num_stu
        //price_final
       trip::create([
    'trip_date'=>$request->trip_date,
    'time_1'=>$request->time_1,
    'time_2'=>$request->time_2,
    'time_3'=>$request->time_3,
    'time_final'=>'-',
    'status'=>'قادمة',
    'driver_id'=>$request->driver_id,
    'line_id'=>$request->line_id,
    ]);
 
    session()->flash('Add', 'تم اضافة الرحلة بنجاح');
        return redirect()->route('trips.index');
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(line $line) 
    {
        return view('lines.show', [
            'line' => $line
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(trip $trip) 
    {
        $lines=line::all();
        $drivers=driver::all();

        return view('dashboard.Trips.edit', [
            'trip' => $trip,
            'lines' => $lines,
            'drivers' => $drivers,


        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {
        $user->update($request->validated());

        return redirect()->route('lines.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $line
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(line $line) 
    {
        $line->delete();

        return redirect()->route('lines.index')
            ->withSuccess(__('User deleted successfully.'));
    }
    
    public function trip_completed($id,/*$student_exists*/)
    {
        $students=student_trip::where('trip_id',$id)->whereIn('student_id',/*$student_exists*/['1','2'])->update([
            'status'=>'1',
        ]);
       // $line=line::where('')
           $trip=trip::where('id',$id)->first();
           $trip->update([
            'status'=>'completed',
            'num_stu'=>$students->count(),
            'price_final'=>$students->count()*$trip->line->price,
           ]);
           $driver=driver::where('id',$trip->driver_id)->first();
           $driver->update([
            'financial'=>$driver->financial+=$trip->price_final,
           ]);
           return route('trips.index');       
    }
    public function trips_finite ()
    {
        $trips = trip::with('driver','line')->where('status','منتهية')->get();
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.index', compact('trips','lines','drivers'));

    }
    public function trips_current ()
    {
        $trips = trip::with('driver','line')->where('status','حالية')->get();
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.index', compact('trips','lines','drivers'));

    }
    public function trips_progress ()
    {
        $trips = trip::with('driver','line')->where('status','قيد التقدم')->get();
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.index', compact('trips','lines','drivers'));

    }
    public function trips_canelled ()
    {
        $trips = trip::with('driver','line')->where('status','تم الالغاء')->get();
        $lines=line::all();
        $drivers=driver::all();
        return view('dashboard.Trips.index', compact('trips','lines','drivers'));

    }
    
    public function trips_delete($id)
    {
        $trip=trip::where('id',$id)->delete();
        return redirect()->route('trips.index')
        ->withSuccess(__('Trip deleted successfully.'));
    }
    public function trips_reviews($id)
    { 
        $trip=trip::where('id',$id)->first();
        $suggestions=suggestion::where('trip_id',$id)->get();
        return view('dashboard.Trips.reviews')->with([
            'suggestions'=>$suggestions,
            'trip'=>$trip,
            
        ]);

    }
    




    
}
