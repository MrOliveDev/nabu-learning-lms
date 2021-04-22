<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('', '\App\Http\Controllers\HomeController@index');

Auth::routes();

Route::group(['middleware' => ['auth' ,'checksinglesession'], 'prefix' => ''], function () {
    Route::get('/', '\App\Http\Controllers\admin\DashController@index');
    Route::get('home', '\App\Http\Controllers\HomeController@index')->name('home');
    Route::get('session', '\App\Http\Controllers\SessionController@index')->name('session');
    Route::get('lesson', '\App\Http\Controllers\LessonController@index')->name('lesson');
    Route::get('admin/dash', '\App\Http\Controllers\admin\DashController@index')->name('admin.dash');
    Route::get('dash', '\App\Http\Controllers\common\DashController@index')->name('dash');
    Route::get('temp', '\App\Http\Controllers\TempController@index')->name('temp');
    Route::get('student', '\App\Http\Controllers\StudentController@index')->name('student');
    Route::get('template', '\App\Http\Controllers\TemplateController@index')->name('template');
    Route::get('temp', '\App\Http\Controllers\TempController@index')->name('temp');
    Route::post('template/update', '\App\Http\Controllers\TemplateController@update')->name('template.update');
    Route::post('template/add', '\App\Http\Controllers\TemplateController@add')->name('template.add');
    Route::post('template/delete', '\App\Http\Controllers\TemplateController@delete')->name('template.delete');
});

// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
