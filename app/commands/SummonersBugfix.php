<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\ProgressBar;
use Carbon\Carbon;
	
class SummonersBugfix extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'summoners:bugfix';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Detectes errors in summoner-datas, like the "already in use" problem';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		if($this->confirm('Start running threw all registered summoners and looking for problems? [yes|no]')){
			$summoners = Summoner::where("verify", "=", 1)->get();
			echo $summoners->count()." registrated summoners found:".PHP_EOL;

			$users_success = 0;
			$users_fixed   = 0;
			$progress = new ProgressBar($this->output, $summoners->count());
			$progress->start();
			foreach($summoners as $summoner){
				$user = User::where("summoner_id", "=", $summoner->summoner_id)->where("region", "=", $summoner->region)->first();
				if(isset($user->id) && $user->id > 0){
					$users_success++;
				} else {
					$users_fixed++;
					$summoner->verify = 0;
					$summoner->save();
				}
			    $progress->advance();
			}
			$progress->finish();
			$headers = ['Type', 'Count'];
			$users = array(array("Working users", $users_success), array("Users fixed", $users_fixed));
			echo PHP_EOL.PHP_EOL."Result:".PHP_EOL;
			$this->table($headers, $users);
		}
	}
}