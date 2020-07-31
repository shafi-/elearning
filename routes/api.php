<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Auth::routes();

Route::apiResource('courses', 'Api\CourseController')->only(['index']);
Route::apiResource('courses', 'Api\CourseController')->except(['index'])->middleware(['auth:api']);

Route::apiResource('lessons', 'Api\LessonController')->middleware(['auth:api']);

Route::apiResource('lesson.mcq', 'Api\McqController')->middleware(['auth:api']);
