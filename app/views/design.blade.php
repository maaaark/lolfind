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
    <meta name="google-site-verification" content="EcX2_Wu6MfPgQBTpv9RcRgemiG1ImqenDjqMxRCgGq4" />
    <title>Teamranked.com - Find players or teams for League of Legends</title>

    <!-- Favicons-->
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link rel="icon" sizes="180x180" href="/img/profile_picture.jpg">
    <meta name="theme-color" content="#AF360E">

    <!-- BASE CSS -->
    <link href="/css/base.css" rel="stylesheet">

    <!-- Google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
    
    <link href="/rs-plugin/css/settings.css" rel="stylesheet">
    <link href="/css/extralayers.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/network.css">
    <link rel="stylesheet" href="/css/teamranked.css">
    <link rel="stylesheet" href="/css/flashignite_dropdowns.css">
    <link rel="stylesheet" href="/css/flashignite_lightbox.css">
    <link rel="stylesheet" href="/css/tooltipster.css">
    <link rel="stylesheet" href="/js/icheck/orange.css">
    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.css">
    @yield('css_addition')
    
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.min.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->

    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
    <script src="/js/jquery.flashignite_dropdown.js"></script>
    <script src="/js/flashignite_lightbox.js"></script>
    <script src="/js/icheck/icheck.min.js"></script>
    <script src="/js/jquery.tooltipster.min.js"></script>
    <script src="/js/team_search_dropdowns.js"></script>
    <script src="/js/tabs.js"></script>
    <script src="/js/teamranked.js"></script>
    <script src="/js/jquery.mCustomScrollbar.js"></script>

    @if(Auth::check())
        <!-- FI-Network Server -->
        <link rel="stylesheet" href="/css/chat.css">
        <script>
            //var fi_server_host      = "ws://{{ trim($_SERVER['SERVER_ADDR']) }}:8080/";
            var fi_server_host      = "ws://{{ Config::get('fi_server.host') }}:{{ Config::get('fi_server.port') }}/";
            var fi_server_lol_patch = "{{ Config::get('settings.patch') }}";
            var fi_server_login     = '{{ FIServer::get_auth_login_code() }}';
        </script>
        <script src="/js/fi_network_server.js?new_file_0955"></script>
        <script>
            fi_server_init();

            $(document).ready(function(){
                function loadScrollBars(){
                   $(".scroll_bar").mCustomScrollbar({
                      theme:"minimal-dark",
                      scrollInertia:600,
                      autoDraggerLength:false,
                      mouseWheel:{ scrollAmount: 140 }
                   });
                }
                loadScrollBars();
            });
        </script>
    @endif

</head>

<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

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

<div class="layer" id="mobile_detecter_element"></div>
<!-- Mobile menu overlay mask (is invisible)-->

<!-- Header================================================== -->
<header class="page_navigation">
    @include('network_navi')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div id="logo">
                    <a href="/"><img src="/img/teamranked_white.png" width="220" alt="Teamranked.com" data-retina="true" class="logo_normal"></a>
                    <a href="/"><img src="/img/teamranked_black.png" width="220" alt="Teamranked.com" data-retina="true" class="logo_sticky"></a>
                </div>
            </div>
            <nav class="col-md-9 col-sm-9 col-xs-9">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" id="mobile_navigation_btn_switcher" href="javascript:void(0);"><span>Menu mobile</span></a>
                <div class="main-menu" id="page_main_menu">
                    @include('layouts.navigation')
                </div><!-- End main-menu -->
                <ul id="top_tools" style="display: none;">
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
<div id="page_container">
   @yield('header')
   <div class="page_content_container" id="page_content_container">@yield('content')</div>
   <footer id="page_footer">
       <div class="container">
           <div class="row">
               <div class="col-md-12">
                   <div id="social_footer">
                       <ul>
                           <li><a href="http://facebook.com/teamranked" target="blank"><i class="icon-facebook"></i></a></li>
                           <li><a href="http://twitter.com/teamranked"><i class="icon-twitter"></i></a></li>
                       </ul>
                       <p><a href="/legal">Privacy Policy</a> | <a href="/tos">Terms of Service</a> | © Teamranked.com &amp; Flashignite.com 2015</p>
                   </div>
               </div>
           </div><!-- End row -->
       </div><!-- End container -->
   </footer><!-- End footer -->
</div>
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
        var login_box        = $("#nw_login_box");
        var chats_box        = $("#nw_chats_box");
        var notification_box = $("#nw_notifications_box");
        scrollNavigation();

        $(".nw_box_btn").click(function(){
            type        = $(this).attr("data-box");
            current_box = false;
            if(type == "login_box"){
                current_box = login_box;
            } else if(type == "chats_box"){
                current_box = chats_box;
            } else if(type == "notification_box"){
                current_box = notification_box;
            }
            
            if(current_box){
                current_box.attr("style", "");
                $(".nw_login_box.open").removeClass("open");
                $(".nw_box_btn.active").removeClass("active");
                
                if(parseInt($(window).width()) > 750){ // Anpassungen für Desktop Version
                    arrow_pos = Math.round($(this).outerWidth() / 2) - 11; // -11 = Hälfte der Breite des Pfeils
                    current_box.css("background-position", "top right "+parseInt(arrow_pos)+"px");
                    
                    pos = $(this).offset();
                    pos = $(document).width() - parseInt(pos["left"]);
                    pos = pos - $(this).outerWidth(true);
                    current_box.css("right", pos);
                } else { // Anpassungen für Mobile-Version
                    current_box.css("width", "90%");
                    current_box.css("left", "5%");

                    arrow_pos = $(this).find("i").offset();
                    console.log($(this).get());
                    console.log(arrow_pos);
                    arrow_pos = parseInt(arrow_pos["left"]) - (parseInt($(this).find("i").outerWidth())) - 5;
                    current_box.css("background-position", "top left "+parseInt(arrow_pos)+"px");
                }

                if(current_box.hasClass("open")){
                    current_box.removeClass("open");
                    $(this).removeClass("active");
                } else {
                    $(this).addClass("active");
                    current_box.addClass("open");
                }
            }
        });

        $("#page_container").click(function(){
            $(".nw_login_box.open").removeClass("open");
            $(".nw_box_btn.active").removeClass("active");
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-orange',
            radioClass: 'iradio_flat-orange'
        });
        
        // Tooltips
        $('.tooltips').tooltipster();

        $("#mobile_navigation_btn_switcher").click(function(){
            if($("#mobile_detecter_element").hasClass("layer-is-visible")){
                // Nichts machen
            } else {
                setTimeout(function(){
                    $("#mobile_navigation_btn_switcher").removeClass("active");
                }, 100);
            }
        });

        // Footer nach unten verschieben wenn Seite nicht hoch genug ist
        if($(window).height() > $("body").height()){
            diff = parseInt($(window).height()) - parseInt($("body").outerHeight());
            $("#page_content_container").css("min-height", diff + parseInt($("#page_content_container").outerHeight()) + "px");
            $(document).trigger("footer_resize");
        }
    });
</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-51337940-5', 'auto');
    ga('send', 'pageview');

</script>
<!-- Common scripts -->
<script src="/js/common_scripts_min.js"></script>
<script src="/js/functions.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script src="/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="/js/revolution_func.js"></script>


</body>

</html>