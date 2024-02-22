"use strict";

export default logTableUpdate ;

const wrong_message1 = "Проезд на красный. Штраф!" ;	// Сообщение в лог на красный цвет светофора
const right_message1 = "Проезд на зелёный!" ;			// Сообщение в лог на зелёный цвет светофора
const wrong_message2 = "Слишком рано начали движение!" ;// Сообщение в лог на жёлтый цвет перед красным цветом светофора
const right_message2 = "Успели на жёлтый!" ;			// Сообщение в лог на жёлтый цвет перед зелёным цветом светофора

			/** 
				Обновление (вывод) таблицы лога светофора на странице приложения
					Просто переписываем содержимое таблицы id='log_table'
					Новую таблицу генерируем из полученного массива 'log_message'
			*/
function logTableUpdate( log_message ) {
	let log_timestamp, log_move ;
	let log_table_block ;
	let index, len ;
	log_table_block = `
							<tbody class="overflow-y-scroll">
` ;
	len = log_message['log'].length ;
	for ( index = 0, len; index < len; ++index) {
		var year_ts, month_ts, day_ts, time_ts ;
		var month_str ;
		var text_color, text_message ;
		var year_ts, month_ts, day_ts, time_ts ;
		var month_str ;
		var text_color, text_message ;
		log_move = log_message['log'][index]['move'] ;
		log_timestamp = log_message['log'][index]['timestamp'] ;
		year_ts = log_timestamp[0] + log_timestamp[1] + log_timestamp[2] + log_timestamp[3] ;
		month_ts = log_timestamp[5] + log_timestamp[6] ;
		day_ts = log_timestamp[8] + log_timestamp[9] ;
		time_ts = log_timestamp[11] + log_timestamp[12] + log_timestamp[13] + log_timestamp[14] +
						log_timestamp[15] + log_timestamp[16] + log_timestamp[17] + log_timestamp[18] ;
		switch( month_ts ) {
			case '01' :		month_str = 'янв' ;
							break ;
			case '02' :		month_str = 'фев' ;
							break ;
			case '03' :		month_str = 'мар' ;
							break ;
			case '04' :		month_str = 'апр' ;
							break ;
			case '05' :		month_str = 'май' ;
							break ;
			case '06' :		month_str = 'июн' ;
							break ;
			case '07' :		month_str = 'июл' ;
							break ;
			case '08' :		month_str = 'авг' ;
							break ;
			case '09' :		month_str = 'сен' ;
							break ;
			case '10' :		month_str = 'окт' ;
							break ;
			case '11' :		month_str = 'ноя' ;
							break ;
			case '12' :		month_str = 'дек' ;
							break ;
		} ;
		switch( log_move ) {
			case 0 :	text_color = 'red-500' ;
						text_message = wrong_message1 ;
						break ;
			case 1 :	text_color = 'green-500' ;
						text_message = right_message1 ;
						break ;
			case 2 :	text_color = 'yellow-400' ;
						text_message = right_message2 ;
						break ;
			case 3 :	text_color = 'yellow-400' ;
						text_message = wrong_message2 ;
						break ;
		} ;
		log_table_block += `								<tr class="text-` + text_color + `">` ;
		log_table_block += `">
									<td class="w-20 pl-1">` + time_ts + `</td><td class="w-28 pl-2">` ;
		log_table_block += day_ts + ` ` + month_str + ` ` + year_ts + `</td>
									<td class="pl-3">` ;
		log_table_block += text_message + `</td>
								</tr>
` ;
	} ;
	if ( len < 7 ) {
		var remainder = 7 - len ;
		for ( index = 0, remainder; index < remainder; ++index) {
			log_table_block += `								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
` ;
		} ;
	} ;
	log_table_block += `							</tbody>
` ;
	$('#log_table').html( log_table_block ) ;
} ;
