<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLookingForInfosToTeam extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ranked_team', function(Blueprint $table)
		{
			$table->text('description');
			$table->integer('looking_for_players');
			$table->string('looking_in_league');
			$table->string('looking_in_league_second');
			$table->integer('looking_for_adc');
			$table->string('looking_for_adc_desc');
			$table->integer('looking_for_support');
			$table->string('looking_for_support_desc');
			$table->integer('looking_for_jungle');
			$table->string('looking_for_jungle_desc');
			$table->integer('looking_for_top');
			$table->string('looking_for_top_desc');
			$table->integer('looking_for_mid');
			$table->string('looking_for_mid_desc');
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
