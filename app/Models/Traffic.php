<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

			/** 
				Модель лога данных для "Светофора"
			*/
class Traffic extends Model {

	public $timestamps = false ;			// Запрет автоматической обработки временных меток модели

	protected $fillable = [
		'timestamp', 'session', 'move'
	];

	protected $hidden = [
		'id'
	];

}
