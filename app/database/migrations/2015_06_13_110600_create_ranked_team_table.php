<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankedTeamTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ranked_team', function($table)
		{
			$table->increments('id');
			$table->string("team_id");
			$table->string("region", 10);
			$table->string("name");
			$table->string("tag", 8);
			$table->integer("leader_summoner_id");
			$table->integer("adder_summoner_id");
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
