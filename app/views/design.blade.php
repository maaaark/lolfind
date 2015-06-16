<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html>
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="league of legends, team, player. find, search" />
    <meta name="description" content="Find players or teams for League of Legends">
    <title>Teamranked.com - Find players or teams for League of Legends</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">

    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">

    <!-- Google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

    <link href="rs-plugin/css/settings.css" rel="stylesheet">
    <link href="css/extralayers.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/network.css">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <script src="/js/jquery.flashignite_dropdown.js"></script>
    <script src="/js/icheck/icheck.min.js"></script>
    <script src="/js/team_search_dropdowns.js"></script>

    @if(Auth::check())
        <!-- FI-Network Server -->
        <link rel="stylesheet" href="/css/chat.css">
        <script>
            var fi_server_host = "ws://{{ trim($_SERVER['SERVER_ADDR']) }}:8080/";
            var fi_server_user = {{ Auth::user()->id }};
        </script>
        <script src="/js/fi_network_server.js"></script>
        <script>
            fi_server_init();
        </script>
    @endif

</head>

<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<!-- @include('network_navi') -->

@if(Auth::check())
    <div id="chat_holder" class="chat_holder"></div>
@endif

<div id="preloader">
    <div class="sk-spinner sk-spinner-wave">
        <div class="sk-rect1"></div>
        <div class="sk-rect2"></div>
        <div class="sk-rect3"></div>
        <div class="sk-rect4"></div>
        <div class="sk-rect5"></div>
    </div>
</div>
<!-- End Preload -->

<div class="layer"></div>
<!-- Mobile menu overlay mask -->

<!-- Header================================================== -->
<header>

    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div id="logo">
                    <a href="#"><img src="img/teamranked_white.png" width="160" height="34" alt="Teamranked.com" data-retina="true" class="logo_normal"></a>
                    <a href="#"><img src="img/teamranked_black.png" width="160" height="34" alt="Teamranked.com" data-retina="true" class="logo_sticky"></a>
                </div>
            </div>
            <nav class="col-md-9 col-sm-9 col-xs-9">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                <div class="main-menu">
                    <div id="header_menu">
                        <img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                    </div>
                    <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="show-submenu">Search Player <i class="icon-down-open-mini"></i></a>
                            <ul>
                                <li><a href="#"><img src="img/roles/tank.jpg" height="23" class="img-circle" > Top-Laner</a></li>
                                <li><a href="#"><img src="img/roles/fighter.jpg" height="23" class="img-circle" > Jungler</a></li>
                                <li><a href="#"><img src="img/roles/mage.jpg" height="23" class="img-circle" > Mid-Laner</a></li>
                                <li><a href="#"><img src="img/roles/marksman.jpg" height="23" class="img-circle" > Marksman</a></li>
                                <li><a href="#"><img src="img/roles/support.jpg" height="23" class="img-circle" > AD-Carry</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="show-submenu">Search Team <i class="icon-down-open-mini"></i></a>
                            <ul>
                                <li><a href="#"><img src="img/leagues/bronze_1.png" height="23"><img src="img/leagues/silver_1.png" height="23"> Bronze &amp; Silver</a></li>
                                <li><a href="#"><img src="img/leagues/gold_1.png" height="23"><img src="img/leagues/platinum_1.png" height="23"> Gold &amp; Platinum</a></li>
                                <li><a href="#"><img src="img/leagues/diamond_1.png" height="23"><img src="img/leagues/challenger_1.png" height="15">&nbsp; Diamond +</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#">Find a Ringer</a>
                        </li>
                        <li class="submenu">
                            <a href="#">Premium</a>
                        </li>
                    </ul>
                </div><!-- End main-menu -->
                <ul id="top_tools">
                    <li>
                        <div class="dropdown dropdown-search">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-search"></i></a>
                            <div class="dropdown-menu">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search...">
                                            <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" style="margin-left:0;">
                                                <i class="icon-search"></i>
                                            </button>
                                            </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div><!-- container -->
</header><!-- End Header -->

@yield('header')

    @include('layouts.errors')
    @yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                    </ul>
                    <p>© Teamranked.com &amp; Flashignite.com 2015</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->

<div id="toTop"></div><!-- Back to top button -->

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

<!-- Common scripts -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script src="rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="js/revolution_func.js"></script>


</body>

</html>