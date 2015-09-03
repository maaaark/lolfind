@extends('design')
@section('title', $ranked_team->name." - Settings - ")
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
   <link rel="stylesheet" href="/css/teams_premium.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            @include("teams.team_header")
            <script>$("#team_navi_link_calendar").addClass("active");</script>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Teamranked.com</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}">{{ $ranked_team->name }}</a></li>
                <li>Calendar</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
	<div class="container margin_30" style="width: 100%;max-width: 1400px;">
        <div style="background: #fff;width: 100%;max-width: 1400px;margin: auto;padding: 15px;">
            <div style="float: right;">
                <button class="btn_1" id="load_last_month_btn">Last month</button>
                <button class="btn_1" id="load_next_month_btn">Next month</button>
            </div>
            <h1>Calendar</h1>
            <div id="calendar_holder"></div>
        </div>
    </div>

    <script>
        var current_month = {{ date("m") }};
        var current_year  = {{ date("Y") }};

        function load_calendar_month(){
            $.get("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/ajax/"+current_month+"/"+current_year, {"post_data": "none"}).done(function(data){
                $("#calendar_holder").html(data);
                $("#calendar_holder .day").click(function(){
                    if(!$(this).hasClass("other_month")){
                        var date_clicked = $(this).attr("data-date");
                        showLightbox("<div style='padding: 25px;text-align: center;'>Loading ...</div>", function(lightbox_content){
                            $.get("/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/calendar/lightbox", {"date": date_clicked}).done(function(data){
                                lightbox_content.html(data);
                            });
                        });
                    }
                });
            });
        }
        load_calendar_month();

        $("#load_next_month_btn").click(function(){
            if(current_month > 11){
                current_month = 1;
                current_year++;
            } else {
                current_month++;
            }
            load_calendar_month();
        });

        $("#load_last_month_btn").click(function(){
            if(current_month < 2){
                current_month = 12;
                current_year--;
            } else {
                current_month--;
            }
            load_calendar_month();
        });
    </script>
@stop