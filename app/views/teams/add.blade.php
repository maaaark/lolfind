@extends('design')
@section('title', Lang::get("teams.add.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
                <h1>Add a new team</h1>
                <p>Select your team and click the continue button.</p>
            </div>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/teams">Teams</a></li>
                <li>Add a team</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
   <div class="container margin_30">
   <div class="content">
      <h1>{{ Lang::get("teams.add.site_title") }}</h1>
      <div class="team_add_description">
         {{ Lang::get("teams.add.add_description") }}
      </div>
      
      @if(Auth::check())
         <div class="row">
            <div class="col-md-4">
               <div class="team_add_box">
                  <div class="team_add_title">Select a team</div>
                  <div class="team_add_content" id="team_list_holder">
                     <div style="padding: 20px;text-align: center;color: rgba(0,0,0,0.6);">
                        <img src="/img/ajax-loader.gif" style="height: 80px;">
                        <div style="padding-top: 10px;">
                           {{ Lang::get("teams.add.team_list_loading") }}
                        </div>
                     </div>
                  </div>
                  </div>
            </div>
            <div class="col-md-8">
               <div class="team_add_box">
                  <div class="team_add_title">Add your team</div>
                  <div>
                      <div id="team_list_continue_loading"></div>
                      <div class="team_add_content" id="team_list_continue">
                         <div style="color: rgba(0,0,0,0.4);">
                            {{ Lang::get("teams.add.wait_for_team_sel") }}
                         </div>
                      </div>
                      <div class="team_add_continue_flat">
                         <span id="team_add_status"></span>
                         <button id="team_add_btn" class="small" disabled>{{ Lang::get("main.continue") }}</button>
                      </div>
                  </div>
               </div>
            </div>
         </div>
         
         <script>
            var ranked_team_data = false;
            $.post("/teams/add/rankedTeams", {"post": "true"}).done(function(data){
                if(typeof data == "undefined" || data == "error"){
                    alert("Unknown error :( Try again later please.");
                } else if(data == "no_ranked_teams_found"){
                    $("#team_list_holder").html('{{ Lang::get("team.add.no_ranked_teams_found") }}');
                } else {
                    html = '';
                    json = JSON.parse(data);
                    $.each(json, function(team_temp_id, team){
                        if(typeof team["name"] != "undefined" && typeof team["id"] != "undefined" && team["name"].trim() != ""){
                            class_add = '';
                            if(typeof team["is_lead"] != "undefined" && team["is_lead"] == true){
                                class_add = ' is_lead';
                            }
                            html += '<div class="team_list_el'+class_add+'" data-teamId="'+team["id"]+'">';
                            html += '<span class="tag">'+team["tag"]+'</span><span class="name">'+team["name"]+'</span>';
                            html += '</div>';
                        }
                    });
                    ranked_team_data = json;
                    
                    if(html.trim() == ''){
                        $("#team_list_holder").html('{{ Lang::get("team.add.no_ranked_teams_found") }}');
                    } else {
                        $("#team_list_holder").html(html);
                    }
                }
                
                var click_temp_bug = false;
                $("#team_list_holder .team_list_el.is_lead").click(function(){
                    click_temp_bug = false;
                    $("#team_add_status").html('');
                    $("#team_add_btn").prop("disabled", false);
                    $("#team_list_holder .active").removeClass("active");
                    $(this).addClass("active");
                    
                    team_id = $(this).attr("data-teamId");
                    if(ranked_team_data && typeof ranked_team_data[team_id] != "undefined"){
                        team = ranked_team_data[team_id];
                        html = '<div style="float: right;color: rgba(0,0,0,0.2);font-size: 22px;">'+team["tag"]+'</div>';
                        html += '<h3 style="margin-top: 0px;">'+team["name"]+"</h3>";
                        html += '<div class="row">';
                        html += '<div class="col-md-6">';
                        html += '<div style="font-weight: bold;">Ranked 5 vs 5</div>';
                        html += '<div><div class="wins">'+team["ranked_5"]["wins"]+' {{ Lang::get("main.wins") }}</div> <div class="losses">'+team["ranked_5"]["losses"]+' {{ Lang::get("main.losses") }}</div></div>';
                        html += '</div>';
                        
                        html += '<div class="col-md-6">';
                        html += '<div style="font-weight: bold;">Ranked 3 vs 3</div>';
                        html += '<div><div class="wins">'+team["ranked_3"]["wins"]+' {{ Lang::get("main.wins") }}</div> <div class="losses">'+team["ranked_3"]["losses"]+' {{ Lang::get("main.losses") }}</div></div>';
                        html += '</div>';
                        
                        $("#team_list_continue").html(html);
                        
                        $("#team_add_btn").click(function(){
                            if(click_temp_bug == false){
                                click_temp_bug  = true;
                                loading_container = $("#team_list_continue_loading");
                                loading_screen  = '<div id="team_add_loading_screen" style="background: rgba(255,255,255,0.8);color: #000;padding: 35px;box-sizing: border-box;text-align: center;position: absolute;z-index: 10;width: '+loading_container.parent().width()+'px;height: '+loading_container.parent().height()+'px;">';
                                loading_screen += '<div><img src="/img/ajax-loader.gif" style="height: 40px;"></div>';
                                loading_screen += '<div style="margin-top: 8px;color: rgba(0,0,0,0.8);">{{ Lang::get("teams.add.loading_screen") }}</div>';
                                loading_screen += '</div>';
                                loading_container.prepend(loading_screen);
                                
                                $.post("/teams/add/post_action", {"ranked_team_id": team_id}).done(function(data){
                                    if(data.trim() == "error" || data.trim() == "already_added"){
                                        $("#team_add_btn").prop("disabled", true);
                                        
                                        if(data.trim() == "already_added"){
                                            $("#team_add_status").html("{{ Lang::get('teams.add.already_added_status') }}");
                                        } else {
                                            $("#team_add_status").html("{{ Lang::get('main.unknown_error') }}");
                                        }
                                        $("#team_add_loading_screen").remove();
                                    } else {
                                        json = JSON.parse(data);
                                        if(typeof json["status"] != "undefined" && typeof json["data"] != "undefined" && json["status"] == "success" && json["data"] > 0){
                                            self.location.href = '/teams/add/success/'+json["data"];
                                        } else {
                                            $("#team_add_btn").prop("disabled", true);
                                            $("#team_add_status").html("{{ Lang::get('main.unknown_error') }}");
                                            $("#team_add_loading_screen").remove();
                                        }
                                    }
                                });
                            }
                        });
                    } else {
                        $("#team_list_continue").html("{{ Lang::get('main.unknown_error') }}");
                    }
                });
            });
         </script>
      @else
         <div style="padding: 25px;">
            {{ Lang::get("teams.add.login_needed") }}
         </div>
      @endif
   </div>
   </div>
@stop