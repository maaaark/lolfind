<div class="network_navi">
	<div class="account_part">
        @if(Auth::check())
            <div class="nw_navi_el account_icon nw_box_btn" data-box="chats_box"><i class="icon-chat-5"></i></div>
            <div class="nw_login_box nw_box_btn" id="nw_chats_box">
                <div class="nw_box_content">
                    <div class="title">{{ Lang::get('users.chats') }}</div>
                    <div id="chats_content" class="nw_chats_box">
                        @if(($chats = Auth::user()->chats()))
                            @foreach($chats as $chat)
                                <div class="chat_box_element" id="nw_chat_box_element_{{ $chat->otherUser(Auth::check())->id }}" data-uID="{{ $chat->otherUser(Auth::check())->id }}" data-uName="{{ $chat->otherUser(Auth::check())->summoner->name }}">
                                    <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $chat->otherUser(Auth::check())->summoner->profileIconId }}.png" class="chat_summoner_icon">
                                    <div class="chat_element_title">{{ $chat->otherUser(Auth::check())->summoner->name }}</div>
                                    <div>
                                        @if(Auth::user()->id == $chat->receiver)
                                            <i class="icon-reply" style="color: rgba(0,0,0,0.2);"></i>
                                        @endif
                                        @if(strlen($chat->message) > 80)
                                            {{ substr($chat->message, 0, 80) }} ...
                                        @else
                                            {{ $chat->message }}
                                        @endif
                                    </div>
                                    <div class="chat_element_date">
                                        {{ Helpers::diffForHumans($chat->created_at) }}
                                    </div>
                                </div>
                            @endforeach
                            <script>
                                $(document).ready(function(){
                                    $("#nw_chats_box #chats_content .chat_box_element").click(function(){
                                        fi_server_open_chat($(this).attr("data-uID"), $(this).attr("data-uName"));
                                    });
                                });
                            </script>
                        @else
                            <div style="padding: 35px;text-align: center;">
                                {{ Lang::get('user.no_chats') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="nw_navi_el account_icon nw_box_btn" data-box="notification_box"><i class="icon-globe-6"></i></div>
            <div class="nw_login_box" id="nw_notifications_box">
                <div class="nw_box_content">
                    <div class="title">{{ Lang::get('users.notifications') }}</div>
                    <div id="notification_content">
                        @if(($notifactions = Auth::user()->notifications()))
                            {{ $notifications }}
                        @else
                            <div style="padding: 35px;text-align: center;">
                                {{ Lang::get('user.no_notifications') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <a href="/summoner/{{ Auth::user()->summoner->region }}/{{ Auth::user()->summoner->name }}"><div class="login_btn nw_navi_el hovered" id="nw_login_btn">{{ Auth::user()->summoner->name }}</div></a>
            <a href="/logout"><div class="login_btn nw_navi_el hovered" id="nw_login_btn">{{ Lang::get('users.logout') }}</div></a>
        @else
            <div class="login_btn nw_navi_el hovered nw_box_btn" data-box="login_box"><i class="fa fa-sign-in"></i> {{ Lang::get('users.login') }}</div>
            <div class="login_btn nw_navi_el hovered"><i class="fa fa-user"></i> {{ Lang::get('users.register') }}</div>
            <div class="nw_login_box" id="nw_login_box">
                <div class="nw_box_content">
                   {{ Form::open(array('url' => '/dologin')) }}
                    <div class="title">{{ Lang::get('users.login') }}</div>
                    <div class="box">
                        <table class="login_input">
                            <tr>
                                <td class="pre">
                                    <i class="icon-user-2"></i>
                                </td>
                                <td class="in">
                                    {{ Form::text('email', Input::old('email'), array('placeholder' => Lang::get('users.placeholder_email'))) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pre">
                                    <i class="icon-key-2"></i>
                                </td>
                                <td class="in">
                                    {{ Form::password('password', array("placeholder" => Lang::get('users.placeholder_password'))) }}
                                </td>
                            </tr>
                        </table>
                        <div style="float: right;padding-top: 3px;">
                            {{ Form::submit(Lang::get("users.login"), array('class' => 'button_intro')) }}
                        </div>
                        <div style="padding-top: 8px;"><a href="#">{{ Lang::get('users.forgot_pw') }}</a></div>
                    </div>
                   {{ Form::close() }}
               </div>
            </div>
        @endif
	</div>
	<div class="network_logo">FLASHIGNITE Network</div>
</div>
