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
Auth::routes();

Route::group(['middleware' => ['auth' ,'checksinglesession'], 'prefix' => ''], function () {
    Route::get('/', '\App\Http\Controllers\HomeController@index');
    Route::get('home', '\App\Http\Controllers\HomeController@index')->name('home');
    Route::get('session', '\App\Http\Controllers\SessionController@index')->name('session');
    Route::get('lesson', '\App\Http\Controllers\LessonController@index')->name('lesson');
    Route::get('admin/dash', '\App\Http\Controllers\admin\DashController@index')->name('admin.dash');
    Route::get('dash', '\App\Http\Controllers\common\DashController@index')->name('dash');
    Route::get('temp', '\App\Http\Controllers\TempController@index')->name('temp');
    Route::get('student', '\App\Http\Controllers\StudentController@index')->name('student');
});

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
