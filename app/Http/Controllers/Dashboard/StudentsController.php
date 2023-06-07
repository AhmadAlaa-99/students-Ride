<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
class StudentsController extends Controller
{
    public function index() 
    {
        $students = student::latest()->paginate(10);
 
        return view('dashboard.students.index', compact('students'));
    }
    /**
     * Show form for creating line
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        
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
     
    }

    /**
     * Delete user data
     * 
     * @param User $line
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(student $student) 
    {
        $student->delete();

        return redirect()->route('students.index')
            ->withSuccess(__('student deleted successfully.'));
    }

    public function cancel_trip_student()
    {
        $student=student::where('id',1)->update([
            'count_alerts'=>$student->count_alerts++,
        ]);
        if($student->count_alerts==5)
        {
            $student->destroy();
            //block phone and email and phone and logout
            //send notify email 
        }
        else
        {
                  // after 9'oclock //not exist delete from trip_student 
        
                 //before 9'oclock 
                 trip_student::where([
                    'student_id'=>'1',
                    'trip_id'=>'1'
                 ])->delete();
                 // regeneration alghorithm 
        }
    }

   
}
