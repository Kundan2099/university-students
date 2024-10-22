<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/student', function () {
    return view('pages.student.student-list');
})->name('student.list');

Route::get('/student/create', function () {
    return view('pages.student.student-create');
})->name('student.create');

Route::get('/student/update/{id}', function ($id) {
    return view('pages.student.student-update', ['id' => $id]);
})->name('student.update');

Route::post('/student/create', [StudentController::class, 'handlePostStudentCreate'])
    ->name('handle.student.create');

Route::post('/student/update/{id}', [StudentController::class, 'handlePostStudentUpdate'])
    ->name('handle.student.update');

Route::get('/get/student/{id}', [StudentController::class, 'handleGetStudentUpdate'])
    ->name('handle.get.student.update');

Route::get('/delete/student/{id}', [StudentController::class, 'handleStudentDelete'])
    ->name('handle.student.delete');


require __DIR__ . '/auth.php';
