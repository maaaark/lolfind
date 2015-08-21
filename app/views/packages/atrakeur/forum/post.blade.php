@section('forum_title', 'New topic - ')
@section('forum_pos')
	@include('forum::partials.pathdisplay', compact('parentCategory', 'category', 'topic'))
@stop

@include('forum::partials.errorbox')

{{ Form::open(array('url' => $actionUrl, 'class' => 'form-horizontal')) }}
<fieldset>

<!-- Form Name -->
<legend>{{ trans('forum::base.new_topic_title') }}</legend>

<div class="control-group">
	<label class="control-label" for="title">{{ trans('forum::base.title') }}</label>
	<div class="controls">
		{{ Form::text('title', null, array("class" => "forum_create_input")) }}
	</div>
</div>

<div class="control-group">
	<label class="control-label" for="data">{{ trans('forum::base.label_your_message') }}</label>
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
