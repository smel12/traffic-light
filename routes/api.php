<?php

use App\Http\Controllers\TrafficController;
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

			/** 
				Маршруты публичного API "Светофора"
			*/
Route::middleware('api') -> group(function () {
	Route::post('/v1/send/move', [ TrafficController::class, 'movementV1'] ) ; } ) ;

Route::middleware('api') -> group(function () {
	Route::post('/v1/get/log/session', [ TrafficController::class, 'getLogV1'] ) ; } ) ;

			/** 
				Вывод сообщения о неверном маршруте API
			*/
Route::any('{any}', function ($any) {
	$errorUrl = 'https://taffic-light.loc/' . $any ;
	return response() -> json( [ 'message' => 'Извините, страница (' . $errorUrl .
			'), которую вы ищете, не найдена! Если ошибка будет повторяться, свяжитесь с info@website.com'], 404 ) ;
} ) -> where( 'any', '.*' ) ;
