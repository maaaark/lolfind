@extends('design')
@section('title', "Startseite")
@section('css_addition')
	<link rel="stylesheet" type="text/css" href="/css/index.css">
@stop
@section('header')
    <!-- Slider -->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Intro Slide">
                    <!-- MAIN IMAGE -->
                    <img src="img/cover.jpg" alt="slidebg1" data-lazyload="img/cover.jpg" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption white_heavy_40 customin customout text-center text-uppercase text-shadow" data-x="center" data-y="center" data-hoffset="0" data-voffset="-20" data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;" data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="1000" data-start="1700" data-easing="Back.easeInOut" data-endspeed="300" style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">League is more fun with friends!
                    </div>
                    <!-- LAYER NR. 2 -->
                    <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0 text-center" data-x="center" data-y="center" data-hoffset="0" data-voffset="15" data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="500" data-start="2600" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.05" data-endelementdelay="0.1" style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div style="color:#ffffff; font-size:16px; text-transform:uppercase" class="text-shadow">
                            Find new players or teams matching your skills</div>
                    </div>
                    <!-- LAYER NR. 3 -->
                    <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0" data-x="center" data-y="center" data-hoffset="0" data-voffset="70" data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="500" data-start="2900" data-easing="Power3.easeInOut" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-linktoslide="next" style="z-index: 12;"><a href='/players' class="button_intro text-shadow">Find player</a> <a href='/teams' class="text-shadow button_intro outline">Find teams</a>
                    </div>
                </li>
            </ul>
            <div class="tp-bannertimer tp-bottom"></div>
        </div>
    </div>
    <!-- End Slider -->
@stop
@section('content')
    <div class="container margin_30">
    <div class="row">

        <div class="col-md-4 wow zoomIn" data-wow-delay="0.2s">
            <div class="feature_home">
                <h3><span>120+</span> Teams looking for player</h3>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
                </p>
                <a href="/teams" class="btn_1 outline">Search your team</a>
            </div>
        </div>

        <div class="col-md-4 wow zoomIn" data-wow-delay="0.4s">
            <div class="feature_home">
                <h3><span>1000+</span> Players searching</h3>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
                </p>
                <a href="/players" class="btn_1 outline">Find a new player</a>
            </div>
        </div>

        <div class="col-md-4 wow zoomIn" data-wow-delay="0.6s">
            <div class="feature_home">
                <h3><span>Join</span> the community</h3>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
                </p>
                <a href="#" class="btn_1 outline">Register for free</a>
            </div>
        </div>

    </div><!--End row -->

    <hr>

    <div class="row" style="background: url('img/network.png');">
        <div class="col-md-2 col-sm-2 hidden-xs">
            <img src="img/fi_logo.png" height="250" alt="Laptop" class="">
        </div>
        <div class="col-md-10 col-sm-10">
            <h3>Register your <span>free account</span> now</h3>
            <p>
                Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
            </p>
            <ul class="list_order">
                <li><span>1</span>Insert your summoner name</li>
                <li><span>2</span>Verify your name</li>
                <li><span>3</span>Search for teams and player</li>
            </ul>
            <a href="#" class="btn_1">Register now</a>
            <br/><br/>
        </div>
    </div><!-- End row -->
</div>
@stop