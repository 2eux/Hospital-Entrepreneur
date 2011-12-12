<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Strategy Game - Free Browser Based Strategy Game | Hospital Entrepreneur.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="{baseurl}/template/css/main_website.css">
<link rel="stylesheet" type="text/css" href="{baseurl}/template/jqueryUI/css/custom-theme/jquery-ui-1.7.2.custom.css">
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="{baseurl}/template/css/main_website_ie.css" />
<![endif]-->
<link rel="shortcut icon" href="/favicon.ico" /> 
<script type="text/javascript" language="javascript" src="{baseurl}/template/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="{baseurl}/template/js/fbconnect.js"></script>
</head>

<body>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
  FB.init({
    appId: "116751321685295",
    xfbml: true,
    cookie: true,
    status: true
  });
};
(function() {
  var e = document.createElement('script'); e.async = true;
  e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
  document.getElementById('fb-root').appendChild(e);
}());
</script>

<div class="header">
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/index.php/auth/register">Sign Up</a></li>
		<li><a href="/index.php/auth">Login</a></li>
		<li><a href="/index.php/auth/forgotten_password">Forgotten password</a></li>
		<li><a href="/index.php/info/contactus">Contact Us</a></li>
	</ul>
</div>
<div class="logo_gradient">
	<div class="logo">

		<div class="bottom_boundary">
		<!-- Login and Register button -->
		<div class="left">
		<ul>
			<li>Ready to manage your Hospital?</li>
			<li class="last">Want to just try and see how it looks?</li>
		</ul>
		<ul>
			<?php /* <li><span id="top">Ready to manage your hospital?</span><a><div class="register_btn">Create your Hospital!</div></a></li>
			<li><span id="top">Want to just try it out?</span><a><div class="register_btn">Trial Account<span>Instant Gaming</span></div></a></li> */ ?>

			

			<li class="register_btn" onclick="javascript: window.location='/index.php/auth/register';"><a href="/index.php/auth/register">Create your account!</a></li>
			<li class="register_btn last" onclick="javascript: window.location='/index.php/auth/temp';"><a href="/index.php/auth/temp">&nbsp;Temporary Account&nbsp;&nbsp;&nbsp;</a></li>
		</ul>
		</div>

		<div class="right">
			
			<form action="/index.php/auth/login" method="POST">
			<h2>Login to your Hospital:</h2>

			<div class="username">
				<label for="username">Username:</label>
				<input type="text" id="user_name" name="user_name" />
			</div>

			<div class="password">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" />
			</div>

			<br />

			<div class="subitems">
			<ul>
				<li><a href="/index.php/auth/forgotten_password">Forgot password?</a></li>


				<li>
					<label for="auto_login">Remember me:</label>
					<input type="checkbox" id="auto_login" name="auto_login" />
				</li>
			</ul>
			</div>

			<div class="submit">
				<button type="submit" value="Login!" id="submit" name="submit">Submit</button>
			</div>

			</form>

		</div>

		</div>

	</div>
</div>


<div class="wrapper">
<!--
	<table class="container" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="logo_left" width="15%"></td>
		<td class="middle">
		<table border="0" cellspacing="0" cellpadding="0" width="1024">
			<tr valign="top">		
			<td class="logo">
<?php include("menu_top.php"); ?>

				<div class="login_form">
					<form action="/index.php/auth/login" method="post">

					<label for="user_name">Username:</label>
					<input type="text" id="user_name" name="user_name" value="" />

					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" />
			
				 	<label for="auto_login" class="labelCheckbox">Auto Login?</label>
					 <input type="checkbox" name="auto_login" value="" id="auto_login"  />

					<input type="submit" name="submit" value="Sign in!" />
					<input type="submit" name="register" id="register_button" value="Register!" /><a href="/index.php/auth/forgotten_password" class='ui-corner-all button buttonIcon'><img src="/template/images/icons/key_go.png" alt="" />Forgotten Password?</a></form>-->
<!--
<fb:login-button size="medium" onlogin="facebook_onlogin();">Connect with Facebook</fb:login-button> -->
				<!--</div>

			</td>
			</tr>
		</table>
		</td>
		<td class="logo_left"  width="15%"></td>
	</table>-->

	{yield}
</div>



</body>
</html>
