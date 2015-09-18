<div style="float: right;">
	@if(isset($event) AND $event->id > 0)
		<button class="btn_1" id="btn_back_to_start_from_edit">Back</button>
		<script>
			$("#btn_back_to_start_from_edit").click(function(){
				console.log("asd");
				$("#panel_edit_event").hide();
				$("#panel_add_event").hide();
				$("#panel_lightbox_event").hide();
				$("#panel_lightbox_start").show();;
			});
		</script>
	@else
		<button class="btn_1" id="btn_switch_to_start">Back</button>
	@endif
</div>
<div style="font-size: 16px;">Add event:</div>
<div>
	<div class="form-group">
	    <label for="inputName">Event name</label>
	    @if(isset($event) AND $event->id > 0)
	    	<input type="text" class="form-control" id="inputNameEdit" placeholder="Event name" name="event_type" value="{{{ $event->name }}}">
	    @else
	    	<input type="text" class="form-control" id="inputName" placeholder="Event name" name="event_type">
    	@endif
	</div>
	<div class="form-group">
	    <label for="inputTypeEdit">Event type</label>
	    @if(isset($event) AND $event->id > 0)
		    <select class="form-control" id="inputTypeEdit">
		    	@if($event->event_type == "default")
		    		<option value="default" selected>Default</option>
		    	@else
		    		<option value="default">Default</option>
		    	@endif

		    	@if($event->event_type == "match")
		    		<option value="match" selected>Match</option>
	    		@else
		    		<option value="match">Match</option>
	    		@endif

	    		@if($event->event_type == "meeting")
		    		<option value="meeting" selected>Meeting</option>
    			@else
		    		<option value="meeting">Meeting</option>
	    		@endif

	    		@if($event->event_type == "training")
		    		<option value="training" selected>Training</option>
	    		@else
		    		<option value="training">Training</option>
	    		@endif
		    </select>
	    @else
		    <select class="form-control" id="inputType">
		    	<option value="default">Default</option>
		    	<option value="match">Match</option>
		    	<option value="meeting">Meeting</option>
		    	<option value="training">Training</option>
	    	</select>
	    @endif
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="inputBeginHour">Begin (hour)</label>
			    @if(isset($event) AND $event->id > 0)
			    	<select class="form-control" id="inputBeginHourEdit">
			    @else
			    	<select class="form-control" id="inputBeginHour">
			    @endif
			    	@for($i = 0; $i <= 23; $i++)
			    		@if(isset($event) AND $event->id > 0 AND intval(date("H", strtotime($event->begin))) == $i)
			    			<option value="{{ $i }}" selected>{{ $i }}</option>
		    			@else
			    			<option value="{{ $i }}">{{ $i }}</option>
		    			@endif
			    	@endfor
			    </select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputBeginHour">Begin (minute)</label>
				@if(isset($event) AND $event->id > 0)
			    	<select class="form-control" id="inputBeginMinuteEdit">
		    	@else
			    	<select class="form-control" id="inputBeginMinute">
		    	@endif
			    	@for($i = 0; $i <= 59; $i++)
			    		@if(isset($event) AND $event->id > 0 AND intval(date("i", strtotime($event->begin))) == $i)
			    			<option value="{{ $i }}" selected>{{ $i }}</option>
		    			@else
			    			<option value="{{ $i }}">{{ $i }}</option>
		    			@endif
			    	@endfor
			    </select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			    <label for="inputEndHour">End (hour)</label>
			    @if(isset($event) AND $event->id > 0)
			    	<select class="form-control" id="inputEndHourEdit">
			    @else
			    	<select class="form-control" id="inputEndHour">
			    @endif
			    	@for($i = 0; $i <= 23; $i++)
			    		@if(isset($event) AND $event->id > 0 AND intval(date("H", strtotime($event->end))) == $i)
			    			<option value="{{ $i }}" selected>{{ $i }}</option>
		    			@else
			    			<option value="{{ $i }}">{{ $i }}</option>
		    			@endif
			    	@endfor
			    </select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputEndHour">End (minute)</label>
				@if(isset($event) AND $event->id > 0)
			    	<select class="form-control" id="inputEndMinuteEdit">
		    	@else
			    	<select class="form-control" id="inputEndMinute">
		    	@endif
			    	@for($i = 0; $i <= 59; $i++)
			    		@if(isset($event) AND $event->id > 0 AND intval(date("i", strtotime($event->end))) == $i)
			    			<option value="{{ $i }}" selected>{{ $i }}</option>
		    			@else
			    			<option value="{{ $i }}">{{ $i }}</option>
		    			@endif
			    	@endfor
			    </select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="inputDescription">Description</label>
		@if(isset($event) AND $event->id > 0)
			<textarea class="form-control" rows="3" id="inputDescriptionEdit" placeholder="Description">{{{ $event->description }}}</textarea>
		@else
			<textarea class="form-control" rows="3" id="inputDescription" placeholder="Description"></textarea>
		@endif
	</div>
	<div style="text-align: right;padding-top: 5px;">
		@if(isset($event) AND $event->id > 0)
			<button class="btn_1" id="edit_calendar_event_btn">Save</button>
		@else
			<button class="btn_1" id="save_calendar_event_btn">Save</button>
		@endif
	</div>
</div>

<script>
function save_calendar_event(edit_mode){
	if(typeof edit_mode != "undefined" && edit_mode){
		var temp_names = {
			"name": "#inputNameEdit",
			"type": "#inputTypeEdit",
			"begin_hour": "#inputBeginHourEdit",
			"begin_minute": "#inputBeginMinuteEdit",
			"end_hour": "#inputEndHourEdit",
			"end_minute": "#inputEndMinuteEdit",
			"description": "#inputDescriptionEdit"
		}
	} else {
		var temp_names = {
			"name": "#inputName",
			"type": "#inputType",
			"begin_hour": "#inputBeginHour",
			"begin_minute": "#inputBeginMinute",
			"end_hour": "#inputEndHour",
			"end_minute": "#inputEndMinute",
			"description": "#inputDescription"
		}
	}

	if($(temp_names.name).val().trim() != "" && $(temp_names.type).val().trim() != "" &&
	   $(temp_names.begin_hour).val().trim() != "" && $(temp_names.begin_minute).val().trim() != "" &&
	   $(temp_names.end_hour).val().trim() != "" && $(temp_names.end_minute).val().trim() != ""){
	   	lightboxCloseBtn(false);
	    allowLightboxCloseBG(false);
		object = {
			@if(isset($event) AND $event->id > 0)
				"event": '{{ $event->id }}',
				"update": "true",
			@endif
			"date":			'{{ $date }}',
			"name": 		$(temp_names.name).val().trim(),
			"type": 		$(temp_names.type).val().trim(),
			"begin_hour": 	$(temp_names.begin_hour).val().trim(),
			"begin_minute": $(temp_names.begin_minute).val().trim(),
			"end_hour": 	$(temp_names.end_hour).val().trim(),
			"end_minute": 	$(temp_names.end_minute).val().trim(),
			"description": 	$(temp_names.description).val().trim()
		}
		
		$("#inputName").val('');
		$("#inputDescription").val('');
		$("#panel_add_event_saving").show();
		$("#panel_add_event").hide();

		$.post("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox/add", object).done(function(data){
			if(data.trim() == "success"){
				if(typeof load_calendar_month != "undefined"){
					load_calendar_month();
				}
		    	
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
}

$("#save_calendar_event_btn").click(function(){
	save_calendar_event();
});

$("#edit_calendar_event_btn").click(function(){
	save_calendar_event(true);
});
</script>