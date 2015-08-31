@extends('admin.layout.design')
@section('title', 'Dashboard - ')
@section('nav_page', 'dashboard')
@section('content')
	<div class="page_width">
		<h1>Dashboard</h1>
		
		<div class="row dashboard_info">
			<div class="col-md-3">
				<div class="dashboard_info_box">
					<div class="val">{{ $info["teams_looking_for_player"] }}</div>
					Teams looking for players
				</div>
			</div>
			<div class="col-md-3">
				<div class="dashboard_info_box">
					<div class="val">{{ $info["players_looking_for_team"] }}</div>
					Players looking for teams
				</div>
			</div>
			<div class="col-md-3">
				<div class="dashboard_info_box">
					<div class="val">{{ $info["applications_send_today"] }}</div>
					Applications send today
				</div>
			</div>
			<div class="col-md-3">
				<div class="dashboard_info_box">
					<div class="val">{{ $info["invitations_send_today"] }}</div>
					Invitations send today
				</div>
			</div>
		</div>

		<h2 style="margin-top: 30px;">Roles info</h2>
		<div class="row dashboard_info">
			<div class="col-md-2 col-md-offset-1">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["player_looking_for_top"] }}</div>
					Player looking for top
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["player_looking_for_jungle"] }}</div>
					Player looking for jungle
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["player_looking_for_mid"] }}</div>
					Player looking for mid
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["player_looking_for_adc"] }}</div>
					Player looking for adc
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["player_looking_for_support"] }}</div>
					Player looking for support
				</div>
			</div>
		</div>

		<div class="row dashboard_info">
			<div class="col-md-2 col-md-offset-1">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["teams_looking_for_top"] }}</div>
					Teams looking for top
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["teams_looking_for_jungle"] }}</div>
					Teams looking for jungle
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["teams_looking_for_mid"] }}</div>
					Teams looking for mid
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["teams_looking_for_adc"] }}</div>
					Teams looking for adc
				</div>
			</div>
			<div class="col-md-2">
				<div class="dashboard_info_box">
					<div class="val">{{ $roles_info["teams_looking_for_support"] }}</div>
					Teams looking for support
				</div>
			</div>
		</div>
	</div>
@stop