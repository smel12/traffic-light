<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;


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

			/** 
				Веб-маршруты приложения "Светофор"
			*/
Route::any( '/', function () {
	return view('trafficLight') ;
} ) ;
