<ul>
	<li><a href="{{ Config::get('forum::routes.base') }}">{{ trans('forum::base.index') }}</a></li>
	@if (isset($parentCategory) && $parentCategory)
		<li><a href="{{{ $parentCategory->url }}}">{{{ $parentCategory->title }}}</a></li>
	@endif
	@if (isset($category) && $category)
		<li><a href="{{{ $category->url }}}">{{{ $category->title }}}</a></li>
	@endif
	@if (isset($topic) && $topic)
		<li><a href="{{{ $topic->url }}}">{{{ $topic->title }}}</a></li>
	@endif
</ul>