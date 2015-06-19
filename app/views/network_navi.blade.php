<div class="network_navi">
	<div class="account_part">
        @if(Auth::check())
            <a href="/summoner/{{ Auth::user()->summoner->region }}/{{ Auth::user()->summoner->name }}"><div class="login_btn nw_navi_el hovered" id="nw_login_btn">{{ Auth::user()->summoner->name }}</div></a>
            <a href="/logout"><div class="login_btn nw_navi_el hovered" id="nw_login_btn">{{ Lang::get('users.logout') }}</div></a>
        @else
            <div class="login_btn nw_navi_el hovered" id="nw_login_btn"><i class="fa fa-sign-in"></i> {{ Lang::get('users.login') }}</div>
            <div class="login_btn nw_navi_el hovered"><i class="fa fa-user"></i> {{ Lang::get('users.register') }}</div>
            <div class="nw_login_box" id="nw_login_box">
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
        @endif
	</div>
	<div class="network_logo">FLASHIGNITE Network</div>
</div>
