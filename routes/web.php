<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

Route::get('/', 'HomeController@index');
// Route::get('/home', 'HomeController@index')->name('home');

// Route::resource('course', 'CourseController')->except(['index','show'])->middleware(['auth', 'admin']);
// Route::get('/course', 'CourseController@index')->name('course.index');
// Route::get('/course/{course}', 'CourseController@show')->name('course.show');

// Route::resource('course.lesson', 'LessonController')->except(['index'])->middleware(['auth', 'admin']);
// Route::get('/course/{course}/lesson', 'LessonController@index')->name('course.lesson.index');
// Route::get('/course/{course}/lesson/{lesson}', 'LessonController@show')->name('course.lesson.show');

// Route::resource('lesson.mcq', 'McqController')->middleware('auth');
// Route::resource('exam', 'ExamController')->only(['index','create','store','show'])->middleware('auth');
// Route::prefix('ajax')->group(function(){
//   Route::post('/exam/{exam}/submit', 'Api\ExamController@submit')->name('submit_exam')->middleware('auth');
// });
