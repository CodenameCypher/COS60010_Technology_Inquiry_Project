<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function session_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Student") {
                return redirect(route('home'))->with('error', 'This page is only accessible for students!');
            } else {
                return view('student.student_session_list');
            }
        }
    }

    public function session_enroll($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Student") {
                return redirect(route('home'))->with('error', 'This page is only accessible for students!');
            } else {
                $student = Student::where('user_id', auth()->id())->first();
                $checkRecord = $student->sessions()->where('session_id', $id)->exists();

                if ($checkRecord) {
                    // The relationship already exists in the pivot table
                    return redirect(route('studentSessionList'))->with('error', 'Already Enrolled!');
                } else {
                    // The relationship does not exist in the pivot table
                    $student->sessions()->attach($id);
                    return redirect(route('studentSessionList'))->with('success', 'Enrolled Successfully!');
                }
            }
        }
    }

    public function enrolled_session_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Student") {
                return redirect(route('home'))->with('error', 'This page is only accessible for students!');
            } else {
                $student = Student::where('user_id', auth()->id())->first();
                $studentID = $student->id;
                $enrolled_sessions =  $student->sessions()->where('student_id', $studentID)->get();
                return view('student.student_enroll_list', ["enrolled_sessions" => $enrolled_sessions]);
            }
        }
    }

    public function session_dashboard($id)
    {
        $session = Session::where('id', $id)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Student") {
                    $student = Student::where('user_id', auth()->id())->first();
                    $accessible = false;
                    foreach ($session->students as $session_student) {
                        if ($session_student->user->id == $student->user->id) {
                            $accessible = true;
                            $session_student->pivot->attended = "1"; // changing the attendance status
                            $session_student->pivot->save();
                            break;
                        }
                    }
                    if ($accessible) {
                        return view("student.student_session", ['session' => $session]); // main
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for students!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_post_question($id)
    {
        $session = Session::where('id', $id)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Student") {
                    $student = Student::where('user_id', auth()->id())->first();
                    $accessible = false;
                    foreach ($session->students as $session_student) {
                        if ($session_student->user->id == $student->user->id) {
                            $accessible = true;
                            $session_student->pivot->attended = "1"; // changing the attendance status
                            $session_student->pivot->save();
                            break;
                        }
                    }
                    if ($accessible) {
                        $session = Session::where('id', $id)->first();
                        $student = Student::where('user_id', auth()->id())->first();
                        return view("student.student_post_question", ['session' => $session]);
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for students!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_see_answer($sessionID, $questionID)
    {
        $session = Session::where('id', $sessionID)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Student") {
                    $student = Student::where('user_id', auth()->id())->first();
                    $accessible = false;
                    foreach ($session->students as $session_student) {
                        if ($session_student->user->id == $student->user->id) {
                            $accessible = true;
                            $session_student->pivot->attended = "1"; // changing the attendance status
                            $session_student->pivot->save();
                            break;
                        }
                    }
                    if ($accessible) {
                        $question = Question::where('id', $questionID)->first();
                        return view("student.student_see_answer", ['session' => $session, 'question' => $question]);
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for students!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_post_question_post(Request $request, $id)
    {
        $request->validate([
            'questionTopic' => 'required',
            'questionContent' => 'required',
        ]);

        $session = Session::where('id', $id)->first();
        $student = Student::where('user_id', auth()->id())->first();

        $data['question_topic'] = $request->questionTopic;
        $data['question_content'] = $request->questionContent;
        $data['question_asked_time'] = now();
        $data['student_id'] = $student->id;
        $data['session_id'] = $session->id;


        $question = Question::create($data);
        return redirect(route('studentSessionDashboard', $session->id))->with('success', 'Sucessfully posted your question!');
    }
}
