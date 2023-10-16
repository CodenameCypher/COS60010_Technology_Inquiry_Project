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
        return view('teacher.teacher_session_list');
    }




    public function enrolled_session_list()
    {

        $teacherid = \App\Models\Teacher::where('user_id', auth()->id())->pluck('id');
        $teacher = \App\Models\Session::where('teacher_id', $teacherid)->get();
        return view('teacher.teacher_enroll_list', ["enrolled_sessions" => $teacher]);  


    }




    public function session_enroll($id)
    {
        
        $teacherid = \App\Models\Teacher::where('user_id', auth()->id())->pluck('id');
        $teacher = \App\Models\Session::find($id);
        $tid = $teacherid[0];
        $teacher->teacher_id = $tid;
        $teacher->save();
        return redirect(route('teacherSessionList'))->with('success', 'Enrolled Successfully!');
          
    }


public function session_Unenroll($id)
    {

    $teacher = \App\Models\Session::find($id);
    $teacher->teacher_id = null;
    $teacher->save();
    return redirect(route('teacherEnrolledSessionList'))->with('success', 'Session Unenrolled Successfully!');

    }

    public function question_list()
    {
      return view('teacher.view_ques_list');
    }

    public function submitAnswer($id)
    {
        $question = Question::find($id);
        return view('questions.answer', compact('question'));
    }
    
    public function answer($id)
    {
        $question = Question::find($id);
        return view('questions.answer', compact('question'));
    }
}
