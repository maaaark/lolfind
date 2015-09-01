<div id="header_menu">
    <img src="/img/teamranked_black.png" width="160" height="34" alt="Teamranked.com" data-retina="true">
</div>
<a href="javascript:void(0)" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
<ul id="page_main_menu_items_holder">
    <li class="submenu">
        <a href="/teams" class="text-shadow show-submenu">Search Team <i class="icon-down-open-mini"></i></a>
        <ul>
            @if(Auth::check())
                <li style="text-align: center;"><a href="/applications">Your applications</a></li>
            @endif
            <li><a href="/teams/league/bronze"><img src="/img/leagues/bronze_1.png" height="23"> Bronze</a></li>
            <li><a href="/teams/league/silver"><img src="/img/leagues/silver_1.png" height="23"> Silver</a></li>
            <li><a href="/teams/league/gold"><img src="/img/leagues/gold_1.png" height="23"> Gold</a></li>
            <li><a href="/teams/league/platinum"><img src="/img/leagues/platinum_1.png" height="23"> Platinum</a></li>
            <li><a href="/teams/league/diamond"><img src="/img/leagues/diamond_1.png" height="23"> Diamond</a></li>
            <li><a href="/teams/league/master"><img src="/img/leagues/master_I.png" height="23"> Master</a></li>
            <li><a href="/teams/league/challenger"><img src="/img/leagues/challenger_1.png" height="23"> Challenger</a></li>
        </ul>
    </li>
    <li class="submenu">
        <a href="/players" class="show-submenu text-shadow">Search Player <i class="icon-down-open-mini"></i></a>
        <ul>
            <li><a href="/players/top"><img src="/img/roles/tank.jpg" height="23" class="img-circle" > Top-Laner</a></li>
            <li><a href="/players/jungle"><img src="/img/roles/fighter.jpg" height="23" class="img-circle" > Jungler</a></li>
            <li><a href="/players/mid"><img src="/img/roles/mage.jpg" height="23" class="img-circle" > Mid-Laner</a></li>
            <li><a href="/players/adc"><img src="/img/roles/marksman.jpg" height="23" class="img-circle" > AD-Carry</a></li>
            <li><a href="/players/support"><img src="/img/roles/support.jpg" height="23" class="img-circle" > Support</a></li>
        </ul>
    </li>
    <li>
        <a href="/ringer" class="show-submenu text-shadow">Find a Ringer</a>
    </li>
    <li>
        <a href="/forum" class="show-submenu text-shadow">Forum</a>
    </li>
    <li>
        <a href="/blog" class="show-submenu text-shadow">Blog</a>
    </li>
</ul>