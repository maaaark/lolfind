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
                            <div class="ribbon unranked" ></div><a href="#"><img src="img/leagues/gold_2.png" width="120" alt=""></a><br/>
                            Gold 1<br/>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-10 col-md-10 col-sm-10">
                    <div class="">
                        <h3><strong>{{ $team->name }}</strong></h3>
                        <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis ... <a href="">more</a></p>
                        <div class="row">
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Open Roles:</h5>
                                <img src="http://teamranked.com/img/roles/marksman.jpg" class="img-circle" width="35" />
                                <img src="http://teamranked.com/img/roles/support.jpg" class="img-circle" width="35" />
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Languages:</h5>
                                <img src="http://teamranked.com/img/roles/marksman.jpg" class="img-circle" width="35" />
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