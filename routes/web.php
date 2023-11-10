<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});


Route::get('/basket', function () {
    return view('cart');
});



Auth::routes();

Route::get('/homepage', 'HomePageController@index')->name('homepage');

// Define routes for the CartController
Route::prefix('cart')->group(function () {
    Route::get('/', 'BasketController@index')->name('cart.index');
    Route::post('/add/{carId}', 'BasketController@add')->name('cart.add');
    Route::put('/update/{carId}', 'BasketController@update')->name('cart.update');
    Route::delete('/remove/{carId}', 'BasketController@remove')->name('cart.remove');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::get('/users', function () {
        return view('admin.users.users');
    });

    Route::get('/cars', function () {
        return view('admin.cars.cars');
    });

    Route::get('/users/create', function () {
        return view('admin.users.create');
    });

    Route::get('/cars/create', function () {
        return view('admin.cars.create');
    });

    Route::get('/cars/edit/{id}', function () {
        return view('admin.cars.edit');
    });
});


