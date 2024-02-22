"use strict";

import logTableUpdate from './logTable' ;

const sessionId = $("#app_session_id").html() ;			// Получаем ID сессии Laravel со скрытого блока страницы
var tl_cycle ;
var tl_color ;
var tl_button_status ;
var tl_button_message ;
var log_message ;
const wrong_move1 = 0 ;			// На красный цвет светофора - "Проезд на красный. Штраф!"
const right_move1 = 1 ;			// На зелёный цвет светофора - "Проезд на зелёный!"
const wrong_move2 = 3 ;			// На жёлтый цвет перед красным цветом светофора - "Слишком рано начали движение!"
const right_move2 = 2 ;			// На жёлтый цвет перед зелёным цветом светофора - "Успели на жёлтый!"
const wrong_message1 = "Проезд на красный. Штраф!" ;	// Сообщение в лог на красный цвет светофора
const right_message1 = "Проезд на зелёный!" ;			// Сообщение в лог на зелёный цвет светофора
const wrong_message2 = "Слишком рано начали движение!" ;// Сообщение в лог на жёлтый цвет перед красным цветом светофора
const right_message2 = "Успели на жёлтый!" ;			// Сообщение в лог на жёлтый цвет перед зелёным цветом светофора

			/** 
				Закрашиваем определённый цвет на светофоре
			*/
function colorLight( colorLight, levelLight ) {
	let canvas = $("#traffic_light").get(0) ;
	let ob_canvas = canvas.getContext( '2d' ) ;
	let y_coord = levelLight * 100 + 60 ;
	ob_canvas.beginPath() ;
	ob_canvas.arc( 64, y_coord, 45, 0, 2 * Math.PI, false ) ;
	ob_canvas.fillStyle = colorLight ;
	ob_canvas.fill() ;
	ob_canvas.lineWidth = 1 ;
	ob_canvas.strokeStyle = '#4B5563' ;
	ob_canvas.stroke() ;
}

			/** 
				Зажигаем светофор огоньками по принятому массиву 'tl_color'
			*/
function trafficLight( tl_color ) {
	var index, len ;
	for ( index = 0, len = tl_color.length; index < len; ++index) {
		colorLight( tl_color[index], index ) ;
	} ;
} ;

			/** 
				Получение лога из БД приложения по API
					Маршрут API '/api/v1/get/log'
						Вход:	запрос "getlog" по значению строкового идентификатора сессии
						Выход:	код возврата 'Status 201 Created';
								"log" с массивом объектов до 100 последних записей движения в формате
									"timestamp": "2024-02-21 19:18:03.527"	(timestamp)
									"move": 1								(int)
			*/
function getSessionLog() {
	var delayInMilliseconds ;
	delayInMilliseconds = 20 ;			// Задержка перед запросом, чтобы произошла запись крайних событий данных в БД
	setTimeout(function() {
		$.ajax( {
			url: '/api/v1/get/log/session',
			method: 'post',
			dataType: 'json',
			data: { getlog: sessionId },
			success: function( log_message ) {
				logTableUpdate( log_message ) ;
			}
		} ) ;
	}, delayInMilliseconds ) ;
} ;

			/** 
				Обработка события нажатия кнопки "Вперёд"
					Маршрут API '/api/v1/send/move'
						Вход:	запрос "move" с цифровым идентификатором статуса движения на цвет светофора (от 0 до 3)
								и "session" с идентификатором сессии Laravel
						Выход:	код возврата 'Status 202 Accepted' в случае успеха
			*/
$('#letsgo_button').click( function() {
	$.ajax( {
		url: '/api/v1/send/move',
		method: 'post',
		dataType: 'json',
		data: { move: tl_button_status,
				session: sessionId },
		success: getSessionLog()
	} ) ;
} ) ;

			/** 
				Инициализация логики "Светофора" при первичном запуске веб-приложения и событии его полной загрузки
			*/
$(window).on("load", function(e) {
	tl_cycle = 0 ;
	tl_color = [ 'red', 'grey', 'grey' ] ;
	trafficLight( tl_color ) ;
	tl_button_status = wrong_move1 ;
	getSessionLog() ;
} ) ;

			/** 
				Логика (прошивка) "Светофора"
					Цвета светофора должны постоянно меняться по следующей логике:
					5 сек зелёный, потом 2 сек жёлтый, потом 5 сек красный, потом опять 2 сек жёлтый и снова зелёный.
			*/
setInterval( function() {
	tl_cycle++ ;
	if ( tl_cycle === 5 ) {
		tl_color = [ 'grey', 'yellow', 'grey' ] ;
		trafficLight( tl_color ) ;
	} else if ( tl_cycle === 7 ) {
		tl_color = [ 'grey', 'grey', 'lawngreen' ] ;
		trafficLight( tl_color ) ;
	} else if ( tl_cycle === 12 ) {
		tl_color = [ 'grey', 'yellow', 'grey' ] ;
		trafficLight( tl_color ) ;
	} else if ( tl_cycle === 14 ) {
		tl_cycle = 0 ;
		tl_color = [ 'red', 'grey', 'grey' ] ;
		trafficLight( tl_color ) ;
	} ;
	switch( tl_cycle ) {
		case 0 :
		case 1 :
		case 2 :
		case 3 :
		case 4 :	tl_button_status = wrong_move1 ;
					break ;
		case 5 :
		case 6 :	tl_button_status = wrong_move2 ;
					break ;
		case 7 :
		case 8 :
		case 9 :
		case 10 :
		case 11 :	tl_button_status = right_move1 ;
					break ;
		case 12 :
		case 13 :	tl_button_status = right_move2 ;
					break ;
	} ;
}, 1000 ) ;			// "Квант времени" светофора
