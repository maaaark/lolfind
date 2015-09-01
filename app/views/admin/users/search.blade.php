@extends('admin.layout.design')
@section('title', 'Users - ')
@section('nav_page', 'users')
@section('content')
	<div class="page_width">
		<h1>Users</h1>

		<div class="content_box" style="margin-bottom: 25px;">
			<h2>Search for user</h2>
			<form action="/admin/users/search" method="get">
				<div class="row">
					<div class="col-md-7">
						<div class="form-group">
							@if(isset($searched_summoner) AND $searched_summoner AND trim($searched_summoner) != "")
								<input type="text" class="form-control" name="summoner_name" placeholder="Summoner-Name" value="{{ trim($searched_summoner) }}">
							@else
								<input type="text" class="form-control" name="summoner_name" placeholder="Summoner-Name">
							@endif
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<select name="region" class="form-control">
								<option value="any">Any</option>
								@foreach(Config::get("api.allowed_regions") as $region_tag => $region)
									@if(isset($searched_region) AND trim($searched_region) != "" AND trim(strtolower($searched_region)) == trim(strtolower($region_tag)))
										<option value="{{ $region_tag }}" selected>{{ $region["name"] }}</option>
									@else
										<option value="{{ $region_tag }}">{{ $region["name"] }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<input type="submit" value="Search" class="btn btn-primary" style="width: 100%;">
						</div>
					</div>
				</div>
			</form>
		</div>

		@if(isset($summoner_list) AND $summoner_list AND $summoner_list->count() > 0)
			<div class="table_holder">
				<table class="table">
					<thead>
						<th></th>
						<th>Name</th>
						<th>Level</th>
						<th>Last-Update-Main-Data</th>
						<th>Options</th>
					</thead>
					<tbody>
						@foreach($summoner_list as $summoner)
							<tr>
								<td style="width: 52px;text-align: left;">
									<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" style="height: 35px;border-radius: 50%;">
								</td>
								<td style="vertical-align: middle;">
									{{ $summoner->name }} <span style="opacity: 0.6;">- {{ strtoupper($summoner->region) }}</span>
								</td>
								<td style="vertical-align: middle;">
									{{ $summoner->summonerLevel }}
								</td>
								<td style="vertical-align: middle;">
									{{ Helpers::diffForHumans($summoner->last_update_maindata) }}
								</td>
								<td>
									<a href="/admin/users/summoner/{{ trim($summoner->region) }}/{{ $summoner->summoner_id }}" class="btn btn-default">Edit</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="content_box">
				<div style="padding: 25px;font-size: 18px;text-align: center;">
					No summoners found ...
				</div>
			</div>
		@endif
	</div>
@stop