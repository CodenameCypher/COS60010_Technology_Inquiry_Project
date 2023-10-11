<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function session_list()
    {
        return view('student.student_session_list');
    }

    public function session_enroll($id)
    {


        $student = Student::where('user_id', auth()->id())->first();
        
        
        $checkRecord = $student->sessions()->where('session_id', $id)->exists();

        if($checkRecord){
            // The relationship already exists in the pivot table
            return redirect(route('studentSessionList'))->with('error', 'Already Enrolled!');

        }
        else{
            // The relationship does not exist in the pivot table
            $student->sessions()->attach($id);
            return redirect(route('studentSessionList'))->with('success', 'Enrolled Successfully!');    
            
        }
          
}

    public function enrolled_session_list()
    {
        $student = Student::where('user_id', auth()->id())->first();
        $studentID = $student->id;
        $enrolled_sessions =  $student->sessions()->where('student_id', $studentID)->get();

    
        return view('student.student_enroll_list', ["enrolled_sessions" => $enrolled_sessions]);

    }



    public function session_Unenroll($id)
    {
        $student = Student::where('user_id', auth()->id())->first();
        $student->sessions()->detach($id);

        return redirect(route('studentEnrolledSessionList'))->with('success', 'Session Unrolled Successfully!');

    }
}
