<div class="network_navi">
	<div class="account_part">
		<div class="login_btn nw_navi_el hovered" id="nw_login_btn"><i class="fa fa-sign-in"></i> {{ Lang::get('users.login') }}</div>
		<div class="login_btn nw_navi_el hovered"><i class="fa fa-user"></i> {{ Lang::get('users.register') }}</div>
		<div class="nw_login_box" id="nw_login_box">
			<div class="title">{{ Lang::get('users.login') }}</div>
			<div class="box">
				<table class="login_input">
					<tr>
						<td class="pre">
							<i class="fa fa-user"></i>
						</td>
						<td class="in">
							<input type="text" name="username" placeholder="{{ Lang::get('users.placeholder_email') }}">
						</td>
					</tr>
					<tr>
						<td class="pre">
							<i class="fa fa-key"></i>
						</td>
						<td class="in">
							<input type="password" name="password" placeholder="{{ Lang::get('users.placeholder_password') }}">
						</td>
					</tr>
				</table>
				<div style="float: right;padding-top: 3px;">
					<button class="small">{{ Lang::get('users.login') }}</button>
				</div>
				<div style="padding-top: 8px;"><a href="#">{{ Lang::get('users.forgot_pw') }}</a></div>
			</div>
		</div>
	</div>
	<div class="network_logo">FLASHIGNITE Network</div>
</div>