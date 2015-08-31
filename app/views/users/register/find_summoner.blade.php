@extends('design', array('no_page_errors' => true))
@section('title', "New Account - Step 1 - ")
@section('content')
    <section id="hero" class="register">
        <div class="container margin_30 register">
            <div class="">
                @include('layouts.errors')
                <h2 class="headline">Problems finding your summoner?</h2>
                <div class="progress">
                    <div class="progress-bar orange" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                        Step 1 of 4
                    </div>
                </div>
                <br/>

                <table style="padding-top: 10px;width: 100%;">
                <tr>
                    <td>Summoner-Name</td>
                    <td style="width: 40%;"><input type="text" name="summoner_name" class="form-control" id="summoner_name_input"></td>
                    <td style="padding-left: 20px;">Region</td>
                    <td style="width: 30%;">
                        <select name="region" class="form-control" id="region_input">
                            <option value="euw">EU-West</option>
                            <option value="na">NA</option>
                            <option value="eune">EU-NE</option>
                            <option value="tr">TR</option>
                            <option value="lan">LAN</option>
                            <option value="las">LAS</option>
                            <option value="br">BR</option>
                            <option value="oce">OCE</option>
                        </select>
                    </td>
                </tr>
                </table>
                <div style="padding-top: 10px;text-align: center;">
                    <button class="btn_1" id="search_summoner_btn">Search summoner</button>
                </div>
                <div id="summoner_search_ajax_result"></div>
            </div>
        </div>
    </section>
    @include('users.register.register_resize_script')
    <script>
    var last_selected_region = "euw";
    $("#search_summoner_btn").click(function(){
        last_selected_region = $("#region_input").val();
        $.post("/register/find-summoner", {
            summoner_name: $("#summoner_name_input").val(),
            region: last_selected_region,
        }).done(function(data){
            html = "No summoners found :(";
            if(data.trim() != "error"){
                json = JSON.parse(data);
                console.log(json);
                if(typeof json != "undefined" && json && json.length > 0){
                    html  = '<table class="table" style="margin-top: 25px;">';
                    html += '<th></th><th>Name</th><th>Summoner-Level</th><th></th>';
                    for(i = 0; i < json.length; i++){
                        element = json[i];
                        if(typeof element["id"] != "undefined" && typeof element["name"] != "undefined"){
                            html += '<tr>';
                            html += '<td><img style="height: 35px;border-radius: 50%;" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get("settings.patch") }}/img/profileicon/'+element["profileIconId"]+'.png">';
                            html += '<td style="vertical-align: middle;">'+element["name"]+'</td>';
                            html += '<td style="vertical-align: middle;">'+element["summonerLevel"]+'</td>';
                            html += '<td style="width: 230px;"><a href="/register/find-summoner/'+element["id"]+'/'+last_selected_region+'" class="btn_1">Register this summoner</a></td>';
                            html += '</tr>';
                        }
                    }
                    html += '</table>';
                }
            }
            $("#summoner_search_ajax_result").html(html);
        });
    });
    </script>
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop