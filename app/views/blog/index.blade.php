@extends('design')
@section('title', "Blog")
@section('css_addition')
   <link rel="stylesheet" href="/css/teamranked_blog.css">
@stop
@section('content')
	<div class="blog_body">
		<div class="blog_content">
			@if(isset($blog_posts) AND $blog_posts->count() > 0)
				<div class="row">
					<div class="col-md-8">
						<h1>Blog</h1>
						<div class="blog_posts_list">
							@foreach($blog_posts as $post)
								<div class="blog_post_element">
									<table>
									<tr>
										<td class="post_image">
											<a href="/blog/{{ date('Y-m-d', strtotime($post->created_at)) }}/{{ $post->id }}-{{ trim(Helpers::str_slug($post->title)) }}">
												@if($post->picture AND trim($post->picture) != "")
													<img src="/uploads/blog/small_{{ $post->picture }}">
												@else
													<img src="/img/blog_post_image.jpg">
												@endif
											</a>
										</td>
										<td class="post_info">
											<div class="post_title">{{ $post->title }}</div>
											<div class="post_teaser">
												{{ trim(substr(trim($post->text), 0, 100)) }}...
												<a href="/blog/{{ date('Y-m-d', strtotime($post->created_at)) }}/{{ $post->id }}-{{ trim(Helpers::str_slug($post->title)) }}">read more</a>
											</div>
											<div class="post_infos">
												{{ $post->created_at->diffForHumans() }}
											</div>
										</td>
									</tr>
									</table>
								</div>
							@endforeach
						</div>

						<div>
							{{ $blog_posts->links() }}
						</div>
					</div>
					<div class="col-md-4">
						@include('blog.right_navi')
					</div>
				</div>
			@else
				<div style="padding: 30px;color: rgba(0,0,0,0.6);text-align: center;">
					<img src="/img/sad_amumu.png" style="margin-top: 30px;">
					<div style="padding-top: 40px;font-size: 18px;">
						No blog posts published yet :(
					</div>
				</div>
			@endif
		</div>
	</div>
@stop