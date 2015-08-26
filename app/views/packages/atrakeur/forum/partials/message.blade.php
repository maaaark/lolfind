<div class="forum_post">
	<table class="table forum_post_table">
		<tr class="post_content">
			<td class="author_info border_right">
				<div class="profile_icon">
					<a href="/summoner/{{ $message->author->region }}/{{{ Helpers::get_summoner($message->author->summoner_id, $message->author->region)->name }}}">
						<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ Helpers::get_summoner($message->author->summoner_id, $message->author->region)->profileIconId }}.png">
					</a>
				</div>
				<a href="/summoner/{{ $message->author->region }}/{{{ Helpers::get_summoner($message->author->summoner_id, $message->author->region)->name }}}">
					{{{ Helpers::get_summoner($message->author->summoner_id, $message->author->region)->name }}}
				</a><br/>
				/*
				@if((Helpers::getUser($message->author->id))->hasRole("admin"))
					<i>Administrator</i>
				@endif
				*/
			</td>
			<td class="author_message">
				{{ nl2br(e($message->data)) }}
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