<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login()
    {
        if (Auth::check()) {
            return redirect(route('home'))->with('success', 'You are already logged in!');
        }
        return view('auth.login');
    }

    function logout()
    {
        Auth::logout();
        return redirect(route('login'))->with('success', 'Logout Successful');
    }


    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'))->with('success', 'Login Successful');
        } else {
            return redirect(route('login'))->with('error', 'Wrong Credentials');
        }
    }

    function teacherRegistration()
    {
        if (Auth::check()) {
            return redirect(route('home'))->with('success', 'You are already logged in!');
        }
        return view('auth.teacher_registration');
    }

    function teacherRegistrationPost(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'contactNumber' => 'required',
            'subjectSpeciality' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $data['name'] = "$request->firstName $request->lastName";
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['userType'] = 'Teacher';

        $user = User::create($data);

        $teacherData['firstName'] = $request->firstName;
        $teacherData['lastName'] = $request->lastName;
        $teacherData['contactNumber'] = $request->contactNumber;
        $teacherData['subjectSpeciality'] = $request->subjectSpeciality;
        $teacherData['user_id'] = $user->id;

        $teacher = Teacher::create($teacherData);

        if (!$user && $teacher) {
            return redirect(route('registration'))->with('error', 'Registration failed');
        } else {
            return redirect(route('login'))->with('success', 'Registration successful. You can login now.');
        }
    }

    function studentRegistration()
    {
        if (Auth::check()) {
            return redirect(route('home'))->with('success', 'You are already logged in!');
        }
        return view('auth.student_registration');
    }

    function studentRegistrationPost(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'contactNumber' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $data['name'] = "$request->firstName $request->lastName";
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['userType'] = 'Student';

        $user = User::create($data);

        $studentData['firstName'] = $request->firstName;
        $studentData['lastName'] = $request->lastName;
        $studentData['contactNumber'] = $request->contactNumber;
        $studentData['user_id'] = $user->id;

        $student = Student::create($studentData);

        if (!$user && $student) {
            return redirect(route('registration'))->with('error', 'Registration failed');
        } else {
            return redirect(route('login'))->with('success', 'Registration successful. You can login now.');
        }
    }
}
