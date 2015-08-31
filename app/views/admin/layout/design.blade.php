<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')Admin - Teamranked</title>

		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/admin.css">
		
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/chartjs/Chart.min.js"></script>

		<script>
			$(document).ready(function(){
				$("#page_holder").css("padding-top", $("#page_header").outerHeight());
			});
		</script>
	</head>
	<body>
		@include('admin.layout.navigation')
		<div class="page_holder" id="page_holder">
			<div>@include('admin.layout.errors')</div>
			@yield('content')
		</div>
		<script>
			var nav_page = '@yield("nav_page")';
			if(nav_page && nav_page.trim() != ""){
				$("nav.navbar li[data-nav='"+nav_page+"'").addClass("active");
			}
		</script>
	</body>
</html>