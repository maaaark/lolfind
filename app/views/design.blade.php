<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Flashignite.com">
		<title>@yield('title')</title>

		<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/font-awesome.css">
		<link rel="stylesheet" href="/css/flashignite_lightbox.css">
		<link rel="stylesheet" href="/css/style.css">
		<link rel="stylesheet" href="/css/network.css">

		<script src="/js/jquery.min.js"></script>
	</head>

	<body>
		<div id="navigations" class="navigations">
			@include('network_navi')
			<div class="main_navi">
				<div class="width">
					<div class="navi_element nav_el">Startseite</div>
					<div class="navi_element nav_el">Teams</div>
					<div class="navi_element logo">
						LoL-Find
					</div>
				</div>
			</div>
		</div>

		<div class="page_content" id="content">
			@yield('content')
		</div>

		<script>
			function scrollNavigation(){
				navi 	= $("#navigations");
				changed = false;
				if($(document).scrollTop() <= 30){
					if(navi.hasClass("scrolled")){
						navi.removeClass("scrolled");
					}
				} else {
					if(! navi.hasClass("scrolled")){
						navi.addClass("scrolled");
					}
				}
			}

			$(document).scroll(function(){
				scrollNavigation();
			});

			$(document).ready(function(){
				scrollNavigation();
			});
		</script>
	</body>
</html>