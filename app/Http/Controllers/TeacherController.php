<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
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

    public function submitAnswer(Request $request, $id)
    {
    // Validate the form data
    $request->validate([
        'answer' => 'required|string|max:255', // You can adjust the validation rules as needed
    ]);

    $question = Question::find($id);
    if (!$question) {
        return redirect()->back()->with('error', 'Question not found.');
    }

    $question->update([
        'question_answer' => $request->answer,
    ]);

    return redirect()->back()->with('success', 'Answer submitted successfully!');
}


    public function answerQuestion($id)
    {
        $question = Question::find($id);
        return view('teacher.answer_question', ['sessionId'=> $id]);
        
    }

    public function teachAttendance($id)
    {
    $questions = Question::where('session_id', $id)->get();

    return view('teacher.teacher_attendance', [
        'questions' => $questions,
        'sessionId' => $id,
    ]);
    }
}
