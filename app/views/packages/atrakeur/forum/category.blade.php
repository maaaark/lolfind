@section('forum_title', $category->title.' - ')
@section('forum_pos')
	@include('forum::partials.pathdisplay')
@stop

<div style="float: right;padding-top: 5px;">
	@include('forum::partials.postbutton',array('message' => trans('forum::base.new_topic') , 'url' => $category->postUrl, 'accessModel' => $category))
</div>
<h1 style="margin-bottom: 15px;margin-top: 0px;padding-top: 0px;">Overview</h1>

<div class="topics_table_holder">
	@if ($topics != NULL && count($topics) != 0)
		<table class="table topics_table">
			<thead>
				<tr>
					<th></th>
					<th>Subject</th>
					<th>Replies</th>
				</tr>
			</thead>
			<tbody>
				@foreach($topics as $topic)
					<tr>
						<td class="thread_icon">
							<img src="/img/roles/mage.jpg">
						</td>
						<td class="name">
							<a href={{$topic->url}}>{{{ $topic->title }}}</a>
							<div class="info">
								<?php
									$summoner_temp  = false;
									$user_temp 		= Helpers::getUser($topic->author_id);
									if($user_temp && isset($user_temp->id) && $user_temp->id > 0){
										$summoner_temp = Helpers::get_summoner($user_temp->summoner_id, $user_temp->region);
									}
								?>
								@if($summoner_temp AND isset($summoner_temp->id) AND $summoner_temp->id > 0)
									by {{ $summoner_temp->name }}
								@else
									by unknown summoner
								@endif

								@if($topic->last_reply AND $topic->last_reply != "0000-00-00 00:00:00")
									- Last reply: {{ Helpers::diffForHumans($topic->last_reply) }}
								@else
									- created: {{ Helpers::diffForHumans($topic->created_at) }}
								@endif
							</div>
						</td>
						<td class="replies">
							{{ $topic->replyCount }}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div style="padding: 30px;text-align: center;">	
			<div style="font-size: 26px;margin-bottom: 18px;">No topics created yet ...</div>
			@include('forum::partials.postbutton',array('message' => "Create the first topic" , 'url' => $category->postUrl, 'accessModel' => $category))
		</div>	
	@endif
</div>
@if($topics != NULL && count($topics) != 0)
	{{ $topics->links() }}
@endif