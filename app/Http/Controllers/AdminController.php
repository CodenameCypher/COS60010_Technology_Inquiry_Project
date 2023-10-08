<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data['teacher_id'] = $request->Teacher;

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
}
