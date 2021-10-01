<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\Auth\AdminLoginController;
/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */
//Route::redirect('/admin', '/admin/login', 301);
// Switch between the included languages
Route::redirect('dashboard', '/');
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
//Route::redirect('admins', '/admin/login');
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middlewareGroups' => ['role_check:Normal_User']], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});
