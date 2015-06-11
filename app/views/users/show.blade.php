@extends('layouts.small_header')
@section('title', $user->username)
@section('subtitle', $user->username)
@section('content')

<table width="100%">
	<tr>
		<td width="170" class="center" valign="top">
			<img width="150" src="/img/team/{{ $user->image }}" class="img-circle">
        </td>
		<td valign="top">
			<table width="100%" class="table table-striped">
				<tr>
					<td width="110"><strong>Name</strong></td>
					<td>{{ $user->username }}</td>
				</tr>
                @if($user->summoner)
				<tr>
					<td width="110"><strong>Summoner</strong></td>
					<td>
                        <img height="30" src="http://ddragon.leagueoflegends.com/cdn/{{ $patchversion }}/img/profileicon/{{ $user->summoner->profileIconId }}.png" class="img-circle" alt="{{ $user->summoner->name }}" />
                        <a href="http://summoner.flashignite.com/{{ $user->summoner->region }}/{{ $user->summoner->name }}"><img height="30" src="http://summoner.flashignite.com/img/stats/tiers/{{ $user->summoner->solo_tier }}_I.png" alt=""></a>
                        <a href="http://summoner.flashignite.com/{{ $user->summoner->region }}/{{ $user->summoner->name }}">{{ $user->summoner->name }}</a>
                    </td>
				</tr>
                @endif
				<tr>
					<td width="110"><strong>Badges</strong></td>
					<td><span class="badge">Level {{ $user->level }}</span>&nbsp;
                        @if($user->hasRole("admin"))
                            <span class="badge" style="background: #f25825;">Administrator</span>
                        @endif
                        <span class="badge" style="background: #27f28e;">Komplettes Profil</span>
                    </td>
				</tr>
                <tr>
                    <td width="110"><strong>Beiträge</strong></td>
                    <td>
                        12 Kommentare, 2 News
                    </td>
                </tr>
                <tr>
                    <td width="110"><strong>Dabei seit</strong></td>
                    <td>
                        {{ Helpers::diffForHumans($user->created_at) }}
                    </td>
                </tr>
				<tr>
					<td width="110"><strong>Beschreibung</strong></td>
					<td>{{ $user->description }}</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
@stop