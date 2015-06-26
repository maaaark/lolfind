@if($player_list)
    @foreach($player_list as $player)
        <div class="strip_all_tour_list player_searchbox wow fadeIn" data-wow-delay="0.1s">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="center">
                        <div style="text-align: center">
                            @if($player->solo_tier AND trim($player->solo_tier) != "" AND trim($player->solo_tier) != "none")
                                <?php
                                $pl_division = "1";
                                if($player->solo_division == "II"){ $pl_division = "2"; }
                                elseif($player->solo_division == "III"){ $pl_division = "3"; }
                                elseif($player->solo_division == "IV"){ $pl_division = "4"; }
                                elseif($player->solo_division == "V"){ $pl_division = "5"; }
                                ?>
                                <img style="margin-top: 20px;" src="/img/leagues/{{ trim(strtolower($player->solo_tier)) }}_{{ trim($pl_division) }}.png" class="tooltips" title="{{ trim(ucfirst(strtolower($player->solo_tier))) }} {{ trim($pl_division) }}">
                            @else
                                <img style="margin-top: 20px;" src="/img/leagues/0_5.png" class="tooltips" title="Unranked">
                            @endif
                            <br/><br/>
                            <div class="last_update">Last Update:<br/>{{ $player->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="">
                        @if(Auth::check())
                           <h3>
                              <strong>{{ $player->name }}</strong>
                              @if($player->looking_for_team == 1)
                                 @if(RankedTeam::loggedCanInvitePlayer($player))
                                    <a href="/summoner/{{ $player->region }}/{{ $player->name }}" class="btn_1 outline apply_team_btn" style="margin-left: 10px;">Invite in team</a>
                                 @endif
                              @endif
                           </h3>
                        @else
                            <h3><strong>Summoner</strong></h3>
                        @endif
                        <div class="row">
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Main Roles:</h5>
                                @if($player->search_top == 1)
                                    <img src="/img/roles/tank.jpg" class="img-circle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($player->search_jungle == 1)
                                    <img src="/img/roles/fighter.jpg" class="img-circle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($player->search_mid == 1)
                                    <img src="/img/roles/mage.jpg" class="img-circle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($player->search_adc == 1)
                                    <img src="/img/roles/marksman.jpg" class="img-circle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($player->search_support == 1)
                                    <img src="/img/roles/support.jpg" class="img-circle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif

                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Favorite Champions:</h5>
                                @if($player->fav_champion_1 != 0)
                                    <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/{{ $player->fav1->key }}.png" class="img-circle" width="35" />
                                @endif
                                @if($player->fav_champion_2 != 0)
                                    <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/{{ $player->fav2->key }}.png" class="img-circle" width="35" />
                                @endif
                                @if($player->fav_champion_3 != 0)
                                    <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/{{ $player->fav3->key }}.png" class="img-circle" width="35" />
                                @endif
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Languages:</h5>
                                <img src="http://teamranked.com/img/roles/marksman.jpg" class="img-circle" width="35" />
                            </div>
                        </div>
                            <br/>
                            <p>{{ Str::limit($player->description, 200) }} <a href="">more</a></p>
                    </div>
                </div>
            </div>
        </div><!--End strip -->
    @endforeach
@else
    No players found :(
@endif