<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Session;
use App\Models\Teacher;
use DateTime;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function session_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Teacher") {
                return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
            } else {
                return view('teacher.teacher_session_list');
            }
        }
    }

    public function enrolled_session_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Teacher") {
                return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
            } else {
                $teacherid = \App\Models\Teacher::where('user_id', auth()->id())->pluck('id');
                $teacher = \App\Models\Session::where('teacher_id', $teacherid)->get();
                return view('teacher.teacher_enroll_list', ["enrolled_sessions" => $teacher]);
            }
        }
    }

    public function session_enroll($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Teacher") {
                return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
            } else {
                $teacherid = \App\Models\Teacher::where('user_id', auth()->id())->pluck('id');
                $teacher = \App\Models\Session::find($id);
                $tid = $teacherid[0];
                $teacher->teacher_id = $tid;
                $teacher->save();
                return redirect(route('teacherSessionList'))->with('success', 'Enrolled Successfully!');
            }
        }
    }


    public function session_Unenroll($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Teacher") {
                return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
            } else {
                $teacher = \App\Models\Session::find($id);
                $teacher->teacher_id = null;
                $teacher->save();
                return redirect(route('teacherEnrolledSessionList'))->with('success', 'Session Unenrolled Successfully!');
            }
        }
    }


    public function session_dashboard($id)
    {
        $session = Session::where('id', $id)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Teacher") {
                    $teacher = Teacher::where('user_id', auth()->id())->first();
                    $accessible = !($session->teacher == null);
                    if ($accessible) {
                        return view("teacher.teacher_session", ['session' => $session]); // main
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_answer_question($sessionID, $questionID)
    {
        $session = Session::where('id', $sessionID)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Teacher") {
                    $teacher = Teacher::where('user_id', auth()->id())->first();
                    $accessible = !($session->teacher == null);
                    if ($accessible) {
                        $question = Question::where('id', $questionID)->first();
                        return view("teacher.teacher_answer_question", ['session' => $session, 'question' => $question]);
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_update_answer($sessionID, $questionID)
    {
        $session = Session::where('id', $sessionID)->first();
        if (now() >= \Carbon\Carbon::parse($session->session_starting_time) && now() <= \Carbon\Carbon::parse($session->session_ending_time)) {
            if (Auth::check()) {
                if (Auth::user()->userType == "Teacher") {
                    $teacher = Teacher::where('user_id', auth()->id())->first();
                    $accessible = !($session->teacher == null);
                    if ($accessible) {
                        $teacher = Teacher::where('user_id', auth()->id())->first();
                        $question = Question::where('id', $questionID)->first();
                        return view("teacher.teacher_edit_answer", ['session' => $session, 'question' => $question]);
                    } else {
                        return redirect(route('home'))->with('error', 'You are not enrolled in this session!');
                    }
                } else {
                    return redirect(route('home'))->with('error', 'This page is only accessible for teachers!');
                }
            } else {
                return redirect(route('home'))->with('error', 'You must be logged in to access!');
            }
        } else {
            return redirect(route('home'))->with('error', 'Session has not started yet!');
        }
    }

    public function session_answer_question_post(Request $request, $sessionID, $questionID)
    {
        $request->validate([
            'questionAnswer' => 'required',
        ]);
        $session = Session::where('id', $sessionID)->first();
        $teacher = Teacher::where('user_id', auth()->id())->first();
        $question = Question::where('id', $questionID)->first();

        $data['question_answer'] = $request->questionAnswer;
        $data['question_answered_time'] = now();
        $data['time_taken'] = $question->time_taken == null ? gmdate('H:i:s', $question->question_asked_time->diffInSeconds(now())) : $question->time_taken;
        $data['teacher_id'] = $teacher->user->id;

        $question->update($data);
        return redirect(route('teacherSessionDashboard', $session->id));
    }
}
