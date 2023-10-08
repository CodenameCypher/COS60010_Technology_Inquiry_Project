<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
    Route::get('/admin/sessions', [AdminController::class, 'session_list'])->name('adminSessionList');
    Route::get('/admin/sessions/create', [AdminController::class, 'session_create'])->name('adminSessionCreate');
    Route::post('/admin/sessions/create', [AdminController::class, 'session_createPost'])->name('adminSessionCreate.post');
    Route::delete('/admin/sessions/{id}/delete', [AdminController::class, 'session_delete'])->name('adminSessionDelete');
    Route::get('/admin/sessions/{id}/edit', [AdminController::class, 'session_edit'])->name('adminSessionEdit');
    Route::post('/admin/sessions/{id}/edit', [AdminController::class, 'session_editPost'])->name('adminSessionEdit.post');


    Route::get('/admin/questions', [AdminController::class, 'question_list'])->name('adminQuestionList');
});
