<?php

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('company', 'CompanyController');
    Route::resource('employee', 'EmployeeController');
});
