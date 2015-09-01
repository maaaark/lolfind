@extends('admin.layout.design')
@section('title', 'Users - ')
@section('nav_page', 'users')
@section('content')
	<div class="page_width">
		<h1>Users <span>> {{ $summoner->name }} - {{ strtoupper($summoner->region) }}</span></h1>

		<div class="row">
			<div class="col-md-4">
				<div class="content_box">
					<h2>Summoner-Info</h2>
					<table style="width: 100%;padding: 0px;border: none;border-collapse: collapse;margin: 0px;">
						<tr>
							<td style="vertical-align: top;width: 70px;text-align: left;">
								<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" style="width: 60px;border-radius: 10%;">
							</td>
							<td style="vertical-align: top;">
								<table class="table" style="background: #fff;border: 1px solid #C3C3C3;">
									<tr>
										<td style="border-top: none;">Name</td>
										<td style="border-top: none;">{{ $summoner->name }}</td>
									</tr>
									<tr>
										<td>Level</td>
										<td>{{ $summoner->summonerLevel }}</td>
									</tr>
									<tr>
										<td>Region</td>
										<td>{{ strtoupper(trim($summoner->region)) }}</td>
									</tr>
									<tr>
										<td>Summoner-ID</td>
										<td>{{ $summoner->summoner_id }}</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: center;">
											<a href="/summoner/{{ $summoner->region }}/{{ $summoner->name }}" target="_blank">Show profile</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="col-md-8">
				<div class="content_box">
					<h2>Problems</h2>
					@if(isset($problems) AND $problems AND is_array($problems) AND count($problems) > 0)
						@foreach($problems as $problem)
							<div class="admin_summoner_problem_element">
								@if(isset($problem["type"]) AND trim($problem["type"] != ""))
									@if($problem["type"] == "register_verifiy_cancel")
										<div class="right_button">
											<a href="/admin/users/summoner/{{ $summoner->region }}/{{ $summoner->summoner_id }}/verify_reset" class="btn btn-danger">Reset summoner</a>
										</div>
									@endif
								@endif
								<div class="title">{{ $problem["title"] }}</div>
								<div class="message">{{ $problem["message"] }}</div>
							</div>
						@endforeach
					@else
						<div style="padding: 35px;text-align: center;color: green;">
							<i class="icon-ok"></i>
							No known problems with this summoner
						</div>
					@endif
				</div>

				@if($user AND isset($user->id) AND $user->id > 0)
					<div class="content_box" style="margin-top: 25px;">
						<h2>User-Info</h2>
						<table class="table" style="background: #fff;border: 1px solid #C3C3C3;">
							<tbody>
								<tr>
									<td style="border-top: none;">User-ID</td>
									<td style="border-top: none;"><b>#{{ $user->id }}</b></td>
								</tr>
								<tr>
									<td>E-Mail</td>
									<td>{{ $user->email }}</td>
								</tr>
								<tr>
									<td>Registration</td>
									<td>{{ Helpers::diffForHumans($user->created_at) }}</td>
								</tr>
								<tr>
									<td>Verify-String</td>
									<td>{{ $user->verify_string }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop