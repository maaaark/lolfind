<style>
	.team_header {
		height: 300px;
		position: relative;
	}

	.team_header .team_icon {
		width: 130px;
		height: 130px;
		background: rgba(255,255,255,0.2);
		border: 2px solid #fff;
		border-radius: 5px;
		position: absolute;
		bottom: 0px;
		margin-left: 35px;
	}

	.team_header .team_title {
		position: absolute;
		color: #fff;
		font-size: 36px;
		font-weight: bold;
		bottom: 70px;
	}

	.team_header .team_title .small_team_info {
		color: rgba(255,255,255,0.7);
		font-size: 14px;
		margin-top: 10px;
		text-align: left;
	}

	.team_header .team_navigation {
		position: absolute;
		bottom: 3px;
		height: 35px;
		font-size: 12px;
	}

	.team_header .team_title .team_navigation:after {
		display: block;
		content: '';
		clear: both;
	}
	
	.team_header .team_navigation .team_navi_el {
		float: left;
		color: rgba(0,0,0,0.5);
		background: rgba(255,255,255,0.1);
		border: 3px solid rgba(255,255,255,1);
		border-radius: 3px;
		padding: 7px;
		padding-left: 25px;
		padding-right: 25px;
		margin-right: 10px;
		cursor: pointer;
		color: #fff;
		font-weight: bold;
		font-size: 14px;
		transition: all 300ms;
	}

	.team_header .team_navigation .team_navi_el:hover {
		background: rgba(255,255,255,1);
		color: #000;
	}

	.team_header .team_navigation .team_navi_el.active {
		border: 3px solid orange;
		background: rgba(255,255,255,0.3);
		color: #fff;
		cursor: default;
	}

	.team_updater_progress {
		position: absolute;
		right: 0px;
		bottom: 2px;
		display: none;
		color: #fff;
		font-weight: bold;
	}

	.team_updater_progress .progress_animation {
		height: 35px;
	}
	</style>
    <div class="content" style="max-width: 1170px;width: 100%;margin: auto;">
    	<div class="team_header">
    		<div class="team_updater_progress text-shadow" id="team_updater_progress">
    			<img src="/img/ajax-loader.gif" class="progress_animation">
    			We refresh the team data ...
    		</div>
        	<div class="team_title text-shadow">
        		{{ $ranked_team->name }}
        		@if($ranked_team->looking_for_players == 1)
	                @if(($check = RankedTeam::loggedCanApplyToTeam($ranked_team->id)))
	                    @if($check == "can_apply")
	                       <button class="button_intro outline apply_team_btn" style="float: right;margin-left: 15px;margin-top: -5px;">Apply the team</button>
	                    @elseif($check == "already_applied")
	                       <button class="btn_1 apply_team_btn" style="float: right;margin-left: 15px;margin-top: -5px;" disabled>Already applied</button>
	                    @endif
	                @endif
                @endif
        		<div class="small_team_info">{{ trim(strtoupper($ranked_team->region)) }} | {{ trim(strtoupper($ranked_team->tag)) }}</div>
    		</div>

    		<div class="team_navigation">
    			<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/">
    				<div class="team_navi_el" id="team_navi_link_main">{{ Lang::get("teams.navi.main") }}</div>
				</a>

    			@if(Auth::check())
    				@if(Auth::user()->summoner->summoner_id == $ranked_team->leader_summoner_id)
    					<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/settings">
    						<div class="team_navi_el" id="team_navi_link_settings">{{ Lang::get("teams.navi.settings") }}</div>
						</a>
    				@endif
    			@endif

    			@if(TeamPremiumCheck::hasPremium($ranked_team) AND Auth::check() AND TeamPremiumCheck::user_is_in_team(Auth::user()->id, $ranked_team))
    				@if(TeamPremiumCheck::can_change_config_rights(Auth::user()->id, $ranked_team))
    					<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/settings/config-rights">
    						<div class="team_navi_el" id="team_navi_link_premium_config">Customize permissions</div>
						</a>
    				@endif
    			@endif
    		</div>
        </div>
    </div>
    
    @if(Auth::check())
        @if(RankedTeam::loggedCanApplyToTeam($ranked_team->id))
            <script>
            $(document).ready(function(){
                $(".apply_team_btn").click(function(){
                	refresh_after_finish_team_update = false;
                    html  = "<div style='text-align: center;padding: 40px;'><img src='/img/ajax-loader.gif' style='height: 50px;'>";
                    html += "<div style='padding-top: 10px;'>Content is loading ...</div>";
                    html += '</div>';
                    showLightbox(html, function(lightbox_content){
                        $.post("/teams/apply/start", {"team": {{ $ranked_team->id }} }).done(function(data){
                            lightbox_content.html(data);
                        });
                    });
                });
                
                if(typeof window.location.hash != "undefined" && window.location.hash == "#open_apply"){
                    $(".apply_team_btn").click();
                    window.location.hash = '';
                }
            });
            </script>
        @endif
    @endif