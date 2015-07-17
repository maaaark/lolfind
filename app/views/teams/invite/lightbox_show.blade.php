<h3 id="lightbox_invite_head_title">Invitation of {{ $ranked_team->name }}</h3>

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <h4 style="text-align: center;">Ranked 5 vs. 5</h4>
                @if($ranked_team->ranked_league_5 AND trim($ranked_team->ranked_league_5) != "" AND trim($ranked_team->ranked_league_5) != "none")
                    <?php
                        $league_logo = "0_5";
                        if(strpos($ranked_team->ranked_league_5, "_") > 0){
                            $division = substr($ranked_team->ranked_league_5, strpos($ranked_team->ranked_league_5, "_") + 1);
                            if($division == "I"){ $division = "1"; }
                            else if($division == "II"){ $division = "2"; }
                            else if($division == "III"){ $division = "3"; }
                            else if($division == "IV"){ $division = "4"; }
                            else { $division = "5"; }
                            $league_logo = trim(substr($ranked_team->ranked_league_5, 0, strpos($ranked_team->ranked_league_5, "_")))."_".trim($division);
                        }
                    ?>
                    <center><img src="/img/leagues/{{ trim($league_logo) }}.png"></center>
                    <div class="team_current_league_text"  style="text-align: center;font-weight: bold;">
                        {{ ucfirst(trim(substr($ranked_team->ranked_league_5, 0, strpos($ranked_team->ranked_league_5, "_")))) }} {{ $division }}

                        <div class="prediction" style="text-align: center;font-weight: normal;">
                            <div>Wins: <span class="wins">{{ $ranked_team->ranked_league_5_wins }}</span></div>
                            <div>Losses: <span class="wins">{{ $ranked_team->ranked_league_5_losses }}</span></div>
                            <div>League Points: <span class="wins">{{ $ranked_team->ranked_league_5_league_points }}</span></div>
                        </div>
                    </div>
                @else
                    <center><img src="/img/leagues/0_5.png"></center>
                    <div class="team_current_league_text" style="text-align: center;font-weight: bold;">
                        Unranked

                        <div class="prediction" style="text-align: center;font-weight: normal;">
                            Placement prediction: <span>{{ ucfirst($ranked_team->league_prediction) }}</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h4 style="text-align: center;">Ranked 3 vs. 3</h4>
                @if($ranked_team->ranked_league_3 AND trim($ranked_team->ranked_league_3) != "" AND trim($ranked_team->ranked_league_3) != "none")
                    <?php
                        $league_logo = "0_5";
                        if(strpos($ranked_team->ranked_league_3, "_") > 0){
                            $division = substr($ranked_team->ranked_league_3, strpos($ranked_team->ranked_league_3, "_") + 1);
                            if($division == "I"){ $division = "1"; }
                            else if($division == "II"){ $division = "2"; }
                            else if($division == "III"){ $division = "3"; }
                            else if($division == "IV"){ $division = "4"; }
                            else { $division = "5"; }
                            $league_logo = trim(substr($ranked_team->ranked_league_3, 0, strpos($ranked_team->ranked_league_3, "_")))."_".trim($division);
                        }
                    ?>
                    <center><img src="/img/leagues/{{ trim($league_logo) }}.png"></center>
                    <div class="team_current_league_text" style="text-align: center;font-weight: bold;">
                        {{ ucfirst(trim(substr($ranked_team->ranked_league_3, 0, strpos($ranked_team->ranked_league_3, "_")))) }} {{ $division }}

                        <div class="prediction" style="text-align: center;font-weight: normal;">
                            <div>Wins: <span class="wins">{{ $ranked_team->ranked_league_3_wins }}</span></div>
                            <div>Losses: <span class="wins">{{ $ranked_team->ranked_league_3_losses }}</span></div>
                            <div>League Points: <span class="wins">{{ $ranked_team->ranked_league_3_league_points }}</span></div>
                        </div>
                    </div>
                @else
                    <center><img src="/img/leagues/0_5.png"></center>
                    <div class="team_current_league_text" style="text-align: center;font-weight: bold;">
                        Unranked

                        <div class="prediction" style="text-align: center;font-weight: normal;">
                            Placement prediction: <span>{{ ucfirst($ranked_team->league_prediction) }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <h4>Team information</h4>
        <table class="table">
            <tr>
                <td>Members:</td>
                <td>{{ $ranked_team->player()->count() }} members</td>
            </tr>
            <tr>
                <td>Leader:</td>
                <td><a href="/summoner/{{ $leader->summoner->region }}/{{ $leader->summoner->name }}">{{ $leader->summoner->name }}</a></td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}">
                        <div class="btn_1" style="width: 100%;text-align: center;">More information</div>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    
</div>
<div class="row" style="margin-top: 25px;">
    <div class="col-md-8">
        <h4>Comment</h4>
        @if(isset($invitation->comment) AND trim($invitation->comment) != "")
            {{ trim(nl2br($invitation->comment)) }}
        @else
            No description.
        @endif
    </div>
    
    <div class="col-md-4">
        <h4>Invitation for roles:</h4>
        <div id="invitation_role_holder"></div>
        
        <script>
            role_json = JSON.parse('{{ $invitation->roles }}');
            console.log(role_json);
            if(typeof role_json != "undefined" && role_json && role_json.length > 0){
                for(i = 0; i < role_json.length; i++){
                    html  = '<div style="padding-bottom: 5px;">';
                    
                    image = "tank";
                    role  = "Top";
                    if(role_json[i] == "mid"){
                        role = "Mid";
                        image = "mage";
                    } else if(role_json[i] == "jungle"){
                        role = "Jungle";
                        image = "fighter";
                    } else if(role_json[i] == "support"){
                        role = "Support";
                        image = "support";
                    } else if(role_json[i] == "adc"){
                        role = "ADC";
                        image = "marksman";
                    }
                    
                    html += '<img src="/img/roles/'+image+'.jpg" style="height: 23px;border-radius: 50%;margin-right: 10px;">';
                    html += role;
                    html += '</div>';
                    $("#invitation_role_holder").append(html);
                }
            } else {
                $("#invitation_role_holder").html("No specific role selected.");
            }
        </script>
    </div>
</div>

<div style="margin-top: 25px;text-align: right;">
    <a href="alert('Funktion noch nicht eingebaut.');">Delete invitation</a>
    <button class="btn_1"
            onclick="fi_server_open_chat({{ $leader->id }}, '{{ $leader->summoner->name }}', '{{ $leader->summoner->profileIconId }}');hideLightbox();"
            style="margin-left: 15px;">
        Open Chat with team-leader
    </button>
</div>