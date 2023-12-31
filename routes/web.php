<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/teacher_registration', [AuthController::class, 'teacherRegistration'])->name('teacherRegistration');
Route::post('/teacher_registration', [AuthController::class, 'teacherRegistrationPost'])->name('teacherRegistration.post');

Route::get('/student_registration', [AuthController::class, 'studentRegistration'])->name('studentRegistration');
Route::post('/student_registration', [AuthController::class, 'studentRegistrationPost'])->name('studentRegistration.post');

Route::group(['middleware' => 'auth'], function () {
    //Admin Routes:
    Route::get('/admin/sessions', [AdminController::class, 'session_list'])->name('adminSessionList');
    Route::get('/admin/sessions/create', [AdminController::class, 'session_create'])->name('adminSessionCreate');
    Route::post('/admin/sessions/create', [AdminController::class, 'session_createPost'])->name('adminSessionCreate.post');
    Route::delete('/admin/sessions/{id}/delete', [AdminController::class, 'session_delete'])->name('adminSessionDelete');
    Route::get('/admin/sessions/{id}/edit', [AdminController::class, 'session_edit'])->name('adminSessionEdit');
    Route::post('/admin/sessions/{id}/edit', [AdminController::class, 'session_editPost'])->name('adminSessionEdit.post');
    Route::get('/admin/questions', [AdminController::class, 'question_list'])->name('adminQuestionList');
    Route::get('/admin/users', [AdminController::class, 'user_list'])->name('adminUserView');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'user_edit'])->name('userEdit');
    Route::post('/admin/users/{id}/edit', [AdminController::class, 'user_editPost'])->name('adminUserEdit.post');
    Route::get('/admin/sessions_with_students', [AdminController::class, 'session_list_students'])->name('adminShowStudentsList');
    Route::get('/admin/sessions_with_students/{id}', [AdminController::class, 'session_show_students'])->name('adminShowStudents');
    Route::get('/admin/sessions_with_students/{sessionID}/unenroll/{studentID}', [AdminController::class, 'session_student_unenroll'])->name('studentUnenroll');

    //Student Routes:
    Route::get('/student/sessions', [StudentController::class, 'session_list'])->name('studentSessionList');
    Route::get('/student/enrolledsessions', [StudentController::class, 'enrolled_session_list'])->name('studentEnrolledSessionList');
    Route::post('/student/sessions/{id}/enroll', [StudentController::class, 'session_enroll'])->name('studentSessionEnroll');
    Route::post('/student/sessions/{id}/Unenroll', [StudentController::class, 'session_Unenroll'])->name('studentSessionUnEnroll');
    Route::get('/student/sessions/{id}/dashboard', [StudentController::class, 'session_dashboard'])->name('studentSessionDashboard');
    Route::get('/student/sessions/{id}/post-question', [StudentController::class, 'session_post_question'])->name('studentSessionPostQuestion');
    Route::post('/student/sessions/{id}/post-question', [StudentController::class, 'session_post_question_post'])->name('studentSessionPostQuestion.post');
    Route::get('/student/sessions/{sessionID}/see-answer/{questionID}', [StudentController::class, 'session_see_answer'])->name('studentSessionSeeAnswer');

    //Teacher Routes
    Route::get('/teacher/sessions', [TeacherController::class, 'session_list'])->name('teacherSessionList');
    Route::get('/teacher/enrolledsessions', [TeacherController::class, 'enrolled_session_list'])->name('teacherEnrolledSessionList');
    Route::post('/teacher/sessions/{id}/enroll', [TeacherController::class, 'session_enroll'])->name('teacherSessionEnroll');
    Route::post('/teacher/sessions/{id}/Unenroll', [TeacherController::class, 'session_Unenroll'])->name('teacherSessionUnEnroll');
    Route::get('/teacher/sessions/{id}/dashboard', [TeacherController::class, 'session_dashboard'])->name('teacherSessionDashboard');
    Route::get('/teacher/sessions/{sessionID}/view-question/{questionID}', [TeacherController::class, 'session_answer_question'])->name('teacherSessionAnswerQuestion');
    Route::get('/teacher/sessions/{sessionID}/edit-question/{questionID}', [TeacherController::class, 'session_update_answer'])->name('teacherSessionUpdateAnswer');
    Route::post('/teacher/sessions/{sessionID}/answer-question/{questionID}', [TeacherController::class, 'session_answer_question_post'])->name('teacherSessionAnswerQuestion.post');


    //Chart Visuals
    Route::get('/admin/statistics/statSessionList', [AdminController::class, 'session_list_stat'])->name('adminStat');
    Route::get('/admin/statistics/{id}/statSessionCharts', [AdminController::class, 'adminCharts'])->name('adminCharts');
});
