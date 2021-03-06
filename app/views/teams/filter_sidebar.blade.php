<aside>
    <div id="filters_col">
        <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
        <div class="collapse" id="collapseFilters">

            <div class="filter_type">
                <h6>{{ Lang::get('teams.search.region') }}</h6>
                <div id="region_sel"></div>
            </div>

            <div class="filter_type">
                <h6>{{ Lang::get('teams.search.primary_role') }}</h6>
                <div id="prime_role_sel"></div>
            </div>

            <div class="filter_type">
                <h6>{{ Lang::get('teams.search.league') }}</h6>
                <div id="leagues_sel"></div>
                <ul>
                    <li><label><input type="checkbox" id="search_unranked" name="search_unranked" checked> Search also unranked teams</label></li>
                </ul>
            </div>

            <div class="filter_type">
                <h6>{{ Lang::get('teams.search.primary_lang') }}</h6>
                <div id="prime_lang_sel"></div>
            </div>

            <p><a href="javascript:void(0);" class="btn_1" id="team_list_update_btn">Filter Search</a></p>
        </div><!--End collapse -->
    </div><!--End filters col-->
</aside><!--End aside -->

<script>
    // Make Dropdowns
    $('#region_sel').makeSelect("region", dropdown_region_arr('any'));

    @if(isset($url_selected_league) AND $url_selected_league)
        $('#leagues_sel').makeSelect("league", dropdown_leagues_arr('any'));
        $('#leagues_sel').dropdownSelect("{{ $url_selected_league }}");
    @else
        $('#leagues_sel').makeSelect("league", dropdown_leagues_arr('any'));
    @endif

    $('#prime_lang_sel').makeSelect("main_language", dropdown_languages_arr('any'));
    //$('#sec_lang_sel').makeSelect("sec_language", dropdown_languages_arr('no_value', ["{{ Lang::get('teams.search.none') }}", "no_value"]));
		
    $('#prime_role_sel').makeSelect("primary_role", dropdown_roles_arr('any'));
    $('#sec_role_sel').makeSelect("secundary_role", dropdown_roles_arr('no_value', ["{{ Lang::get('teams.search.any') }}", "no_value"]));
</script>