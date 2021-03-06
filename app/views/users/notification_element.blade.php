@if($notification->type == "team_application")
	<?php
		$user_temp   = Helpers::getUser($notification->value1);
		$application = Helpers::getApplication($notification->value2);
		$team_temp   = Helpers::getRankedTeam($notification->value3);
	?>

	@if(isset($user_temp->id) AND $user_temp->id > 0 AND isset($team_temp->id) AND $team_temp->id > 0)
		<div class="notification_linked_element no_click">
            <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $user_temp->summoner->profileIconId }}.png" class="notification_summoner_icon">
			<b>{{ $user_temp->summoner->name }}</b> applied to your team <b>{{ $team_temp->name }}</b>

			@if(isset($application->id) AND $application->id > 0)
			<div>
				<button class="btn_1" onclick="fi_server_open_chat({{ $user_temp->id }}, '{{ $user_temp->summoner->name }}', '{{ $user_temp->summoner->profileIconId }}')">
					Answer {{ $user_temp->summoner->name }}
				</button>
				<a href="/teams/{{ $team_temp->region }}/{{ $team_temp->tag }}/applications/{{ $application->id }}" class="btn_1">Details</a>
			</div>
			@else
			<div style="text-style: italic;margin-top: 5px;">
				Application rejected.
			</div>
			@endif
		</div>
	@endif

@elseif($notification->type == "team_application_delete")
	<?php
		$user_temp   = Helpers::getUser($notification->user);
		$team_temp   = Helpers::getRankedTeam($notification->value1);
	?>

	@if(isset($user_temp->id) AND $user_temp->id > 0 AND isset($team_temp->id) AND $team_temp->id > 0)
		<div class="notification_linked_element no_click">
            <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $user_temp->summoner->profileIconId }}.png" class="notification_summoner_icon">
			<b>{{ $team_temp->name }}</b> rejected your application.
		</div>
	@endif
	
@elseif($notification->type == "team_invitation")
    <?php
		$team_temp       = Helpers::getRankedTeam($notification->value1);
		$invitation_temp = Helpers::getInvitation($notification->value2);
	?>
	
    @if(isset($team_temp->id) AND $team_temp->id > 0)
       <div class="notification_linked_element no_click">
            <img src="/img/notifications/notification_invite_to_team.jpg" class="notification_summoner_icon">
            You were invited to join the team <b>{{ $team_temp->name }}</b>.
            
            @if(isset($invitation_temp->id) AND $invitation_temp->id > 0)
            <div>
                <button class="btn_1" onclick="open_team_invitation({{ $invitation_temp->id }});">Show details</button>
            </div>
            @else
            <div style="text-style: italic;margin-top: 5px;">
                Invitation rejected.
            </div>
            @endif
       </div>
    @endif

@elseif($notification->type == "team_calender_event_created")
	<?php
		$team_temp  = Helpers::getRankedTeam($notification->value3);
		$event_temp = Helpers::getTeamCalenderEvent($notification->value2);
		$user_temp  = Helpers::getUser($notification->value1);
	?>
	@if(isset($team_temp->id) AND $team_temp->id > 0 AND isset($event_temp->id) AND $event_temp->id > 0 AND isset($user_temp->id) AND $user_temp->id > 0)
		<div class="notification_linked_element no_click">
			<img src="/img/notifications/notification_invite_to_team.jpg" class="notification_summoner_icon">
			{{ $user_temp->summoner->name }} created a calender event for <b>{{ $team_temp->name }}</b>

			<div>
                <button class="btn_1 notification_calendar_evennt_btn" data-region="{{ $team_temp->region }}" data-teamTag="{{ $team_temp->tag }}" data-event="{{ $event_temp->date }}">Show details</button>
            </div>
		</div>

		<script>
		$(".notification_calendar_evennt_btn").click(function(){
			cal_evnt_temp = $(this).attr("data-event");
			region_cal_evnt_temp = $(this).attr("data-region");
			tag_cal_evnt_temp = $(this).attr("data-teamTag");
            showLightbox("<div style='padding: 25px;text-align: center;'>Loading ...</div>", function(lightbox_content){
            	console.log(region_cal_evnt_temp);
                $.get("/teams/"+region_cal_evnt_temp+"/"+tag_cal_evnt_temp+"/calendar/lightbox", {"date": cal_evnt_temp }).done(function(data){
                    lightbox_content.html(data);
                });
            });
		});
		</script>
	@endif

@elseif($notification->type == "normal_text")
   <div class="notification_linked_element no_click">
      {{ trim($notification->value1) }}
   </div>
@endif