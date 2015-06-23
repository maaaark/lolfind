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

@elseif($notification->type == "normal_text")
   <div class="notification_linked_element no_click">
      {{ trim($notification->value1) }}
   </div>
@endif