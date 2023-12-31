<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Question;
use App\Models\Student;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\Builder\Stub;

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

    public function session_list_students()
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.session.session_list_students');
            }
        }
    }

    public function session_show_students($id)
    {
        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {
                return view('admin.session.session_studentList', ['session' => Session::findOrFail($id)]);
            }
        }
    }

    public function session_student_unenroll($sessionID, $studentID)
    {
        $student = Student::where('id', $studentID)->first();
        // dd($student->sessions()->delete);
        $student->sessions()->detach($sessionID);
        $student->save();
        return redirect(route('adminShowStudents', $sessionID))->with('success', 'Session Unrolled Successfully!');
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

        if (Auth::check()) {
            if (Auth::user()->userType != "Admin") {
                return redirect(route('home'))->with('error', 'This page is only accessible for admins!');
            } else {


                $user = User::findOrFail($id);
                $request->validate([
                    'firstName' => 'required',
                    'lastName' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                ]);

                //Assigning changes in user table.
                $user->name = "$request->firstName $request->lastName";
                $user->password = Hash::make($request->password);

                // Assigning changes based on user type.
                if ($user->userType == "Teacher") {
                    $teacher = $user->teacher;
                    $teacher->firstName = $request->firstName; // For Teacher update
                    $teacher->lastName = $request->lastName;
                } else if ($user->userType == "Student") {
                    $student = $user->student; // For Student update
                    $student->firstName = $request->firstName;
                    $student->lastName = $request->lastName;
                } else {
                    //If the user is admin, then the details will not update.
                    return redirect(route('adminUserView'))->with('error', 'You do not have the permissions to change admin details!');
                }

                //Checking if entered email already exists or not.
                $checkEmail = $user->where('email', $request->email)->exists();


                if ($user->email == $request->email) {
                    $user->save();
                    if ($user->userType == "Teacher") {
                        $teacher->save();
                    } else {
                        $student->save();
                    }
                    return redirect(route('adminUserView'))->with('success', 'Updated successfully!');
                } else if ($checkEmail) {
                    return redirect(route('userEdit', $user->id))->with('error', 'New Email entered already exist! Try with another email.');
                } else {
                    $user->email = $request->email;
                    $user->save();

                    if ($user->userType == "Teacher") {
                        $teacher->save();
                    } else {
                        $student->save();
                    }

                    return redirect(route('adminUserView'))->with('success', 'Updated successfully!');
                }
            }
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

        $totalQuestions = $session->questions->count();

        $notAnswered = $session->questions->where('teacher_id', null)->count();
        $answered = $session->questions->whereNotNull('teacher_id')->count();





        // Get the questions for that session and are answered by a teacher.
        $questions = $session->questions->whereNotNull('teacher_id');

        // Calculate the total time duration in seconds and count of questions.
        $totalDuration = 0;
        $count = 0;
        foreach ($questions as $question) {

            // Convert the time_taken datetime string to a Carbon object.
            $timeTaken = Carbon::parse($question->time_taken);

            // Extract the time portion (HH:MM:SS) from the datetime.
            $timePortion = $timeTaken->toTimeString();

            // Calculate the time duration in seconds.
            list($hours, $minutes, $seconds) = explode(':', $timePortion);
            $duration = $hours * 3600 + $minutes * 60 + $seconds;

            // Add it to the total duration
            $totalDuration += $duration;

            // Increase the count.
            $count++;
        }



        // Calculate the average time duration in seconds.
        $averageAnsTime = ($count > 0) ? $totalDuration / $count : 0;

        // Round the average duration to two decimal places
        $roundedaverageAnsTime = number_format($averageAnsTime, 2);


        return view('admin.statistics.attendSession-chart', ['attended' => $attendedSession, 'notAttended' => $notAttended, 'sessionID' => $id, 'notAnswered' => $notAnswered, 'answered' => $answered, 'totalStudent' => $totalstudents, 'totalQuestions' => $totalQuestions, 'averageAnsTime' => $roundedaverageAnsTime]);
    }
}
