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

// Route::get('/sites', function () {
//     return view('admin.sites');
// });

## Admin
Route::get('/','Admin\AdminController@dashboard');
Route::resource('/sites','SiteController');
Route::resource('/categories','CategoryController');


    