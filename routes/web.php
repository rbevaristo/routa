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
    Route::post('/dashboard/transfer', 'ManagerController@transfer');
    // GET
    Route::get('/dashboard/manager/{id}', 'ManagerController@show')->name('manager.show');
    Route::get('/dashboard/employee/{id}', 'EmployeesController@show')->name('employee.show');
});

Route::group(['prefix' => 'manager'], function() {
    //Views
    Route::get('/dashboard', 'Manager\RoutesController@dashboard')->name('manager.dashboard');
    Route::get('/dashboard/manage', 'Manager\RoutesController@manage')->name('manager.manage');
    Route::get('/dashboard/settings', 'Manager\RoutesController@settings')->name('manager.settings');
    Route::get('/dashboard/messages', 'Manager\RoutesController@messages')->name('manager.messages');
    Route::get('/dashboard/performance', 'Manager\RoutesController@performance')->name('manager.performance');
    Route::get('/dashboard/profile', 'Manager\RoutesController@profile')->name('manager.profile');
    Route::get('/dashboard/schedule', 'Manager\RoutesController@schedule')->name('manager.schedule');
    Route::get('/dashboard/employee/{id}', 'Manager\EmployeesController@show');
    // POST CREATE UPDATE
    Route::post('/dashboard/employee/create', 'Manager\EmployeesController@store')->name('manager.employee.create');
    Route::post('/dashboard/manage/status/update', 'Manager\EmployeesController@update_status');
    Route::post('/dashboard/employee/update/all', 'Manager\EmployeesController@update_all');
    Route::post('/dashboard/employee/upload/file', 'Manager\EmployeesController@upload')->name('upload.excel.file');
    Route::post('/dashboard/setting/shift/create', 'Manager\SettingsController@create_shift');
    Route::post('/dashboard/setting/shift/required/create', 'Manager\SettingsController@create_required_shift')->name('user.required.shift');
    Route::get('/dashboard/scheduler/generate', 'Manager\SchedulerController@schedule')->name('user.schedule.generate');
    Route::post('/dashboard/evaluation/status/update', 'Manager\EvaluationResultsController@update_status');
    Route::post('/dashboard/employee/position/update', 'Manager\PositionsController@update_position');
    Route::post('/dashboard/scheduler/create', 'Manager\SchedulerController@create');
    Route::post('/dashboard/scheduler/printToPdf', 'Manager\SchedulerController@printToPdf');
    Route::post('/dashboard/employee/{id}/evaluation_results', 'Manager\EvaluationController@store')->name('manager.employee.evaluation');
    Route::post('/dashboard/profile/update', 'Manager\ProfileController@update')->name('manager.profile.update');
    Route::post('/dashboard/message/approve', 'Manager\MessageController@approve')->name('user.request.approve');
    Route::get('/dashboard/message/read', 'Manager\MessageController@read')->name('user.message.read');
    Route::get('/dashboard/message', 'Manager\MessageController@view')->name('user.message.view');
    Route::post('/dashboard/manage/status/update', 'Manager\EmployeesController@update_status');
    Route::post('/dashboard/evaluation/status/update', 'Manager\EvaluationController@update_status');
    Route::post('/dashboard/employee/position/update', 'Manager\PositionsController@update_position');
    Route::post('/dashboard/setting/update', 'Manager\SettingsController@update');
    Route::post('/dashboard/setting/shift/update', 'Manager\SettingsController@update_shift');
    Route::post('/dashboard/setting/shift/activate', 'Manager\SettingsController@activate_shift');
    Route::post('/dashboard/setting/shift/delete', 'Manager\SettingsController@delete_shift');
    Route::post('/dashboard/setting/criteria/update', 'Manager\SettingsController@update_criteria');
    
    Route::post('/dashboard/setting/schedule-dayoff/update', 'SettingsController@update_dayoff');
    Route::post('/dashboard/employee/update/all', 'EmployeesController@update_all');
    Route::post('/dashboard/password/reset', 'ResetController@password_reset');
});

Route::group(['prefix' => 'employee'], function(){
    Route::get('/dashboard', 'Employee\RoutesController@dashboard')->name('employee.dashboard');
    Route::post('logout', 'Employee\LoginController@logout')->name('employee.logout');

    Route::get('/dashboard/profile', 'Employee\RoutesController@profile')->name('employee.profile');
    Route::get('/dashboard/messages', 'Employee\RoutesController@messages')->name('employee.messages');
    Route::get('/dashboard/performance', 'Employee\RoutesController@performance')->name('employee.performance');

    // Route::post('/dashboard/message/create', 'Employee\MessageController@messageToUser')->name('employee.message.create');
    Route::post('/dashboard/requests/create', 'Employee\MessagesController@requestToUser')->name('employee.request.create');


    Route::post('/dashboard/change-password', 'Employee\ChangePasswordController@update')->name('employee.change-password');
    Route::post('/dashboard/password-check/{password}', 'Employee\ChangePasswordController@check')->name('employee.password-check');

    Route::post('/dashboard/profile/update', 'Employee\ProfileController@update')->name('employee.profile.update');
    Route::get('/dashboard/message', 'Employee\MessagesController@view')->name('employee.message.view');
    Route::get('/dashboard/message/read', 'Employee\MessagesController@read')->name('employee.message.read');
    Route::get('/dashboard/evaluation/read', 'Employee\EvaluationController@read')->name('employee.evaluation.read');
    Route::post('/dashboard/preference/update', 'Employee\PreferencesController@preference')->name('employee.preferences');
});