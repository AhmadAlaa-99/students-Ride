<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use Hash;
use App\Models\trip;
use App\Notifications\alert_driver;

class DriversController extends Controller
{
    /**
     * Display all drivers
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $drivers = driver::latest()->paginate(10);
        return view('dashboard.Drivers.index', compact('drivers'));
    }

    /**
     * Show form for creating line
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        return view('dashboard.Drivers.create');
    }
    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(driver $driver,Request $request) 
    {

        $password=Hash::make($request->password);
    $driver=driver::create([
    'full_name'=>$request->full_name,
    'email'=>$request->email,
    'password'=>$password,
    'age'=>$request->age,
    'gender'=>$request->gender,
    'phone_number'=>$request->phone_number,
    'date_reg'=>$request->date_reg,
    'data_reg_end'=>$request->data_reg_end,
    'vehicle_number'=>$request->vehicle_number,
    'vehicle_type'=>$request->vehicle_type,
    'portfolio'=>$request->portfolio,
    'num_stu'=>$request->num_stu,
    'status'=>'active',
    'alert_count'=>'0',
    ]);
    session()->flash('Add', 'تم اضافة السائق بنجاح');
     return redirect()->route('drivers.index');
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(driver $driver) 
    {
        return view('dashboard.Drivers.show', [
            'driver' => $driver
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(driver $driver) 
    {
        return view('dashboard.Drivers.edit', [
            'driver' => $driver
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

        return redirect()->route('drivers.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $line
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(driver $driver) 
    {
        $line->delete();

        return redirect()->route('drivers.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function download_file(driver $driver) 
    {
        $line->delete();

        return redirect()->route('drivers.index')
            ->withSuccess(__('User deleted successfully.'));
    }
    public function driver_trips($id)
    {
        $driver=driver::where('id',$id)->first();
        $trips=trip::where('driver_id',$id)->get();
        return view('dashboard.Drivers.driver_trips')->with([
            'driver'=>$driver,
            'trips'=>$trips,
        ]);   
    }
    public function driver_sendalert($id)
    {
        $driver=driver::where('id',$id)->first();
        $driver->update([
            'alert_count'=>$driver->alert_count++,
        ]);
        $driver->notify(new alert_driver());
       return redirect()->route('drivers.index');
    }
    public function active_driver($id)
    {
        $driver=driver::where('id',$id)->update([
            'status'=>'active',
        ]);
       return redirect()->route('drivers.index');
    }
    public function inactive_driver($id)
    {
        $driver=driver::where('id',$id)->update([
            'status'=>'inactive',
        ]);
       return redirect()->route('drivers.index');
    }
}
