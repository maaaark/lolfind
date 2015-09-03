<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/admin">
				<img src="/img/teamranked_black.png" style="float: left;height: 23px;margin-right: 5px;">
				<span style="font-size: 14px;">Admin</span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li data-nav="dashboard"><a href="/admin">Dashboard</a></li>
				<li data-nav="blog" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/admin/blog">Overview</a></li>
						<li><a href="/admin/blog/post/new">Create blog post</a></li>
					</ul>
				</li>
				<li data-nav="users"><a href="/admin/users">Users</a></li>
				<li data-nav="nw_server"><a href="/admin/network_server">Network Server</a></li>
				<li data-nav="statistics"><a href="/admin/statistics">Statistics</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<!--<li><a href="#">Link</a></li>-->

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/summoner/{{ Auth::user()->summoner->region }}/{{ Auth::user()->summoner->name }}">Profile</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="/logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>