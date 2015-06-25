@if(isset($count) AND $count == 0)
	<script>
	$("#summoner_header_bg").attr("style", "background-image:url({{ asset('img/stats/champion_header/'.$champion["key"].'_summoner_bg.jpg') }});");
	</script>
@endif

<div class="matchhistory_element" data-gameid="{{ $game["gameId"] }}">
	<div class="match_title" style="@if($game['stats']['win'] == true) background-color:rgba(16, 81, 20, 0.8) @else background-color:rgba(81, 16, 16, 0.8)  @endif">
		{{ Helpers::niceGameMode($game["gameMode"]) }} - {{ Helpers::niceMatchMode($game["gameType"]) }} - {{ Helpers::niceSubType($game["subType"]) }}
	</div>
	<div class="background_image">
		<div class="bg">
			<table class="matchhistory_table table">
				<tr>
					<td class="champion">
						<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $champion["key"] }}.png" class="img-circle">
						<div style="text-align:center;">{{ $champion["name"] }}</div>
					</td>
					<td class="stats">
						<div>@if(isset($game["stats"]["championsKilled"])){{ $game["stats"]["championsKilled"] }} @else 0 @endif <span>Kills</span></div>
						<div>@if(isset($game["stats"]["numDeaths"])){{ $game["stats"]["numDeaths"] }} @else 0 @endif <span>Deaths</span></div>
						<div>@if(isset($game["stats"]["assists"])){{ $game["stats"]["assists"] }} @else 0 @endif <span>Assists</span></div>
					</td>
					<td class="items">
						@for($i = 0; $i < 6; $i++)
							<?php $item = $game["items"][$i]; ?>

							@if($i == 3) <div class="item_breaker show_mobile_mini"></div> @endif

							@if(isset($item["name"]) AND isset($item["item_id"]) AND $item["item_id"] > 0)
							 	<div class="item" style="background-image:url(http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/item/{{ $item->item_id }}.png);"></div>
							@else
							<div class="no_item"></div>
							@endif
						@endfor
					</td>
					<td class="spells">
						<div class="spell" style="background-image:url(http://flashignite.com/img/spells/{{ $game["spell1"] }}.png);"></div>
					</td>
					<td class="spells">
						<div class="spell" style="background-image:url(http://flashignite.com/img/spells/{{ $game["spell2"] }}.png);"></div>
					</td>
					<td class="farm no_mobile">
						<div>
							<span class="val">@if($game["stats"]["minionsKilled"]){{ number_format($game["stats"]["minionsKilled"], 0, ",", ".") }} @else 0 @endif</span>
							<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/ui/minion.png" alt="Lasthits" title="Lasthits">
						</div>
						<div>
							<span class="val">@if($game["stats"]["goldEarned"]){{ number_format($game["stats"]["goldEarned"], 0, ",", ".") }} @else 0 @endif</span>
							<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/ui/gold.png" alt="Gold" name="Gold">
						</div>
					</td>
				</tr>
			</table>
			<div class="more_details" data-id="{{ $game["gameId"] }}">
	            Show more details
	         </div>
		</div>
	</div>
	<div class="more_details_holder" id="more_details_{{ $game["gameId"] }}">
      	<div class="row">
			<div class="team team1 no_mobile_mini col-md-6">
				<div class="team_title team1">Team 1</div>
				<div class="team_bg">
					@if($game["teamId"]==100)
						<div class="player col-md-6">
							<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $champion["key"] }}.png" class="img-circle">
							<div class="player_name" style="color: #000;"><b>{{ $summoner->name }}</b></div>
						</div>
					@endif
					@foreach($team1 as $player)
						<div class="player col-md-6">
							<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $player["champion"]["key"] }}.png" class="img-circle">
							<div class="player_name">{{ $player["name"] }}</div>
						</div>
					@endforeach
					<div style="clear: both;"></div>
				</div>
			</div>
			<div class="team team2 no_mobile_mini col-md-6">
				<div class="team_title team2">Team 2</div>
				<div class="team_bg">
					@if($game["teamId"]==200)
						<div class="player col-md-6">
							<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $champion["key"] }}.png" class="img-circle">
							<div class="player_name" style="color: #000;"><b>{{ $summoner->name }}</b></div>
						</div>
					@endif
					@foreach($team2 as $player)
						<div class="player col-md-6">
							<img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $player["champion"]["key"] }}.png" class="img-circle">
							<div class="player_name">{{ $player["name"] }}</div>
						</div>
					@endforeach
					<div style="clear: both;"></div>
				</div>
			</div>
		</div>

      <table class="table matchhistory_table_detail">
         <tr>
         	<td>Jungle-Monster killed</td>
         	<td class="val">@if(isset($game["stats"]["neutralMinionsKilledYourJungle"])) {{ number_format($game["stats"]["neutralMinionsKilledYourJungle"], 0, ",", ".") }}@else 0 @endif</td>
     	</tr>
         <tr>
         	<td>Enemy Jungle-Monster killed</td>
         	<td class="val">@if(isset($game["stats"]["neutralMinionsKilledEnemyJungle"])) {{ number_format($game["stats"]["neutralMinionsKilledEnemyJungle"], 0, ",", ".") }}@else 0 @endif</td>
     	</tr>
         <tr>
         	<td>Total damage done</td>
     		<td class="val">@if(isset($game["stats"]["totalDamageDealt"])) {{ number_format($game["stats"]["totalDamageDealt"], 0, ",", ".") }}@else 0 @endif</td>
 		</tr>
         <tr>
         	<td>Total damage done to champions</td>
         	<td class="val">@if(isset($game["stats"]["totalDamageDealtToChampions"])) {{ number_format($game["stats"]["totalDamageDealtToChampions"], 0, ",", ".") }}@else 0 @endif</td>
     	</tr>
         <tr>
         	<td>Total damage taken</td>
         	<td class="val">@if(isset($game["stats"]["totalDamageTaken"])) {{ number_format($game["stats"]["totalDamageTaken"], 0, ",", ".") }}@else 0 @endif</td>
     	</tr>
         <tr>
         	<td>Destroyed turrets</td>
     		<td class="val">@if(isset($game["stats"]["turretsKilled"])) {{ number_format($game["stats"]["turretsKilled"], 0, ",", ".") }}@else 0 @endif</td>
		</tr>
         <tr>
         	<td>Destroyed inhibitors</td>
         	<td class="val">@if(isset($game["stats"]["barracksKilled"])) {{ number_format($game["stats"]["barracksKilled"]) }}@else 0 @endif</td>
     	</tr>
        <tr>
            <td>Collected gold</td>
            <td class="val">@if(isset($game["stats"]["goldEarned"])) {{ number_format($game["stats"]["goldEarned"], 0, ",", ".") }}@else 0 @endif</td>
        </tr>
        <tr>
            <td>Gold selled</td>
            <td class="val">@if(isset($game["stats"]["goldSpent"])) {{ number_format($game["stats"]["goldSpent"], 0, ",", ".") }}@else 0 @endif</td>
        </tr>
        <tr>
            <td>Wards placed</td>
            <td class="val">@if(isset($game["stats"]["wardPlaced"])) {{ number_format($game["stats"]["wardPlaced"], 0, ",", ".") }}@else 0 @endif</td>
        </tr>
      </table>

   </div>
</div>
