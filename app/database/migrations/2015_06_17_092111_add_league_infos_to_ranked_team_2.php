<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeagueInfosToRankedTeam2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ranked_team', function(Blueprint $table)
		{
			$table->integer("ranked_league_5_wins");
			$table->integer("ranked_league_5_losses");
			$table->integer("ranked_league_5_league_points");
			$table->integer("ranked_league_3_wins");
			$table->integer("ranked_league_3_losses");
			$table->integer("ranked_league_3_league_points");
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
