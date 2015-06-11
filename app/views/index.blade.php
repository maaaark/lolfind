@extends('design')
@section('title', "Startseite")
@section('css_addition')
	<link rel="stylesheet" type="text/css" href="/css/index.css">
@stop
@section('content')
	<div class="index_opener">
		<div class="row" style="margin: auto;max-width: 1100px;">
			<div class="col-md-6">
				<div class="text_opener">
					<div class="big_text">Easily find new team members or new teams</div>
					<div class="medium_text">Log in with your Flashignite-Network Account and start looking for teammates or teams!</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form_box">
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
							<td>Language:</td>
							<td><span id="main_language"></span></td>
						</tr>
						<tr>
							<td></td>
							<td><button>Show suggestions</button></td>
						</tr>
					</table>
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
	</script>
	<div class="content">
		<h1>Startseite</h1>

		<div style="height: 1200px;">
			Bitte srollen
		</div>
	</div>
@stop