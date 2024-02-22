<?php

use Illuminate\Database\Migrations\Migration ;
use Illuminate\Database\Schema\Blueprint ;
use Illuminate\Support\Facades\Schema ;

class CreateTrafficTable extends Migration
{
	 /**	Основная таблица приложения для фиксации лога трафика через светофор */
	public function up()
	{
		Schema::create('traffic', function (Blueprint $table) {
			$table->bigInteger('id', True )->unsigned() ;
			$table->timestamp('timestamp', 3 ) ;			// Храним временные метки с точностью до миллисекунд
			$table->string('session') ;
			$table->tinyInteger('move')->unsigned() ;
		} ) ;
	}

	 /**	Откат создания основной таблицы для приложения "Cветофор" */
	public function down()
	{
		Schema::dropIfExists('traffic') ;
	}
}
