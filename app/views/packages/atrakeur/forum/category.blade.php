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
							{{ Helpers::diffForHumans($topic->created_at) }}
							- {{ Helpers::get_summoner(Helpers::getUser($topic->author_id)->summoner_id, Helpers::getUser($topic->author_id)->region)->name }}
						</div>
					</td>
					<td class="replies">
						{{ $topic->replyCount }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	@endif
</div>