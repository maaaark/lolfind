<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')Admin - Teamranked</title>

		<script type="text/javascript" src="/js/jquery.min.js"></script>

		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/admin.css">

		<script>
			$(document).ready(function(){
				$("#page_holder").css("padding-top", $("#page_header").outerHeight());
			});
		</script>
	</head>
	<body>
		<div class="page_header" id="page_header">
			<div class="bar">
				<a href="/admin"><img src="/img/teamranked_white.png" class="logo"></a>
				<div class="admin_title_flag">ADMIN</div>

				<a href="/summoner/{{ Auth::user()->summoner->region }}/{{ Auth::user()->summoner->name }}">
					<div class="auth_box">
						<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ Auth::user()->summoner->profileIconId }}.png"class="img-circle" height="30">
						{{ Auth::user()->summoner->name }}
					</div>
				</a>
			</div>
			<div class="page_navigation">
				<a href="/admin"><div class="element">Dashboard</div></a>
				<a href="/admin/network_server"><div class="element">Network Server</div></a>
				<a href="/logout"><div class="element logout">Logout</div></a>
			</div>
		</div>
		<div class="page_holder" id="page_holder">
			@yield('content')
		</div>
	</body>
</html>