<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use Hash;
use Storage;
use App\Models\trip;
use Response;
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
        $validatedData = $request->validate([
           // 'portfolio' => 'required|csv,txt,xlx,xls,pdf|max:2048',
    
           ]);
         //  $path=$request->file('portfolio')->store('public/files');
         $image_name='doc-'.time().'.'.$request->portfolio->extension();

         $request->portfolio->move(public_path('contracts'),$image_name);


          

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
    'portfolio'=>$image_name,
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

    public function download_file($filename) 
    {
       
        $file = Storage::disk('public')->get($filename);
        return (new Response($file, 200))
              ->header('Content-Type', 'image/jpeg');
   
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

    public function down_contract_file($id)
    {
       $file_name=driver::select('portfolio')->where('id',$id)->latest()->paginate(5);
         foreach($file_name as $file)
         {
             $path=public_path().'/contracts/'.$file->portfolio;
         }
 
          return Response::download($path);
    }

    public function inactive_driver($id)
    {
        $driver=driver::where('id',$id)->update([
            'status'=>'inactive',
        ]);
       return redirect()->route('drivers.index');
    }
}
