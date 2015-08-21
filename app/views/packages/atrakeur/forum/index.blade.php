@section('forum_pos')
	@include('forum::partials.pathdisplay')
@stop

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