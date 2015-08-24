<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql2')->create('users_emails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("user");
			$table->string("network_page", 64);
			$table->string("type", 64);
			$table->integer("value");
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
