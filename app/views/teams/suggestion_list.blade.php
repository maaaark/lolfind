@if(isset($ranked_teams) AND count($ranked_teams) > 0)
	@foreach($ranked_teams as $team)
		<div class="strip_all_tour_list player_searchbox wow fadeIn" data-wow-delay="0.1s">
            <div class="row small_version">
                <div class="col-xs-3" style="text-align: right;">
                    @if(!isset($team->ranked_league_5) || trim($team->ranked_league_5) == "none" || trim($team->ranked_league_5) == "")
                        <div class="ribbon unranked" ></div><br/>
                    @endif
                    <?php
                        $league_logo = "0_5";
                        if(strpos($team->ranked_league_5, "_") > 0){
                            $division = substr($team->ranked_league_5, strpos($team->ranked_league_5, "_") + 1);
                            if($division == "I"){ $division = "1"; }
                            else if($division == "II"){ $division = "2"; }
                            else if($division == "III"){ $division = "3"; }
                            else if($division == "IV"){ $division = "4"; }
                            else { $division = "5"; }
                            $league_logo = trim(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, "_")))."_".trim($division);
                        }
                    ?>


                    <div style="text-align: center;padding-bottom: 15px;">
                        <a href="/teams/{{ $team->region }}/{{ $team->tag }}">
                            <img src="/img/leagues/{{ trim($league_logo) }}.png" style="width: 100%;margin-top: 20px;margin-bottom: 10px;" alt="">
                        </a>
                        @if(isset($division) AND $league_logo != "0_5")
                            <b>{{ ucfirst(trim(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, "_")))) }} {{trim($division) }}</b>
                        @else
                            Placement prediction: <b>{{ ucfirst(trim($team->league_prediction)) }}</b>
                        @endif
                    </div>
                </div>
                <div class="col-xs-9" style="text-align: left;position: relative;">
                    <h3><a href="/teams/{{ $team->region }}/{{ $team->tag }}"><strong>{{ $team->name }}</strong></a></h3>

                    <table class="list_info_table">
                        <tr>
                            <td class="title">Open roles:</td>
                            <td>
                                <?php $no_roles_open = true; ?>
                                @if($team->looking_for_top == 1)
                                    <img src="/img/roles/tank.jpg" class="img-circle tooltips" title="Top" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_jungle == 1)
                                    <img src="/img/roles/fighter.jpg" class="img-circle tooltips" title="Jungle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_mid == 1)
                                    <img src="/img/roles/mage.jpg" class="img-circle tooltips" title="Mid" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_adc == 1)
                                    <img src="/img/roles/marksman.jpg" class="img-circle tooltips" title="ADC" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_support == 1)
                                    <img src="/img/roles/support.jpg" class="img-circle tooltips" title="Support" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif

                                @if($no_roles_open)
                                    No open roles
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Languages:</td>
                            <td>
                                @if($team->looking_for_lang AND trim($team->looking_for_lang) != "")
                                    <img src="/img/flags/{{ $team->looking_for_lang }}.png" class="img-circle" width="35" />
                                @else
                                    No explicit language.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Member:</td>
                            <td>
                                @if($team->player()->count() <= 1)
                                    1 Member
                                @else
                                    {{ $team->player()->count() }} Members
                                @endif
                            </td>
                    </table>
                    <div style="position: absolute;right: 30px;bottom: 10px;"><a href="/teams/{{ $team->region }}/{{ $team->tag }}">more</a></div>
                </div>
            </div>

            <div class="row desktop_version">
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <!--<div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">
                            +<span class="tooltip-content-flip"><span class="tooltip-back">Add to favorites</span></span>
                        </a>
                    </div>-->
                    <div class="center">
                        <div style="text-align: center">
                            @if(!isset($team->ranked_league_5) || trim($team->ranked_league_5) == "none" || trim($team->ranked_league_5) == "")
                                <div class="ribbon unranked" ></div><br/>
                            @endif
                            <?php
                                $league_logo = "0_5";
                                if(strpos($team->ranked_league_5, "_") > 0){
                                    $division = substr($team->ranked_league_5, strpos($team->ranked_league_5, "_") + 1);
                                    if($division == "I"){ $division = "1"; }
                                    else if($division == "II"){ $division = "2"; }
                                    else if($division == "III"){ $division = "3"; }
                                    else if($division == "IV"){ $division = "4"; }
                                    else { $division = "5"; }
                                    $league_logo = trim(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, "_")))."_".trim($division);
                                }
                            ?>


                            <div style="text-align: center;">
                                <a href="/teams/{{ $team->region }}/{{ $team->tag }}">
                                    <img src="/img/leagues/{{ trim($league_logo) }}.png" style="width: 120px;margin-top: 20px;" alt="">
                                </a>
                                @if(isset($division) AND $league_logo != "0_5")
                                    <b>{{ ucfirst(trim(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, "_")))) }} {{trim($division) }}</b>
                                @else
                                    Placement prediction: <b>{{ ucfirst(trim($team->league_prediction)) }}</b>
                                @endif
                            </div>

                            <div class="last_update">Last Update:<br/>{{ $team->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-lg-10 col-md-10 col-sm-10">
                    <div class="">
                        <div style="float: right;font-size: 26px;color: rgba(0,0,0,0.1);cursor: default;padding-right: 20px;">
                            {{ strtoupper(trim($team->tag)) }}
                        </div>
                        <h3>
                            <a href="/teams/{{ $team->region }}/{{ $team->tag }}"><strong>{{ $team->name }}</strong></a>
                            @if(Auth::check())
                              @if($team->looking_for_players == 1)
                                 @if(($check = RankedTeam::loggedCanApplyToTeam($team->id)))
                                      @if($check == "can_apply")
                                         <a href="/teams/{{ $team->region }}/{{ $team->tag }}#open_apply" class="btn_1 outline apply_team_btn" style="margin-left: 10px;">Apply</a>
                                      @elseif($check == "already_applied")
                                         <a href="javascript:void(0);"class="btn_1 outline apply_team_btn disabled" style="margin-left: 10px;" disabled>Already applied</a>
                                      @endif
                                 @endif
                              @endif
                            @endif
                            <a href="/teams/{{ $team->region }}/{{ $team->tag }}" class="btn_1 outline" style="margin-left: 10px;">Open team page</a>
                        </h3>
                        @if($team->description != "")
                            <p>
                                @if(strlen($team->description) > 100)
                                    {{ substr(trim($team->description), 0, 100) }} ...
                                @else
                                    {{ $team->description }}
                                @endif
                                <a href="/teams/{{ $team->region }}/{{ $team->tag }}">more</a>
                            </p>
                        @else
                            <p>No description</p>
                        @endif

                        <div class="row">
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <?php $no_roles_open = true; ?>
                                <h5>Open Roles:</h5>
                                @if($team->looking_for_top == 1)
                                    <img src="/img/roles/tank.jpg" class="img-circle tooltips" title="Top" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_jungle == 1)
                                    <img src="/img/roles/fighter.jpg" class="img-circle tooltips" title="Jungle" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_mid == 1)
                                    <img src="/img/roles/mage.jpg" class="img-circle tooltips" title="Mid" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_adc == 1)
                                    <img src="/img/roles/marksman.jpg" class="img-circle tooltips" title="ADC" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif
                                @if($team->looking_for_support == 1)
                                    <img src="/img/roles/support.jpg" class="img-circle tooltips" title="Support" width="35" />
                                    <?php $no_roles_open = false; ?>
                                @endif

                                @if($no_roles_open)
                                    No open roles
                                @endif
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Languages:</h5>
                                @if($team->looking_for_lang AND trim($team->looking_for_lang) != "")
                                    <img src="/img/flags/{{ $team->looking_for_lang }}.png" class="img-circle" width="35" />
                                @else
                                    No explicit language.
                                @endif
                            </div>
                            <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                <h5>Member:</h5>
                                @if($team->player()->count() <= 1)
                                    1 Member
                                @else
                                    {{ $team->player()->count() }} Members
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
	@endforeach


    <hr>


    <div class="text-center" id="list_pagination_holder">
        {{ $ranked_teams->links() }}
        <script>
        @if(isset($_GET["page"]) AND $_GET["page"] > 0)
            var current_filter_page = {{ $_GET["page"] }};
        @else
            var current_filter_page = 1;
        @endif

        $("#list_pagination_holder ul.pagination li a").click(function(event){
            event.preventDefault();
            if(can_update){
                if($(this).text().trim() != "" && parseInt($(this).text()) > 0){
                    next = $(this).text();
                } else {
                    if($(this).attr("rel") == "prev"){
                        next = current_filter_page - 1;
                    } else {
                        next = current_filter_page + 1;
                    }
                }

                $(window).scrollTop($("#team_list_suggestions").offset().top - 180);
                $.post('/teams/team_list_suggestions?page='+next, {
                    region: $('#region_sel input').val(),
                    league: $('#leagues_sel input').val(),
                    main_lang: $('#prime_lang_sel input').val(),
                    sec_lang: $('#sec_lang_sel input').val(),
                    prime_role: $('#prime_role_sel input').val(),
                    sec_role: $('#sec_role_sel input').val(),
                    unranked_search: $('#search_unranked').prop('checked')
                }).done(function(data){
                    $("#team_list_update_btn").prop("disabled", false);
                    can_update = true;
                    $("#team_list_suggestions").html(data);
                });
            }
        });
        </script>
    </div><!-- end pagination-->
@else
	<div style="text-align: center;margin-top: 25px;"><img src="/img/sad_amumu.png"></div>
    <div style="padding-top: 25px;font-size: 16px;text-align: center;">No teams found matching the current filters :(</div>
@endif