<?php

Route::group([
    'middleware' => 'CORS',
    'prefix' => 'v2'

], function ($router) {

    Route::post('login', 'API\AuthController@login');
    Route::post('logout', 'API\AuthController@logout');
    Route::post('refresh', 'API\AuthController@refresh');
    Route::post('me', 'API\AuthController@me');

    Route::post('send', 'Api\ContactUsController@send');
    Route::get('employees', 'Api\UserController@employees');
    Route::get('evaluations/{id}', 'Api\EvaluationController@eval');
    Route::get('evaluationform', 'Api\EvaluationController@form');
    Route::post('evaluate', 'Api\EvaluationController@evaluate');
    Route::get('profile', 'Api\ProfileController@profile');
    Route::post('profile/update', 'Api\ProfileController@update');
    Route::get('schedules', 'Api\ScheduleController@schedule');
});

Route::group([
    'middleware' => 'CORS',
    'prefix' => 'v2/employee'

], function ($router) {

    Route::post('login', 'API\Employee\AuthController@login');
    Route::post('logout', 'API\Employee\AuthController@logout');
    Route::post('refresh', 'API\Employee\AuthController@refresh');
    Route::post('me', 'API\Employee\AuthController@me');

    Route::get('profile', 'Api\Employee\ProfileController@profile');
    Route::post('profile/update', 'Api\Employee\ProfileController@update');
    Route::get('evaluation/files', 'Api\Employee\EvaluationController@evaluation');
    Route::post('request/leave', 'Api\Employee\UserRequestController@send');
    Route::get('schedule', 'Api\Employee\ScheduleController@schedule');
});