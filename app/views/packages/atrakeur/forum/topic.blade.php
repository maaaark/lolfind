@section('forum_title', $topic->title." - ")
@section('forum_pos')
	@include('forum::partials.pathdisplay')
@stop

<div style="float: right;padding-top: 20px;">
	@include('forum::partials.postbutton', array('message' => trans('forum::base.new_reply'), 'url' => $topic->postUrl, 'accessModel' => $topic))
</div>

<h1>{{ $topic->title }}</h1>
<div class="forum_posts">
	@foreach ($messages as $message)
		@include('forum::partials.message', compact('message'))
	@endforeach
</div>

<div style="float: right;">
	@include('forum::partials.postbutton', array('message' => trans('forum::base.new_reply'), 'url' => $topic->postUrl, 'accessModel' => $topic))
</div>

{{ $messages->links() }}
