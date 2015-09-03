<div style="float: right;">
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
@if(isset($event->description) AND trim($event->description) > 0)
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
</script>