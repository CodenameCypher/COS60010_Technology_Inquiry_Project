<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function session_list()
    {
        $isTeacherAuth = auth()->user()->userType == 'Teacher';
        if($isTeacherAuth) {
            return view('teacher.student_session_list');    
        }
        return view('student.student_session_list');
    }

    public function session_enroll($id)
    {
        
        $isTeacherAuth = auth()->user()->userType == 'Teacher';
        if($isTeacherAuth) {
            //$teacher = Teacher::where('user_id', auth()->id())->first();
            //\App\Models\Session::find($id)->update([
                //'teacher_id' =>  auth()->id()
            //]);
            $teacher = \App\Models\Session::find($id);
            $teacher->teacher_id = auth()->id();
            $teacher->save();
            //return auth()->id();
            return redirect(route('studentSessionList'))->with('success', 'Enrolled Successfully!');   
        }

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
        $isTeacherAuth = auth()->user()->userType == 'Teacher';
        if($isTeacherAuth) {
            $teacher = \App\Models\Session::where('teacher_id', auth()->id())->get();
            //return auth()->id();
            //$teacher = \App\Models\Session::all(); 
            return view('student.student_enroll_list', ["enrolled_sessions" => $teacher]);  
        }
        $student = Student::where('user_id', auth()->id())->first();
        $studentID = $student->id;
        $enrolled_sessions =  $student->sessions()->where('student_id', $studentID)->get();

    
        return view('student.student_enroll_list', ["enrolled_sessions" => $enrolled_sessions]);

    }



    public function session_Unenroll($id)
    {
        $isTeacherAuth = auth()->user()->userType == 'Teacher';
        if($isTeacherAuth) {
            //$teacher = Teacher::where('user_id', auth()->id())->first();
            //\App\Models\Session::find($id)->update([
                //'teacher_id' =>  auth()->id()
            //]);
            $teacher = \App\Models\Session::find($id);
            $teacher->teacher_id = 7;
            $teacher->save();
            //return auth()->id();
            return redirect(route('studentEnrolledSessionList'))->with('success', 'Session Unrolled Successfully!');  
        }

        $student = Student::where('user_id', auth()->id())->first();
        $student->sessions()->detach($id);

        return redirect(route('studentEnrolledSessionList'))->with('success', 'Session Unrolled Successfully!');

    }


}



