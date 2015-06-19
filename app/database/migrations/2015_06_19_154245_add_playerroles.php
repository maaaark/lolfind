<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPlayerroles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('player_roles', function($table)
        {
            $table->increments('id');
            $table->integer("user_id");
            $table->integer("role_id");
            $table->timestamps();
        });

        Schema::create('roles', function($table)
        {
            $table->increments('id');
            $table->string("name");
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('playerroles', function(Blueprint $table)
		{
			
		});
	}

}
