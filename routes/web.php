<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::post('projects/{id}/start', ['uses' => 'ProjectsController@startTimer', 'as' => 'projects.start']);
Route::post('projects/{id}/stop', ['uses' => 'ProjectsController@stopTimer', 'as' => 'projects.stop']);


// Timer
Route::get('timer/start', 'TimerController@start')->name('timer.start');
Route::post('timer/start', 'TimerController@start')->name('timer.start');
Route::get('timer/{id}/stop', 'TimerController@stop')->name('timer.stop');
Route::post('timer/{id}/update', 'TimerController@update')->name('timer.stop');

// Resources
Route::resource('projects', 'ProjectsController');
Route::resource('tasks', 'TasksController');
Route::resource('timeentries', 'TimeEntriesController');



