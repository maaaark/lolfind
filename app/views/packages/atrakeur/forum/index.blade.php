@section('forum_pos')
	@include('forum::partials.pathdisplay')
@stop

<div style="padding: 25px;background: #FF7100;border-radius: 4px;margin-bottom: 20px;color: #fff;">
	<div style="font-size: 18px;margin-bottom: 10px;">Attention!</div>
	Please keep in mind, that this forum is very quick implemented to have a temporary opportunity to collect feedback and bugs.<br/>
	We are going to create a better version of this forum after our main services run great.
</div>

<h1 style="margin-bottom: 25px;margin-top: 0px;padding-top: 0px;">Overview</h1>

<div class="forum_list">
	@foreach ($categories as $category)
		<div class="forum_list_element">
			<table class="table">
				<tr>
					<td class="forum_icon">
						<img src="/img/roles/mage.jpg">
					</td>
					<td class="title">
						<a href="{{$category->url}}">{{{ $category->title }}}</a>
						@if(isset($category->subtitle) AND trim($category->subtitle) != "")
							<div class="category_subtitle">{{{ $category->subtitle }}}</div>
						@endif
					</td>
					<td class="topics">
						{{ $category->topicCount }} topics
					</td>
					<td class="replies">
						{{ $category->replyCount }} replies
					</td>
				</tr>
			</table>
		</div>
	@endforeach
</div>