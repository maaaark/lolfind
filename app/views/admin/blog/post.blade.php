@extends('admin.layout.design')
@section('title', 'Blog - ')
@section('content')
	<div class="page_width">
		<h1>Blog <span>> Post</span></h1>

		<div class="content_box">
			<form action="/admin/blog/post/{{ $id }}/action" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="inputTitle">Title:</label>
					@if($post)
						<input type="text" class="form-control" id="inputTitle" placeholder="Title" name="title" value="{{ $post->title }}">
					@else
						<input type="text" class="form-control" id="inputTitle" placeholder="Title" name="title">
					@endif
				</div>
				<div class="form-group">
					<label for="inputText">Text</label>
					@if($post)
						<textarea class="form-control" rows="8" id="inputText" placeholder="Post text" name="text">{{ $post->text }}</textarea>
					@else
						<textarea class="form-control" rows="8" id="inputText" placeholder="Post text" name="text"></textarea>
					@endif
				</div>
				<div class="form-group">
					@if($post AND trim($post->picture) != "")
						<div style="float: right;">
							Current picture:<br/>
							<a href="/uploads/blog/{{ $post->picture }}" target="_blank">
								<img src="/uploads/blog/small_{{ $post->picture }}" style="height: 50px;">
							</a>
						</div>
					@endif
				    <label for="inputPicture">File input</label>
				    <input type="file" id="inputPicture" name="picture">
				    <p class="help-block">Picture should be FullHD</p>
			    </div>
				<div class="form-group">
					<label for="inputStatus">Status</label>
					<select class="form-control" id="inputStatus" name="status">
						@if($post AND $post->status == 0)
							<option value="0" selected>On edit</option>
						@else
							<option value="0">On edit</option>
						@endif


						@if($post AND $post->status == 1)
							<option value="1" selected>Ready</option>
						@else
							<option value="1">Ready</option>
						@endif
						
						@if($post AND $post->status == 100)
							<option value="100" selected>Published</option>
						@else
							<option value="100">Published</option>
						@endif
					</select>
				</div>
				@if($post)
					<input type="hidden" name="post_id" value="{{ $post->id }}">
				@endif
				<button type="submit" class="btn btn-default">Submit</button>
				<a href="/admin/blog">Abort changes</a>
			</form>
		</div>
	</div>
@stop