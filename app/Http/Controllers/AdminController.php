<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function session_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.session.session_list');
            }
        }
    }

    public function session_create()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.session.session_create');
            }
        }
    }

    public function session_createPost(Request $request)
    {
        $request->validate([
            'SessionTopic' => 'required',
            'SessionStartingTime' => 'required',
            'SessionEndingTime' => 'required',
            'Teacher' => 'required',
        ]);

        $data['session_topic'] = $request->SessionTopic;
        $data['session_starting_time'] = $request->SessionStartingTime;
        $data['session_ending_time'] = $request->SessionEndingTime;
        $data['teacher_id'] = $request->Teacher == "no teacher" ? null : $request->Teacher;

        $session = Session::create($data);
        if ($session) {
            return redirect(route('adminSessionList'))->with('success', 'Created one session!');
        }
        return redirect(route('adminSessionList'))->with('error', 'Failed creating session!');
    }

    public function session_delete($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();
        return redirect(route('adminSessionList'))->with('success', 'Deleted one session!');
    }

    public function session_edit($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                $session = Session::findOrFail($id);
                return view('admin.session.session_edit', ['session' => $session]);
            }
        }
    }

    public function session_editPost(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        $request->validate([
            'SessionTopic' => 'required',
            'SessionStartingTime' => 'required',
            'SessionEndingTime' => 'required',
            'Teacher' => 'required',
        ]);
        $session->session_topic = $request->SessionTopic;
        $session->session_starting_time = $request->SessionStartingTime;
        $session->session_ending_time = $request->SessionEndingTime;
        $session->teacher_id = $request->Teacher;

        $session->save();
        return redirect(route('adminSessionList'))->with('success', 'Edited one session!');
    }

    public function question_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.question.question_list');
            }
        }
    }


    public function user_list()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.user.user_list');
            }
        }
    }

    public function  user_edit($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                $user = User::findOrFail($id);
                return view('admin.user.user_edit', ['user' => $user]);
            }
        }
    }



    public function user_editPost(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user->name = "$request->firstName $request->lastName";
        $user->password = Hash::make($request->password);

        $teacher = $user->teacher;
        $teacher->firstName = $request->firstName; // needs for student part 10th oct
        $teacher->lastName = $request->lastName;

        $checkEmail = $user->where('email', $request->email)->exists();


        if ($user->email == $request->email) {
            $user->save();
            $teacher->save();
            return redirect(route('adminUserView'))->with('success', 'Updated successfully!');
        } else if ($checkEmail) {
            return redirect(route('userEdit', $user->id))->with('error', 'New Email entered already exist! Try with another email.');
        } else {
            $user->email = $request->email;
            $user->save();
            $teacher->save();
            return redirect(route('adminUserView'))->with('success', 'Updated successfully!');
        }
    }




    public function session_list_stat()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.statistics.session_list_stat');
            }
        }
    }




    public function adminCharts($id)
    {
        $attendedSession = 0;
        $notAttended = 0;
        $totalstudents = 0;
        $session = Session::find($id);
        foreach ($session->students as $student) {
            $attended = $student->pivot->attended;
            if ($attended == 1) {
                $attendedSession++;
                $totalstudents++;
            } else {
                $notAttended++;
                $totalstudents++;
            }
        }
        //ignore, jus testing..
        // $attended = $session->students->where('attended', 1)->count();
        // $notAttended = $session->students->where('attended', 0)->count();
        $totalQuestions = $session->questions->count();
        $notAnswered = $session->questions->where('teacher_id', null)->count();
        $answered = $session->questions->whereNotNull('teacher_id')->count();




        return view('admin.statistics.attendSession-chart', ['attended' => $attendedSession, 'notAttended' => $notAttended, 'sessionID' => $id, 'notAnswered' => $notAnswered, 'answered' => $answered, 'totalStudent' => $totalstudents, 'totalQuestions' => $totalQuestions]);
    }
}
