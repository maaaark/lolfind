<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql2')->create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("user");
			$table->string("network_page");
			$table->string("type");
			$table->string("value1");
			$table->string("value2");
			$table->string("value3");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
