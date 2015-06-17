@if(isset($ranked_teams) AND count($ranked_teams) > 0)
	@foreach($ranked_teams as $team)
		<div class="strip_all_tour_list player_searchbox wow fadeIn" data-wow-delay="0.1s">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">
                            +<span class="tooltip-content-flip"><span class="tooltip-back">Add to favorites</span></span>
                        </a>
                    </div>
                    <div class="center">
                        <div style="text-align: center">
                            @if(!isset($team->ranked_league_5))
                                <div class="ribbon unranked" ></div>
                            @endif
                            <a href="#"><img src="/img/leagues/{{ $team->ranked_league_5 }}.png" width="120" alt=""></a><br/>
                            {{ $team->ranked_league_5 }}<br/>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-10 col-md-10 col-sm-10">
                    <div class="">
                        <h3>
                            @if(Auth::check())
                                <strong>{{ $team->name }}</strong>
                            @else
                                <strong>Teamname</strong>
                            @endif
                        </h3>
                        @if(Auth::check())
                            @if($team->description != "")
                                <p>{{ $team->description }} <a href="">more</a></p>
                            @else
                                <p>No description</p>
                            @endif
                        @else
                            <p>Login to see more details.</p>
                        @endif

                        <div class="row">
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Open Roles:</h5>
                                @if($team->looking_for_top == 1)
                                    <img src="/img/roles/tank.jpg" class="img-circle" width="35" />
                                @endif
                                @if($team->looking_for_jungle == 1)
                                    <img src="/img/roles/fighter.jpg" class="img-circle" width="35" />
                                @endif
                                @if($team->looking_for_mid == 1)
                                    <img src="/img/roles/mage.jpg" class="img-circle" width="35" />
                                @endif
                                @if($team->looking_for_adc == 1)
                                    <img src="/img/roles/marksman.jpg" class="img-circle" width="35" />
                                @endif
                                @if($team->looking_for_support == 1)
                                    <img src="/img/roles/support.jpg" class="img-circle" width="35" />
                                @endif
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Languages:</h5>
                                <img src="/img/roles/marksman.jpg" class="img-circle" width="35" />
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Member:</h5>
                                3 Member
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
	@endforeach
@else
	No teams found :(
@endif