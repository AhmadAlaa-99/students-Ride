<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driver;
use Validator;
use Storage;
use App\Models\trip;
use App\Http\Controllers\BaseController;
use Response;
use App\Notifications\alert_driver;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
class DriversController extends BaseController
{
    /**
     * Display all drivers
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $drivers = driver::latest()->where('status','1')->paginate(10);
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
        
        $rules = [
            'full_name' => 'required|string|unique:drivers',
            'email' => 'required|string|unique:drivers',
            'password' => 'required|string|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\W]{8,}$/',
            'age' => 'required|numeric',
            'gender' => 'required|string',
            'phone_number' => 'required|string|regex:/^09\d{8}$/',
            'date_reg' => 'required|date',
            'data_reg_end' => 'required|date',
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'portfolio' => 'required|string',
            'num_stu' => 'required|string',
            'status' => 'required|string',
            'alert_count' => 'required|numeric',
        ];
        $request->validate($rules);
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

    public function update(driver $driver, Request $request) 
    {
        $rules = [
            'full_name' => 'required|string|unique:drivers',
            'email' => 'required|string|unique:drivers',
            'password' => 'required|string|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\W]{8,}$/',
            'age' => 'required|numeric',
            'gender' => 'required|string',
            'phone_number' => 'required|string|regex:/^09\d{8}$/',
            'date_reg' => 'required|date',
            'data_reg_end' => 'required|date',
            'vehicle_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'portfolio' => 'required|string',
            'num_stu' => 'required|string',
            'status' => 'required|string',
            'alert_count' => 'required|numeric',
        ];
        $request->validate($rules);
         $image_name='doc-'.time().'.'.$request->portfolio->extension();

         $request->portfolio->move(public_path('contracts'),$image_name);

    
    $password=Hash::make($request->password);
        $driver->update([
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
        session()->flash('edit', 'تم تعديل الخط بنجاح');
        return redirect()->route('drivers.index');
   

      
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
             $driver->delete();

        return redirect()->route('drivers.index')
            ->withSuccess(__('User deleted successfully.'));
    }
    public function delete_driver($id) 
    {
        $driver=driver::where('id',$id)->first();
        $driver->delete();
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
            'alert_count'=>$driver->alert_count+=1,
        ]);
        $title=sprintf('انذار جديد');
        $body=sprintf('تلقيت انذار جديد لديك %s انذارات',$driver->alert_count,);
        //$this->sendFCMNotification('driver',$driver->id,$title,$body);
         //return redirect()->route('drivers.index');
    }
    
    
    
    
    
    public function active_driver($id)
    {
        $driver=driver::where('id',$id)->update([
            'status'=>'1',
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
            'status'=>'0',
        ]);
       return redirect()->route('drivers.index');
    }
    public function drivers_index_unactive()
    {
        $drivers = driver::latest()->where('status','0')->paginate(10);
        return view('dashboard.Drivers.index', compact('drivers'));

    }
    public function receipts_done($id)
    {
        $driver=driver::where('id',$id)->update([
            'financial'=>'0'
        ]);
    }
}
