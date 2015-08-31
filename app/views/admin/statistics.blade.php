@extends('admin.layout.design')
@section('title', 'Network Server - ')
@section('nav_page', 'statistics')
@section('content')
	<div class="page_width">
		<h1>Statistiken</h1>

		<div class="row">
			<div class="col-lg-6">
				<div class="content_box">
					<h2>Invitations-Count:</h2>
					<canvas id="invitations_chart" style="width: 100% !important;height: auto !important;max-height: 300px;"></canvas>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="content_box">
					<h2>Applictations-Count:</h2>
					<canvas id="applications_chart" style="width: 100% !important;height: auto !important;max-height: 300px;"></canvas>
				</div>
			</div>
		</div>

		<div class="row" style="margin-top: 35px;">
			<div class="col-lg-6">
				<div class="content_box">
					<h2>Chats-Count:</h2>
					<canvas id="chats_chart" style="width: 100% !important;height: auto !important;max-height: 300px;"></canvas>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="content_box">
					<h2>Notifications-Count:</h2>
					<canvas id="notifications_chart" style="width: 100% !important;height: auto !important;max-height: 300px;"></canvas>
				</div>
			</div>
		</div>

		<script>
			invitations_chart_data = {
				labels: [
					@foreach($invitations as $element)
						'{{ $element["date"] }}',
					@endforeach
				],
				datasets: [
					{
						label: "Test",
						data: [
							@foreach($invitations as $element)
								{{ $element["count"] }},
							@endforeach
						],
						fillColor: "rgba(151,187,205,0.2)",
            			strokeColor: "rgba(151,187,205,1)",
            			pointColor: "rgba(151,187,205,1)",
					}
				]
			};
			var invitations_chart = new Chart(document.getElementById("invitations_chart").getContext("2d")).Line(invitations_chart_data);

			applications_chart_data = {
				labels: [
					@foreach($applications as $element)
						'{{ $element["date"] }}',
					@endforeach
				],
				datasets: [
					{
						label: "Test",
						data: [
							@foreach($applications as $element)
								{{ $element["count"] }},
							@endforeach
						],
						fillColor: "rgba(151,187,205,0.2)",
            			strokeColor: "rgba(151,187,205,1)",
            			pointColor: "rgba(151,187,205,1)",
					}
				]
			};
			var applications_chart = new Chart(document.getElementById("applications_chart").getContext("2d")).Line(applications_chart_data);

			chats_chart_data = {
				labels: [
					@foreach($chats as $element)
						'{{ $element["date"] }}',
					@endforeach
				],
				datasets: [
					{
						label: "Test",
						data: [
							@foreach($chats as $element)
								{{ $element["count"] }},
							@endforeach
						],
						fillColor: "rgba(151,187,205,0.2)",
            			strokeColor: "rgba(151,187,205,1)",
            			pointColor: "rgba(151,187,205,1)",
					}
				]
			};
			var chats_chart = new Chart(document.getElementById("chats_chart").getContext("2d")).Line(chats_chart_data);

			notifications_chart_data = {
				labels: [
					@foreach($notifications as $element)
						'{{ $element["date"] }}',
					@endforeach
				],
				datasets: [
					{
						label: "Test",
						data: [
							@foreach($notifications as $element)
								{{ $element["count"] }},
							@endforeach
						],
						fillColor: "rgba(151,187,205,0.2)",
            			strokeColor: "rgba(151,187,205,1)",
            			pointColor: "rgba(151,187,205,1)",
					}
				]
			};
			var notifications_chart = new Chart(document.getElementById("notifications_chart").getContext("2d")).Line(notifications_chart_data);
		</script>
	</div>
@stop