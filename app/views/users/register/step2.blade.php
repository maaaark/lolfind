@extends('design')
@section('title', "New Account - Step 2")
@section('content')
    <section id="hero" class="register">
        <div class="container margin_30 register">
            @include('layouts.errors')
            <h2 class="headline">Progress</h2>

            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                    Step 2 of 4
                </div>
            </div>

            <div style="width: 200px;margin: auto;margin-top: 15px;">
                <table>
                    <tr>
                        <td valign="top" width="100">
                            <img width="80" height="80" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" class="img-circle" alt="{{ $summoner->name }}" />
                        </td>
                        <td valign="top" style="padding-top: 15px;">
                            <h3 style="margin:0; padding: 0;">{{ $summoner->name }}</h3>
                            <div style="padding-top: 5px;">Level {{ $summoner->summonerLevel }} - {{ strtoupper($summoner->region) }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="margin: auto;width: 100%;max-width: 400px;background: rgba(0,0,0,0.1);padding: 25px;margin-top: 35px;">
                <h2 class="headline" style="margin-top: 0px;padding-top: 0px;">Validation Code:</h2>
                <input type="text" value="{{Session::get('verify_code')}}" style="padding: 15px;box-sizing: border-box;font-size: 16px;width: 100%;cursor: pointer;" onclick="this.select();" readonly>
                
                <div style="padding-bottom: 20px;padding-top: 15px;">
                    Rename one of your runepages to the code above and save it.<br/>
                    After saving click on the button to verify your summoner.
                </div>
                <a href="/verify_summoner" class="btn_1">Verify summoner</a>
            </div>
        </div>
    </section>
@stop