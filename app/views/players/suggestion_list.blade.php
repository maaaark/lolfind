@if($player_list AND $player_list->count() > 0)
    @foreach($player_list as $player)
        <div class="strip_all_tour_list player_searchbox wow fadeIn" data-wow-delay="0.1s">
            <div class="row small_version">
                <div class="col-xs-3" style="text-align: right;">
                     @if($player->solo_tier AND trim($player->solo_tier) != "" AND trim($player->solo_tier) != "none")
                        <?php
                        $pl_division = "1";
                        if($player->solo_division == "II"){ $pl_division = "2"; }
                        elseif($player->solo_division == "III"){ $pl_division = "3"; }
                        elseif($player->solo_division == "IV"){ $pl_division = "4"; }
                        elseif($player->solo_division == "V"){ $pl_division = "5"; }
                        ?>
                        <br/>
                        <img style="width: 100%;" src="/img/leagues/{{ trim(strtolower($player->solo_tier)) }}_{{ trim($pl_division) }}.png" class="tooltips" title="{{ trim(ucfirst(strtolower($player->solo_tier))) }} {{ trim($pl_division) }}">
                        <div style="padding-top: 15px;text-align: center;">{{ $player->solo_tier }} {{ $player->solo_division }}</div>
                    @else
                         <br/>
                        <img style="width: 100%;" src="/img/leagues/0_5.png" class="tooltips tooltipstered" title="Unranked">
                        <div style="padding-top: 15px;text-align: center;">Unranked</div>
                    @endif
                </div>

                <div class="col-xs-9" style="text-align: left;">
                    @if(Auth::check())
                        <h3><a href="/summoner/{{ trim($player->region) }}/{{ trim($player->name) }}"><strong>{{ $player->name }}</strong></a></h3>
                    @else
                        <div style="margin-top: 20px;margin-bottom: 10px;height: 22px;">
                            <a href="/login">Login to see detailled summoner information</a>
                        </div>
                    @endif

                    <table class="list_info_table">
                        <tr>
                            <td class="title">Roles:</td>
                            <td>
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
                            </td>
                        </tr>
                        @if($player->main_lang != "" || $player->sec_lang != "")
                        <tr>
                            <td class="title">Languages:</td>
                            <td>
                                @if($player->main_lang != "0" && $player->main_lang&& $player->main_lang != "none")
                                    <img src="/img/flags/{{ $player->main_lang }}.png" class="img-circle" width="35" />
                                @endif
                                @if($player->sec_lang && $player->sec_lang != "0"&& $player->sec_lang != "none")
                                    <img src="/img/flags/{{ $player->sec_lang }}.png" class="img-circle" width="35" />
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="title">Region:</td>
                            <td>
                                @if(Auth::check())
                                <span style="float: right;padding-right: 10px;"><a href="/summoner/{{ trim($player->region) }}/{{ trim($player->name) }}">more</a></span>
                                @endif
                                {{ strtoupper($player->region) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row desktop_version">
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
                                <br/>
                                <img src="/img/leagues/{{ trim(strtolower($player->solo_tier)) }}_{{ trim($pl_division) }}.png" class="tooltips" title="{{ trim(ucfirst(strtolower($player->solo_tier))) }} {{ trim($pl_division) }}">
                            @else
                                <br/>
                                <img src="/img/leagues/0_5.png" class="tooltips tooltipstered" title="Unranked">
                            @endif
                            <br/><br/>
                            <div class="last_update">Last Update:<br/>{{ $player->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-9 col-md-9 col-sm-9 no_small">
                    <div class="">
                        @if(Auth::check())
                            <h3><a href="/summoner/{{ trim($player->region) }}/{{ trim($player->name) }}"><strong>{{ $player->name }}</strong></a></h3>
                        @else
                            <div style="margin-top: 20px;margin-bottom: 10px;height: 22px;">
                                <a href="/login">Login to see detailled summoner information</a>
                            </div>
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
                                @if($player->main_lang != "" || $player->sec_lang != "")
                                <h5>Languages:</h5>
                                @endif
                                    @if($player->main_lang != "0" && $player->main_lang && $player->main_lang != "none")
                                        <img src="/img/flags/{{ $player->main_lang }}.png" class="img-circle" width="35" />
                                    @endif
                                    @if($player->sec_lang && $player->sec_lang != "0" && $player->sec_lang != "none")
                                        <img src="/img/flags/{{ $player->sec_lang }}.png" class="img-circle" width="35" />
                                    @endif
                                <br/>
                                    Region: {{ $player->region }}
                            </div>
                        </div>
                            <p>{{{ Str::limit($player->description, 200) }}} <a href="/summoner/{{ trim($player->region) }}/{{ trim($player->name) }}">more</a></p>
                    </div>
                </div>
            </div>
        </div><!--End strip -->
    @endforeach
@else
    <div style="text-align: center;margin-top: 25px;"><img src="/img/sad_amumu.png"></div>
    <div style="padding-top: 25px;font-size: 16px;text-align: center;">No players found matching the current filters :(</div>
@endif