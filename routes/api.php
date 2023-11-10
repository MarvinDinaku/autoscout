<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/homepage', 'HomePageController@index')->name('homepage');
Route::get('/tags', 'App\Http\Controllers\Admin\CarsController@getTags')->name('tags');

// Define routes for the CartController
Route::prefix('cart')->group(function () {
    Route::get('/', 'BasketController@index')->name('cart.index');
    Route::post('/add/{carId}', 'BasketController@add')->name('cart.add');
    Route::put('/update/{carId}', 'BasketController@update')->name('cart.update');
    Route::delete('/remove/{carId}', 'BasketController@remove')->name('cart.remove');
});


Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::get('/cars', 'App\Http\Controllers\Admin\CarsController@index')->name('admin.cars');

    Route::post('/cars/create', 'App\Http\Controllers\Admin\CarsController@store')->name('create.cars');

    Route::get('/cars/{id}/edit', 'App\Http\Controllers\Admin\CarsController@edit')->name('edit.cars');

    Route::put('/cars/{id}/update', 'App\Http\Controllers\Admin\CarsController@update')->name('update.cars');

    Route::delete('/cars/{id}/delete', 'App\Http\Controllers\Admin\CarsController@destroy')->name('delete.cars');

    Route::post('/cars/{id}/toggle', 'App\Http\Controllers\Admin\CarsController@toggleStatus')->name('delete.cars');


    //Routes for users

    Route::get('/users', 'App\Http\Controllers\Admin\UsersController@index')->name('admin.users');

    Route::post('/users/create', 'App\Http\Controllers\Admin\UsersController@store')->name('create.users');

    Route::get('/users/{id}/edit', 'App\Http\Controllers\Admin\UsersController@edit')->name('edit.users');

    Route::put('/users/{id}/update', 'App\Http\Controllers\Admin\UsersController@update')->name('update.users');

    Route::delete('/users/{id}/delete', 'App\Http\Controllers\Admin\UsersController@destroy')->name('delete.users');

    Route::post('/users/{id}/toggle', 'App\Http\Controllers\Admin\UsersController@toggleStatus')->name('delete.users');

});

