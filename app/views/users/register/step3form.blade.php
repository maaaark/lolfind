<h2 class="headline_no_border">Account details</h2>
<table class="table table-striped">
    <tr>
        <td width="200"><strong>Prefered Roles</strong></td>
        <td>
            <label class="rolebox">{{ Form::checkbox('search_top', 1, Input::old('search_top')) }} Top-Lane</label>
            <label class="rolebox">{{ Form::checkbox('search_jungle', 1, Input::old('search_jungle')) }} Jungle</label>
            <label class="rolebox">{{ Form::checkbox('search_mid', 1, Input::old('search_mid')) }} Mid-Lane</label>
            <label class="rolebox">{{ Form::checkbox('search_adc', 1, Input::old('search_adc')) }} Marksman</label>
            <label class="rolebox">{{ Form::checkbox('search_support', 1, Input::old('search_support')) }} Support</label>
        </td>
    </tr>
    <tr>
        <td width="200"><strong>Favorite Champions</strong></td>
        <td>
            <select name="fav_champion_1">
                @if($summoner->fav_champion_1 > 0)
                    <option value="{{ $summoner->fav_champion_1 }}">{{ $summoner->fav1->name }}</option>
                @else
                    <option value="0">No favorite</option>
                @endif
                @foreach($champions as $champion)
                    <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                @endforeach
            </select>

            <select name="fav_champion_2">
                @if($summoner->fav_champion_2 > 0)
                    <option value="{{ $summoner->fav_champion_2 }}">{{ $summoner->fav2->name }}</option>
                @else
                    <option value="0">No favorite</option>
                @endif

                @foreach($champions as $champion)
                    <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                @endforeach
            </select>

            <select name="fav_champion_3">
                @if($summoner->fav_champion_3 > 0)
                    <option value="{{ $summoner->fav_champion_3 }}">{{ $summoner->fav3->name }}</option>
                @else
                    <option value="0">No favorite</option>
                @endif
                @foreach($champions as $champion)
                    <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td width="200"><strong>Looking for team?</strong></td>
        <td>
            <label class="rolebox">{{ Form::checkbox('looking_for_team', 1, Input::old('looking_for_team')) }} I'm looking for a team</label>
        </td>
    </tr>
    <tr>
        <td width="200"><strong>Description</strong></td>
        <td>{{ Form::textarea('description', Input::old('description'),  array('class' => 'form-control')) }}</td>
    </tr>
</table>
@if(!isset($summoner))
<br/>
<h2 class="headline_no_border">Account details</h2>
<table class="table table-striped">

    <tr>
        <td width="200"><strong>E-Mail</strong></td>
        <td>{{ Form::text('email', Input::old('email'),  array('class' => 'form-control')) }}</td>
    </tr>
    <tr>
        <td width="200"><strong>Password</strong></td>
        <td>{{ Form::password('password', array('class' => 'form-control')) }}</td>
    </tr>
    <tr>
        <td width="200"><strong>Repeat Password</strong></td>
        <td>{{ Form::password('password_confirmation', array('class' => 'form-control')) }}</td>
    </tr>

</table>
@endif

<br/>
<h2 class="headline">Linked Summoner</h2>
<table>
    <tr>
        <td valign="top" width="100">
            <img width="80" height="80" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" class="img-circle" alt="{{ $summoner->name }}" />
        </td>
        <td valign="top">
            <h3 style="margin:0; padding: 0;">{{ $summoner->name }}</h3>
            Level {{ $summoner->summonerLevel }} - {{ $summoner->region  }}<br/>
            Summoner ID: {{ $summoner->summoner_id }}
        </td>
    </tr>
</table><br/>