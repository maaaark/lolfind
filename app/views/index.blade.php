@extends('design')
@section('title', "Startseite")
@section('css_addition')
	<link rel="stylesheet" type="text/css" href="/css/index.css">
@stop
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

					<table class="index_form_table">
						<tr>
							<td>Region:</td>
							<td><span id="region_sel"></span></td>
						</tr>
						<tr>
							<td>Liga</td>
							<td><span id="leagues_sel"></span></td>
						</tr>

						<tr>
							<td>Primary role</td>
							<td><span id="primary_role"></span></td>
						</tr>
						<tr>
							<td>Secundary role</td>
							<td><span id="secundary_role"></span></td>
						</tr>
					
						<tr>
							<td>Language:</td>
							<td><span id="main_language"></span></td>
						</tr>
						<tr>
							<td>Optional Language:</td>
							<td><span id="optional_language"></span></td>
						</tr>
					</table>
					<button>Show suggestions</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#region_sel').makeSelect("region", [
		{
			title: 'EUW',
			value: 'euw',
			selected: true,
		},
		{
			title: 'NA',
			value: 'na',
		},
		]);

		summoner_roles = [
			{
				title: 'ADC',
				value: 'adc',
				selected: true,
			},
			{
				title: 'Support',
				value: 'support',
			},
			{
				title: 'Top',
				value: 'top',
			},
			{
				title: 'Mid',
				value: 'mid',
			},
			{
				title: 'Jungle',
				value: 'jungle',
			},
		];
		$('#primary_role').makeSelect("primary_role", summoner_roles);
		$('#secundary_role').makeSelect("secundary_role", summoner_roles);

		$('#leagues_sel').makeSelect("league", [
		{
			title: 'Bronze',
			value: 'bronze',
			selected: true,
		},
		{
			title: 'Silver',
			value: 'silver',
		},
		{
			title: 'Gold',
			value: 'gold',
		},
		{
			title: 'Platinum',
			value: 'platinum',
		},
		{
			title: 'Master',
			value: 'master',
		},
		{
			title: 'Challenger',
			value: 'challenger',
		},
		]);

		languages_sel = [
		{
			title: "English",
			value: "english",
			selected: true,
		},
		{
			title: "German",
			value: "german",
		},
		]
		$('#main_language').makeSelect("main_language", languages_sel);
		$('#optional_language').makeSelect("optional_language", languages_sel);
	</script>
	<div class="content">
		<h1>Startseite</h1>

		<div style="height: 1200px;">
			Bitte srollen
		</div>
	</div>
@stop