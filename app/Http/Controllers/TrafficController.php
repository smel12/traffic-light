<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request ;
use Exception ;
use App\Models\Traffic ;

class TrafficController extends Controller {

			/**
				Публичный API "Светофор" v1
			*/

			/**
				Маршрут API '/api/v1/send/move'
					Вход:	запрос "move" с цифровым идентификатором статуса движения на цвет светофора (от 0 до 3)
							и "session" с идентификатором сессии Laravel
					Выход:	код возврата 'Status 202 Accepted' в случае успеха
			*/
	public function movementV1( Request $request ) {
		$api_request_data = request()->all() ;
		try {
			if ( $api_request_data === [] ) throw new Exception( 'Входящих данных по API запросу нет' ) ;
			if ( ! isset( $api_request_data['move'] ) ) throw new Exception( 'Входящих данных по API запросу нет' ) ;
			$move_attr = $api_request_data['move'] ;
			$receive_session_id = strval( $api_request_data['session'] ) ;
			switch ( $move_attr ) {
				case 0	:					// Проверка корректности входящих данных движения
				case 1	:
				case 2	:
				case 3	:	break ;
				default	:	throw new Exception( 'Некорректные входящие данные по API запросу' ) ;
							break ;
			} ;
		} catch ( Exception $e ) {
			$api_error = $e -> getMessage() ;
			if ( $api_error === 'Входящих данных по API запросу нет' ) {
				return response() -> json( [ 'response' => $api_error ], 400,
												['Content-Type' => 'application/json;charset=UTF-8',
													'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE) ;
			} ;
			if ( $api_error === 'Некорректные входящие данные по API запросу' ) {
				return response() -> json( [ 'response' => $api_error ], 400,
												['Content-Type' => 'application/json;charset=UTF-8',
													'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE) ;
			} ;
		} ;
		$time = microtime(true) ;
		$milliseconds_time = intval( round( $time * 1000 ) ) ;
		$standart_timestamp = intval( floor($milliseconds_time / 1000) ) ;
		$milliseconds_modulo = $milliseconds_time - $standart_timestamp * 1000 ;
		$milliseconds_modulo_str = str_pad( strval( $milliseconds_modulo ), 3, "0" , STR_PAD_LEFT ) ;
		$timestamp_string = date( "Y-m-d H:i:s", $standart_timestamp ) ;
		$micro_timestamp = $timestamp_string . '.' . $milliseconds_modulo_str ;
		$traffic_record = new Traffic ;
		$traffic_record -> timestamp = $micro_timestamp ;
		$traffic_record -> session = $receive_session_id ;
		$traffic_record -> move = $move_attr ;
		$traffic_record -> save() ;
		return response() -> json( [ 'response' => 'OK' ], 202 ) ;
	}

			/**
				Маршрут API '/api/v1/get/log'
					Вход:	запрос "getlog" по значению строкового идентификатора сессии
					Выход:	код возврата 'Status 201 Created';
							"log" с массивом объектов до 100 последних записей движения в формате
								"timestamp": "2024-02-21 19:18:03.527"	(timestamp)
								"move": 1								(int)
			*/
	public function getLogV1( Request $request ) {
		$api_request_data = request()->all() ;
		try {
			if ( $api_request_data === [] ) throw new Exception( 'Входящих данных по API запросу нет' ) ;
			if ( ! isset( $api_request_data['getlog'] ) )
											throw new Exception( 'Нет данных о сессии запрашиваемого лога' ) ;
			$session_string = $api_request_data['getlog'] ;
			$traffic_log = Traffic::where( 'session', $session_string ) ->
									select( 'timestamp', 'move' ) -> orderBy( 'timestamp', 'desc' ) ->
									take( 100 ) -> get() ;
		} catch ( Exception $e ) {
			$api_error = $e -> getMessage() ;
			if ( $api_error === 'Входящих данных по API запросу нет' ) {
				return response() -> json( [ 'response' => $api_error ], 400,
												['Content-Type' => 'application/json;charset=UTF-8',
													'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE) ;
			} ;
			if ( $api_error === 'Нет данных о сессии запрашиваемого лога' ) {
				return response() -> json( [ 'response' => $api_error ], 400,
												['Content-Type' => 'application/json;charset=UTF-8',
													'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE) ;
			} ;
		} ;
		return response() -> json( [ 'response' => 'OK',
										'log' => $traffic_log ], 201 ) ;
	}

}
