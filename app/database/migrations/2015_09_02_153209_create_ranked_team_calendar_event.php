<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankedTeamCalendarEvent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ranked_team_calendar_event', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("team");
			$table->integer("user");
			$table->string("name");
			$table->string("event_type");
			$table->datetime("begin");
			$table->datetime("end");
			$table->text("description");
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
