<div class="team_calendar">
	<h2>{{ Helpers::niceMonth($month) }} {{ $year }}</h2>

	<div class="calendar_days">
		@for($i = 1; $i <= $days_count; $i++)
			<?php $y = 0; ?>
			@if($i == 1 AND date("N", strtotime($i.".".$month.".".$year)) > 1)
				@for($y = date("N", strtotime($i.".".$month.".".$year)) - 1; $y >= 1; $y--)
					<div class="day other_month">
						<div class="title">
							{{ Helpers::dayNumberToName(date("N", strtotime($i.".".$month.".".$year) - 60*60*24*$y), true) }}
							- {{ date("d.m.Y", strtotime($i.".".$month.".".$year) - 60*60*24*$y) }}
						</div>
					</div>
				@endfor
			@endif
			<div class="day" data-date="{{ date("d.m.Y", strtotime($i.".".$month.".".$year)) }}">
				<div class="title">
					{{ Helpers::dayNumberToName(date("N", strtotime($i.".".$month.".".$year)), true) }}
					- {{ date("d.m.Y", strtotime($i.".".$month.".".$year)) }}
				</div>
				<div class="day_content">
					@if(false)
					@else
						<div class="no_events">No events planned</div>
					@endif
				</div>
			</div>
		@endfor

		@for($x = 1; $x <= 7 - (($days_count + date("N", strtotime("1.".$month.".".$year)) - 1 - (floor(($i + $y) / 7) * 7)) % 7); $x++)
			<div class="day other_month">
				<div class="title">
					{{ Helpers::dayNumberToName(date("N", strtotime(($i - 1).".".$month.".".$year) + 60*60*24*$x), true) }}
					- {{ date("d.m.Y", strtotime(($i - 1).".".$month.".".$year) + 60*60*24*$x) }}
				</div>
			</div>
		@endfor
	</div>
</div>