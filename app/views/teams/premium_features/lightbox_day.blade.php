<h2>
	{{ Helpers::dayNumberToName(date("N", strtotime($date))) }}:
	<span style="font-size: 22px;">{{ date("Y-d-m", strtotime($date)) }}</span>
</h2>

@if(TeamPremiumCheck::can_edit_calendar(Auth::user()->id, $ranked_team))
	<div id="panel_add_event" style="padding: 15px;background: rgba(0,0,0,0.1);border: 1px solid rgba(0,0,0,0.15);border-radius: 10px;margin-top: 15px;display: none;">
		@include('teams.premium_features.lightbox_day_add')
	</div>
	<div id="panel_add_event_saving" style="display: none;">
		<div style="padding: 25px;text-align: center;font-size: 16px;">
			Saving the event ... This takes a few seconds
		</div>
	</div>
@endif

<div id="panel_lightbox_start">
	@if(TeamPremiumCheck::can_edit_calendar(Auth::user()->id, $ranked_team))
		<div style="text-align: right;">
			<button class="btn_1" id="btn_switch_to_creation">Add a event</button>
		</div>
	@endif
	
	<div id="events" style="margin-top: 15px;">
		@if(isset($events) AND count($events) > 0)
			@foreach($events as $event)
				<div class="team_calendar_event_row" data-event="{{ $event->id }}">
					<div style="font-weight: bold;font-size: 16px;">
						@if($event->event_type == "match")
							<span style="opacity: 0.6;">[MATCH]</span>
						@endif
						{{{ $event->name }}}
					</div>
					<div style="padding-top: 3px;">
						Starts: {{ date("H:i", strtotime($event->begin)) }} | 
						Ends: {{ date("H:i", strtotime($event->begin)) }}
					</div>
				</div>
			@endforeach

			<script>
				$("#events .team_calendar_event_row").click(function(){
					$("#panel_lightbox_event").html("<div style='padding: 25px;text-align: center;'>Loading ...</div>");
					$.post("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox/event", {"event": $(this).attr("data-event")}).done(function(data){
						$("#panel_lightbox_event").html(data);
						$("#panel_lightbox_event").show();
						$("#panel_add_event").hide();
						$("#panel_lightbox_start").hide();
					});
				});
			</script>
		@else
			<div id="no_calendar_events">
				<div style="padding: 25px;color: #555;text-align: center;">
					No events created yet ...
				</div>
			</div>
		@endif
	</div>
</div>

<div id="panel_lightbox_event"></div>

<script>
	$("#btn_switch_to_creation").click(function(){
		$("#panel_add_event").show();
		$("#panel_lightbox_start").hide();
		$("#panel_lightbox_event").hide();
	});

	$("#btn_switch_to_start").click(function(){
		$("#panel_add_event").hide();
		$("#panel_lightbox_event").hide();
		$("#panel_lightbox_start").show();;
	});
</script>