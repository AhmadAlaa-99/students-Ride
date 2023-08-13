<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\line;
use App\Models\trip;
class LinesController extends Controller
{
    /**
     * Display all lines
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $lines = line::latest()->paginate(10);
        return view('dashboard.Lines.index', compact('lines'));
    }

    /**
     * Show form for creating line
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {

        return view('dashboard.Lines.create');
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
        $line=line::create([
    'start'=>$request->start,
    'end'=>$request->end,
    'price'=>$request->price,
    ]);
 
    session()->flash('Add', 'تم اضافة الخط بنجاح');
        return redirect()->route('lines.index');
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
       
        $line=line::where('id',$line->id)->first();
        $trips=trip::where('line_id',$line->id)->get();
        return view('Dashboard.Lines.show', [
            'line' => $line,
            'trips'=>$trips,
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(line $line) 
    {
        
        
  
      
        return view('dashboard.Lines.edit', [
            'line' => $line
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
    public function update(Request $request,line $line) 
    {
       
      
        $line->update([
            'start'=>$request->start,
            'end'=>$request->end,
            'price'=>$request->price,
        ]);
        session()->flash('edit', 'تم تعديل الخط بنجاح');
        return redirect()->route('lines.index');
          
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
        
       
        return $line;
        $line->delete();

        return redirect()->route('lines.index')
            ->withSuccess(__('User deleted successfully.'));
    }

}
