@section('forum_title', 'Reply - ')
@section('forum_pos')
	@include('forum::partials.pathdisplay', compact('parentCategory', 'category', 'topic'))
@stop

@include('forum::partials.errorbox')

{{ Form::open(array('url' => $actionUrl, 'class' => 'form-horizontal')) }}
<fieldset>

<legend>{{ trans('forum::base.post_message') }}</legend>

<div class="control-group">
	<label class="control-label" for="textarea">{{ trans('forum::base.label_your_message') }}</label>
	<div class="controls">
		{{ Form::textarea('data', null, array("class" => "forum_create_textarea")) }}
	</div>
</div>

<div class="control-group">
	<div class="controls">
		{{ Form::submit(trans('forum::base.send')) }}
	</div>
</div>

</fieldset>
{{ Form::close() }}
