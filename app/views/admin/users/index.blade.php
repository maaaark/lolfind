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
							<input type="text" class="form-control" name="summoner_name" placeholder="Summoner-Name">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<select name="region" class="form-control">
								<option value="any">Any</option>
								@foreach(Config::get("api.allowed_regions") as $region_tag => $region)
									<option value="{{ $region_tag }}">{{ $region["name"] }}</option>
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

		<div class="table_holder">
			<table class="table">
				<thead>
					<th>Spec</th>
					<th>Value</th>
				</thead>
				<tbody>
					<tr>
						<td>Registered Users:</td>
						<td>{{ number_format($users_count->count, 0, ",", ".") }}</td>
					</tr>
					<tr>
						<td>Known Summoners:</td>
						<td>{{ number_format($summoners_count->count, 0, ",", ".") }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@stop