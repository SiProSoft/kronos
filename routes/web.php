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
Route::get('/scrum/p/{id}', 'ScrumController@index')->name('scrum');

// Route::post('projects/{id}/start', ['uses' => 'ProjectsController@startTimer', 'as' => 'projects.start']);
// Route::post('projects/{id}/stop', ['uses' => 'ProjectsController@stopTimer', 'as' => 'projects.stop']);

// Scrum
// Route::get('/scrum/sortlist', 'ScrumController@sortList')->name('scrum.sort');
Route::post('/scrum/sortlist', 'ScrumController@sortList');


// Timer
Route::get('timer/start', 'TimerController@start')->name('timer.start');
Route::post('timer/start', 'TimerController@start')->name('timer.start');
Route::get('timer/stop', 'TimerController@stop')->name('timer.stop');
Route::post('timer/{id}/update', 'TimerController@update')->name('timer.update');

// Tasks
Route::get('tasks/{id}/complete', 'TasksController@complete')->name('tasks.complete');
Route::get('tasks/{id}/incomplete', 'TasksController@incomplete')->name('tasks.incomplete');

Route::get('/api/tasks/p/{id}', 'TasksController@getTasks')->name('tasks.get');
Route::get('/api/projects', 'ProjectsController@getProjects')->name('projects.get');

// Resources
Route::resource('projects', 'ProjectsController');
Route::resource('tasks', 'TasksController');
Route::resource('timeentries', 'TimeEntriesController');



