@extends('design')
@section('title', "Startseite")
@section('content')
	<div style="min-height: 300px;background: red;background-image: url(http://summoner.flashignite.com/img/stats/index_search_layer_bg.png);background-position: center center;">
		<div class="row" style="margin: auto;max-width: 1100px;">
			<div class="col-md-6">
				<div style="text-align: center;padding:30px;padding-top: 100px;color:#fff;text-shadow: 0 0 6px #000;">
					<div style="font-size: 22px;padding-bottom: 10px;">Easily find new team members or new teams</div>
					<div style="font-size: 16px;color:rgba(255,255,255,0.6);">Log in with your Flashignite-Network Account and start looking for teammates or teams!</div>
				</div>
			</div>
			<div class="col-md-6">
				<div style="background: rgba(255,255,255,0.4);box-sizing: border-box;padding: 25px;margin-top: 40px;">
					<h2 style="margin-top: 0px;">Search for team or player</h2>
					<div>
						<input type="radio" name="player_or_team" value="player" checked> Player
						<input type="radio" name="player_or_team" value="team"> Team
					</div>

					<div>
					Region:
						<div id="region_sel"></div>

						Liga
						<select>
							<option>Bronze+</option>
							<option>Silver+</option>
							<option selected>Gold+</option>
							<option>Platinum+</option>
							<option>Master+</option>
							<option>Challenger</option>
						</select>
					</div>

					<div>
						Primary role
						<div id="primary_role"></div>

						Secundary role
						<select>
							<option>Top</option>
							<option>Mid</option>
							<option>Jungle</option>
							<option>ADC</option>
							<option>Support</option>
						</select>
					</div>
					
					<div>
						Language:
						<select>
							<option>English</option>
							<option>German</option>
						</select>

						Optional Language:
						<select>
							<option>None</option>
							<option>English</option>
							<option>German</option>
						</select>
					</div>

					<button>Show suggestions</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#region_sel').makeSelect("regions", [
		{
			title: 'EUW',
			description: 'Europe West',
		},
		{
			title: 'NA',
			description: 'North America',
			selected: true,
		},
		]);

		$('#primary_role').makeSelect("primary_role", [
		{
			title: 'ADC',
			selected: true,
		},
		{
			title: 'Support',
		},
		]);
	</script>
	<div class="content">
		<h1>Startseite</h1>

		<div style="height: 1200px;">
			Bitte srollen
		</div>
	</div>
@stop