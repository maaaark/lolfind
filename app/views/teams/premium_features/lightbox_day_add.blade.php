<div style="float: right;">
			<button class="btn_1" id="btn_switch_to_start">Back</button>
</div>
<div style="font-size: 16px;">Add event:</div>
<div>
	<div class="form-group">
	    <label for="inputName">Event name</label>
	    <input type="text" class="form-control" id="inputName" placeholder="Event name" name="event_type">
	</div>
	<div class="form-group">
	    <label for="inputType">Event type</label>
	    <select class="form-control" id="inputType">
	    	<option value="default">Default</option>
	    	<option value="match">Match</option>
	    	<option value="meeting">Meeting</option>
	    	<option value="training">Training</option>
	    </select>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="inputBeginHour">Begin (hour)</label>
			    <select class="form-control" id="inputBeginHour">
			    	@for($i = 0; $i <= 23; $i++)
			    		<option value="{{ $i }}">{{ $i }}</option>
			    	@endfor
			    </select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputBeginHour">Begin (minute)</label>
			    <select class="form-control" id="inputBeginMinute">
			    	@for($i = 0; $i <= 59; $i++)
			    		<option value="{{ $i }}">{{ $i }}</option>
			    	@endfor
			    </select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="inputEndHour">End (hour)</label>
			    <select class="form-control" id="inputEndHour">
			    	@for($i = 0; $i <= 23; $i++)
			    		<option value="{{ $i }}">{{ $i }}</option>
			    	@endfor
			    </select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputEndHour">End (minute)</label>
			    <select class="form-control" id="inputEndMinute">
			    	@for($i = 0; $i <= 59; $i++)
			    		<option value="{{ $i }}">{{ $i }}</option>
			    	@endfor
			    </select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescription">Description</label>
		<textarea class="form-control" rows="3" id="inputDescription" placeholder="Description"></textarea>
	</div>
	<div style="text-align: right;padding-top: 5px;">
		<button class="btn_1" id="save_calendar_event_btn">Save</button>
	</div>
</div>

<script>
$("#save_calendar_event_btn").click(function(){
	if($("#inputName").val().trim() != "" && $("#inputType").val().trim() != "" &&
	   $("#inputBeginHour").val().trim() != "" && $("#inputBeginMinute").val().trim() != "" &&
	   $("#inputEndHour").val().trim() != "" && $("#inputEndMinute").val().trim() != ""){
	   	lightboxCloseBtn(false);
	    allowLightboxCloseBG(false);
		object = {
			"date":			'{{ $date }}',
			"name": 		$("#inputName").val().trim(),
			"type": 		$("#inputType").val().trim(),
			"begin_hour": 	$("#inputBeginHour").val().trim(),
			"begin_minute": $("#inputBeginMinute").val().trim(),
			"end_hour": 	$("#inputEndHour").val().trim(),
			"end_minute": 	$("#inputEndMinute").val().trim(),
			"description": 	$("#inputDescription").val().trim()
		}
		
		$("#inputName").val('');
		$("#inputDescription").val('');
		$("#panel_add_event_saving").show();
		$("#panel_add_event").hide();

		$.post("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox/add", object).done(function(data){
			console.log(data);
			if(data.trim() == "success"){
				load_calendar_month();
		    	
		    	$.get("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox", {"date": '{{ date("d.m.Y", strtotime($date)) }}'}).done(function(data){
                    $("#fi_lightbox .content").html(data);
					lightboxCloseBtn(true);
			    	allowLightboxCloseBG(true);
                });
			} else {
				lightboxCloseBtn(true);
		    	allowLightboxCloseBG(true);
		    	$("#panel_add_event_saving").hide();
				$("#panel_add_event").hide();
				$("#panel_lightbox_start").show();
				alert("An unknown error occurred");
			}
		});
	} else {
		alert("You have to fill all fields.");
	}
});
</script>