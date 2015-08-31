@extends('admin.layout.design')
@section('title', 'Network Server - ')
@section('nav_page', 'nw_server')
@section('content')
	<div class="page_width">
		<h1>Network Server - Live Info</h1>
		@if($server_info)
			<div class="table_holder">
				<table class="table">
					<tr>
						<td>Server-Start-Time:</td>
						<td>{{ date("H:i:s \U\h\\r \a\m d.m.Y", strtotime($server_info["start_time"])) }}</td>
					</tr>
					<tr>
						<td>Uptime in Minuten:</td>
						<?php
							$date1   = date('Y-m-d H:i:s');
							$date2   = date("Y-m-d H:i:s", strtotime($server_info["start_time"]));
							$diff    = abs(strtotime($date2) - strtotime($date1));
							$uptime    = floor($diff / 60);
						?>
						<td>{{ $uptime }} minutes</td>
					</tr>
					<tr>
						<td>Last chat-message</td>
						<td>
							@if(isset($server_info["last_chat"]) AND $server_info["last_chat"])
								{{	Helpers::diffForHumans($server_info["last_chat"]) }}
							@else
								none
							@endif
						</td>
					</tr>
					<tr>
						<td>Last notification</td>
						<td>
							@if(isset($server_info["last_notification"]) AND $server_info["last_notification"])
								{{ Helpers::diffForHumans($server_info["last_notification"]) }}
							@else
								none
							@endif
						</td>
					</tr>
					<tr>
						<td>Connected sockets</td>
						<td>{{ $server_info["sockets"] }}</td>
					</tr>
					<tr>
						<td>Connected users</td>
						<td>{{ $server_info["users"] }}</td>
					</tr>
				</table>
			@else
				Der Chat-Server scheint momentan <span style="color: red;font-weight: bold;">offline</span> zu sein.
			@endif
		</div>
	</div>
@stop