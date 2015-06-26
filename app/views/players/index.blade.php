@extends('design_left_sidebar')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="img/team_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
                <h1>Find a new player</h1>
                <p class="text-shadow">Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
            </div>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Teamranked.com</a></li>
                <li><a href="/players">Find a player</a></li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('sidebar')
    @include('players.filter_sidebar')
@stop
@section('content_page')

    <div class="content">

        <div>
            <h2>{{ Lang::get("players.search.player_suggestions") }}</h2>
            @if(isset($player_list))
                @include("players.suggestion_list", array("player_list" => $player_list))
            @else
                <div style="color: rgba(0,0,0,0.6);text-align: center;padding: 35px;">{{ Lang::get("player.search.need_update_list") }}</div>
            @endif
        </div>

        <hr>

        <div class="text-center">
            {{ $player_list->links() }}
        </div><!-- end pagination-->
    </div>

    <script>
        // Update List
        can_update = true;
        function update_player_list_suggestions(){
            $("#player_list_update_btn").prop("disabled", false);

            $.post('/players/player_list_suggestions', {
                region: $('#region_sel input').val(),
                league: $('#leagues_sel input').val(),
                main_lang: $('#prime_lang_sel input').val(),
                sec_lang: $('#sec_lang_sel input').val(),
                prime_role: $('#prime_role_sel input').val(),
                sec_role: $('#sec_role_sel input').val(),
                unranked_search: $('#search_unranked').prop('checked')
            }).done(function(data){
                $("#player_list_update_btn").prop("disabled", false);
                can_update = true;
                $("#player_list_suggestions").html(data);
            });
        }

        $("#player_list_update_btn").click(function(){
            if(can_update){
                can_update = false;
                update_player_list_suggestions();
            }
        });
    </script>

@stop