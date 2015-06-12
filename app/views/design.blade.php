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
		<link rel="stylesheet" href="/js/icheck/orange.css">
		@yield('css_addition')

		<script src="/js/jquery.min.js"></script>
		<script src="/js/jquery.flashignite_dropdown.js"></script>
		<script src="/js/icheck/icheck.min.js"></script>
	</head>

	<body>
		<div id="navigations" class="navigations">
			@include('network_navi')
			<div class="main_navi">
				<div class="width">
					<a href="/teams"><div class="navi_element nav_el">Teams</div></a>
					<a href="/"><div class="navi_element nav_el">Startseite</div></a>
					<a href="/"><div class="navi_element logo"></div></a>
				</div>
			</div>
		</div>

		<div class="page_content" id="content">
            @include('layouts.errors')
			@yield('content')
		</div>

		<div class="footer">
			<div style="width: 100%;max-width: 1100px;margin: auto;">
				<div class="fi_network_tag">
					<img src="http://flashignite.com/img/flashignite_logo.png"> FLASHIGNITE Network
				</div>
				Powered by <a href="http://flashignite.com">Flashignite.com</a>
				<div style="color: rgba(255,255,255,0.4);">&copy; 2015 Flashignite</div>
			</div>
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
				var login_box = $("#nw_login_box");
				scrollNavigation();

				$("#nw_login_btn").click(function(){
					pos = $(this).offset();
					pos = $(document).width() - parseInt(pos["left"]);
					pos = pos - $(this).outerWidth(true);
					login_box.css("right", pos);

					if(login_box.hasClass("open")){
						login_box.removeClass("open");
						$(this).removeClass("active");
					} else {
						$(this).addClass("active");
						login_box.addClass("open");
					}
				});

				$("#content").click(function(){
					if(login_box.hasClass("open")){
						login_box.removeClass("open");
						$("#nw_login_btn").removeClass("active");
					}
				});
				
				  $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-orange',
                    radioClass: 'iradio_flat-orange'
                  });
			});
		</script>
	</body>
</html>