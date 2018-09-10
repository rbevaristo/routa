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

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group([], function(){
    // Views
    Route::get('login/admin', 'Auth\LoginController@loginAsAdmin')->name('auth.admin');
    Route::get('login/manager', 'Manager\LoginController@loginAsManager')->name('auth.manager');
    Route::get('verify/{token}', 'Auth\RegisterController@verify');
    Route::get('/dashboard/profile', 'ProfileController@index')->name('manager.profile');

    // POST CREATE, UPDATE
    Route::post('login/employee', 'Employee\LoginController@login')->name('login.employee');
    Route::post('login/manager', 'Manager\LoginController@login')->name('login.manager');

    
    Route::post('/dashboard/manager/create', 'ManagerController@store')->name('manager.create');
    Route::post('/dashboard/manager/update/status', 'ManagerController@edit')->name('manager.update');
    Route::post('/dashboard/manager/{id}/evaluation_results', 'EvaluationController@store')->name('manager.evaluate');
    Route::post('/dashboard/manager/update/all', 'ManagerController@update_all');
    Route::post('/dashboard/profile/update', 'ProfileController@update')->name('company.profile.update');

    // GET
    Route::get('/dashboard/manager/{id}', 'ManagerController@show')->name('manager.show');
});

Route::group(['prefix' => 'manager'], function() {
    //Views
    Route::get('/dashboard', 'Manager\RoutesController@dashboard')->name('manager.dashboard');
    Route::get('/dashboard/manage', 'Manager\RoutesController@manage')->name('manager.manage');
    Route::get('/dashboard/settings', 'Manager\RoutesController@settings')->name('manager.settings');
    Route::get('/dashboard/messages', 'Manager\RoutesController@messages')->name('manager.messages');
    Route::get('/dashboard/performance', 'Manager\RoutesController@performance')->name('manager.performance');
    Route::get('/dashboard/profile', 'Manager\RoutesController@profile')->name('manager.profile');

    // POST CREATE UPDATE
    Route::post('/dashboard/employee/create', 'Manager\EmployeesController@store')->name('manager.employee.create');
    Route::post('/dashboard/manage/status/update', 'Manager\EmployeesController@update_status');
    Route::post('/dashboard/employee/update/all', 'Manager\EmployeesController@update_all');
    Route::post('/dashboard/employee/upload/file', 'Manager\EmployeesController@upload')->name('upload.excel.file');
    Route::post('/dashboard/setting/shift/create', 'Manager\SettingsController@create_shift');
    Route::post('/dashboard/setting/shift/required/create', 'Manager\SettingsController@create_required_shift')->name('user.required.shift');
    Route::get('/dashboard/scheduler/generate', 'Manager\SchedulerController@schedule')->name('user.schedule.generate');
    Route::post('/dashboard/evaluation/status/update', 'EvaluationResultsController@update_status');
    Route::post('/dashboard/employee/position/update', 'PositionsController@update_position');
    Route::post('/dashboard/scheduler/create', 'Manager\SchedulerController@create');

    Route::post('/dashboard/profile/update', 'Manager\ProfileController@update')->name('manager.profile.update');
    Route::post('/dashboard/company/update', 'CompanyController@update')->name('user.company.update');
    Route::post('/dashboard/message/approve', 'MessageController@approve')->name('user.request.approve');
    Route::get('/dashboard/message/read', 'MessageController@read')->name('user.message.read');
    Route::post('/dashboard/manage/status/update', 'EmployeesController@update_status');
    Route::post('/dashboard/evaluation/status/update', 'EvaluationResultsController@update_status');
    Route::post('/dashboard/employee/position/update', 'PositionsController@update_position');
    Route::post('/dashboard/setting/update', 'SettingsController@update');
    Route::post('/dashboard/setting/shift/update', 'SettingsController@update_shift');
    Route::post('/dashboard/setting/shift/activate', 'SettingsController@activate_shift');
    Route::post('/dashboard/setting/shift/delete', 'SettingsController@delete_shift');
    Route::post('/dashboard/setting/criteria/update', 'SettingsController@update_criteria');
    
    Route::post('/dashboard/setting/schedule-dayoff/update', 'SettingsController@update_dayoff');
    Route::post('/dashboard/employee/update/all', 'EmployeesController@update_all');
    Route::post('/dashboard/password/reset', 'ResetController@password_reset');
});