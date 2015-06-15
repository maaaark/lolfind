<style>
	.team_header {
		height: 300px;
		background: #000;
		position: relative;
	}

	.team_header .team_icon {
		width: 130px;
		height: 130px;
		background: rgba(255,255,255,0.2);
		border: 2px solid #fff;
		border-radius: 5px;
		position: absolute;
		bottom: 35px;
		margin-left: 35px;
	}

	.team_header .team_title {
		position: absolute;
		color: #fff;
		font-size: 30px;
		margin-left: 200px;
		bottom: 95px;
	}

	.team_header .team_title .short_info {
		color: rgba(255,255,255,0.5);
		font-size: 14px;
	}

	.team_header .team_navigation {
		position: absolute;
		bottom: 38px;
		height: 35px;
		margin-left: 200px;
	}

	.team_header .team_title .team_navigation:after {
		display: block;
		content: '';
		clear: both;
	}
	
	.team_header .team_navigation .team_navi_el {
		float: left;
		color: rgba(0,0,0,0.5);
		background: rgba(255,255,255,0.9);
		border: 2px solid rgba(0,0,0,0.1);
		padding: 7px;
		margin-right: 10px;
		cursor: pointer;
	}

	.team_header .team_navigation .team_navi_el:hover {
		border: 2px solid rgba(255,255,255,1);
		background: #fff;
	}

	.team_header .team_navigation .team_navi_el.active {
		border-bottom: 2px solid orange;
	}

	</style>
    <div class="content">
    	<div class="team_header">
    		<div class="team_icon"></div>
        	<div class="team_title">
        		{{ $ranked_team->name }}
        		<div class="short_info">{{ trim(strtoupper($ranked_team->region)) }} | {{ trim(strtoupper($ranked_team->tag)) }}</div>
    		</div>

    		<div class="team_navigation">
    			<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/">
    				<div class="team_navi_el" id="team_navi_link_main">{{ Lang::get("teams.navi.main") }}</div>
				</a>
    			<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/members">
    				<div class="team_navi_el" id="team_navi_link_members">{{ Lang::get("teams.navi.members") }}</div>
				</a>

    			@if(Auth::check())
    				@if(Auth::user()->summoner->summoner_id == $ranked_team->leader_summoner_id)
    					<a href="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/settings">
    						<div class="team_navi_el" id="team_navi_link_settings">{{ Lang::get("teams.navi.settings") }}</div>
						</a>
    				@endif
    			@endif
    		</div>
        </div>
    </div>