@extends('design')
@section('title', $post->title." - Blog")
@section('css_addition')
   <link rel="stylesheet" href="/css/teamranked_blog.css">
@stop
@section('content')
	<div class="blog_body">
		<div class="blog_content">
			<div class="row">
				<div class="col-md-8">
					<div class="blog_post">
						<h1>{{ $post->title }}</h1>

						<div class="post_image">
							@if($post->picture AND trim($post->picture) != "")
								<img src="/uploads/blog/{{ $post->picture }}">
							@else
								<img src="/img/blog_post_image.jpg">
							@endif
						</div>
						<div class="post_text">
							{{ nl2br($post->text) }}
						</div>
						<div class="post_info">
							{{ $post->created_at->diffForHumans() }}
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div style="text-align: right;margin-bottom: 15px;">
						<a href="/blog">Back to the blog list</a>
					</div>
					@include('blog.right_navi')
				</div>
			</div>
		</div>
	</div>
@stop