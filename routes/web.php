<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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
    return redirect('/student');
});

Route::get('/student', [StudentController::class, 'index'])
    ->name('student.index');

Route::get('/student/add', [StudentController::class, 'create'])
    ->name('student.create');

Route::POST('/student/add', [StudentController::class, 'store'])
    ->name('student.store');

Route::get('/student/{id}', [StudentController::class, 'show'])
    ->name('student.show');

Route::get('/student/edit/{id}', [StudentController::class, 'edit'])
    ->name('student.edit');

Route::PUT('/student/edit/{id}', [StudentController::class, 'update'])
    ->name('student.update');
    
Route::DELETE('/student/delete/{id}', [StudentController::class, 'destroy'])
    ->name('student.destroy');