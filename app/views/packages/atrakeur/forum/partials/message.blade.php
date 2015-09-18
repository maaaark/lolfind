<?php
$summoner_temp 	= false;
$user 			= Helpers::getUser($message->author->id);
if(isset($message->author->summoner_id) && $message->author->summoner_id > 0 && isset($message->author->region)){
	$summoner_temp = Helpers::get_summoner($message->author->summoner_id, $message->author->region);
}
?>

@if($user->hasRole("admin"))
	<div class="forum_post admin_post">
@else
	<div class="forum_post">
@endif
	<table class="table forum_post_table">
		<tr class="post_content">
			<td class="author_info border_right">
				@if($summoner_temp AND isset($summoner_temp->id) AND $summoner_temp->id > 0)
					<div class="profile_icon">
						<a href="/summoner/{{ $message->author->region }}/{{{ $summoner_temp->name }}}">
							<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner_temp->profileIconId }}.png">
						</a>
					</div>
					<a href="/summoner/{{ $message->author->region }}/{{ $summoner_temp->name }}}">
						{{{ $summoner_temp->name }}}
					</a><br/>
					@if($user->hasRole("admin"))
						<i>Administrator</i>
					@endif
				@else
					<div style="text-align: center;color: rgba(0,0,0,0.6);">
						Unknown summoner
					</div>
				@endif

			</td>
			<td class="author_message">
				<div style="position: relative;z-index: 10;">{{ nl2br(e($message->data)) }}</div>
				@if($user->hasRole("admin"))
					<img src="/img/teamranked_black.png" style="position: absolute;z-index: 8;opacity: 0.2;bottom: 10px;right: 10px;height: 30px;">
				@endif
			</td>
		</tr>
		<tr class="post_info">
			<td class="border_right">
				@include('forum::partials.postbutton', array('message' => 'Edit', 'url' => $message->postUrl, 'accessModel' => $message))
			</td>
			<td class="date">
				{{ Helpers::diffForHumans($message->created_at) }}
				@if ($message->updated_at != null && $message->created_at != $message->updated_at)
					- Updated: {{ $message->updated_at }}
				@endif
			</td>
		</tr>
	</table>
</div>