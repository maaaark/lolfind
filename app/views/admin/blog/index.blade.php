@extends('admin.layout.design')
@section('title', 'Blog - ')
@section('nav_page', 'blog')
@section('content')
	<div class="page_width">
		<div style="float: right;padding-top: 15px;">
			<a href="/admin/blog/post/new" class="btn btn-primary">New blog post</a>
		</div>
		<h1>Blog</h1>

		<div class="table_holder">
			<table class="table">
				<thead>
					<th><center>ID</center></th>
					<th>Title</th>
					<th>Created-At</th>
					<th>Status</th>
					<th colspan="3">Options</th>
				</thead>
				<tbody>
					@foreach($blog_posts as $post)
						<tr>
							<td><center>{{ $post->id }}</center></td>
							<td>{{ $post->title }}</td>
							<td>{{ $post->created_at->diffForHumans() }}</td>
							<td>
								@if($post->status == 100)
									<span style="color: green;">Published</span>
								@elseif($post->status == 1)
									<span style="color: orange;">Ready</span>
								@else
									On edit
								@endif
							</td>
							<td style="width: 51px;">
								<a href="/admin/blog/post/{{ $post->id }}" class="btn btn-info">Edit</a>
							</td>
							<td style="width: 70px;">
								<a href="javascript:void(0);" data-postId="{{ $post->id }}" class="btn btn-danger delete_blog_post_btn">Delete</a>
							</td>
							<td style="width: 78px;">
								<a href="/blog/{{ date('Y-m-d', strtotime($post->created_at)) }}/{{ $post->id }}-{{ trim(Helpers::str_slug($post->title)) }}" class="btn btn-default">Preview</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		{{ $blog_posts->links() }}

		<script>
			$(".delete_blog_post_btn").click(function(){
				if(confirm('Really delete that blog-post?')) {
				    self.location.href = "/admin/blog/post/"+$(this).attr("data-postId")+"/delete";
				}
			});
		</script>
	</div>
@stop