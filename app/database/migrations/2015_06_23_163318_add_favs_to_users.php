<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFavsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql2')->table('summoners', function(Blueprint $table)
		{
			$table->integer("fav_champion_1");
            $table->integer("fav_champion_2");
            $table->integer("fav_champion_3");
            $table->integer("looking_for_team")->default(0);
            $table->integer("search_top");
            $table->integer("search_jungle");
            $table->integer("search_mid");
            $table->integer("search_adc");
            $table->integer("search_support");
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			
		});
	}

}
