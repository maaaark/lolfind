<div style="float: right;">
	@if(TeamPremiumCheck::can_edit_calendar(Auth::user()->id, $ranked_team))
		<button class="btn_1" id="btn_delete_from_lightbox_event"><i class="icon-trash-2"></i> Delete</button>	
		<button class="btn_1" id="btn_edit_from_lightbox_event"><i class="icon-pencil-2"></i> Edit</button>	
	@endif
	<button class="btn_1" id="btn_back_from_lightbox_event">Back</button>
</div>
<h3 style="padding-top: 8px;">{{ $event->name }}</h3>

<div style="margin: 20px;border: 1px solid rgba(0,0,0,0.2);background: rgba(0,0,0,0.05);border-radius: 4px;">
	<table class="table" style="margin: 0px;">
		<tbody>
			<tr>
				<td style="border-top: none;width: 25%;"><b>Event-Type</b></td>
				<td style="border-top: none;">{{ ucfirst($event->event_type) }}</td>
			</tr>
			<tr>
				<td><b>Start</b></td>
				<td>{{ date("H:i", strtotime($event->begin)) }}</td>
			</tr>
			<tr>
				<td><b>End</b></td>
				<td>{{ date("H:i", strtotime($event->end)) }}</td>
			</tr>
		</tbody>
	</table>
</div>

<h4 style="margin-top: 30px;">Description</h3>
@if(isset($event->description) AND trim($event->description) != "")
	{{ strip_tags(nl2br(trim($event->description)), "<br/><br>") }}
@else
	<div style="padding: 15px;text-align: center;">
		No description ...
	</div>
@endif

<script>
$("#btn_back_from_lightbox_event").click(function(){
	$("#panel_add_event").hide();
	$("#panel_lightbox_event").hide();
	$("#panel_lightbox_start").show();
	$("#panel_lightbox_event").html("");
});

@if(TeamPremiumCheck::can_edit_calendar(Auth::user()->id, $ranked_team))
	$("#btn_edit_from_lightbox_event").click(function(){
		$("#panel_edit_event").html("<div style='padding: 25px;text-align:center;'>Loading ...</div>");
		$("#panel_edit_event").show();
		$("#panel_lightbox_event").hide();
		$("#panel_lightbox_start").hide();
		$("#panel_lightbox_event").html("");

		$.post("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox/edit", {"event": "{{ $event->id }}"}).done(function(data){
			$("#panel_edit_event").html(data);
		});
	});

	$("#btn_delete_from_lightbox_event").click(function(){
		if(confirm("Really delete this event?")){
			$("#panel_lightbox_event").html("<div style='padding: 25px;text-align:center;'>Loading ...</div>");
			$("#panel_lightbox_event").show();
			$("#panel_lightbox_start").hide();

			lightboxCloseBtn(false);
	    	allowLightboxCloseBG(false);
			$.post("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox/delete", {"event": "{{ $event->id }}"}).done(function(data){
				load_calendar_month();
		    	
		    	$.get("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox", {"date": '{{ date("d.m.Y", strtotime($event->date)) }}'}).done(function(data){
                    $("#fi_lightbox .content").html(data);
					lightboxCloseBtn(true);
			    	allowLightboxCloseBG(true);
                });
			});
		}
	});
@endif
</script>