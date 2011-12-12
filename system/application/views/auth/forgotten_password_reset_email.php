<html>
<title>Hospital Entrepreneur - Reset Password</title>
<body style="background-color:	#fff; font-family: Lucida Grande, Verdana, Sans-serif; font-size: 12px; color: #000;";>
	<div id="content" style="background-color: #fff; padding: 20px 20px 12px 20px;">
		<h1 style="font-family: Georgia, Times, serif; font-weight: normal; font-size: 28pt; line-height: 24pt; letter-spacing: -3px; margin: 14px 0 14px 0;">Hospital Entrepreneur</h1>
		<h2 style="font-weight:	normal; font-size: 16px; color:	#000; margin: 0 0 4px 0; width: 750px; background-color: #F5f5f5; padding: 18px; padding-left: 52px;">Reset Password</h2>
			<pre style="margin-left: 20px; font-size: 14px; font-family: Lucida Grande, Verdana, Sans-serif; ">
<?=$user_name?>,

<?=$this->lang->line('sentry_forgotten_password_reset_email_body_message')?><br />

<?=$this->lang->line('sentry_forgotten_password_reset_email_user_label')?>: <?=$user_name?><br />
<?=$this->lang->line('sentry_forgotten_password_reset_email_password_label')?>: <?=$password?><br />

<a href="http://www.hospital-entrepreneur.com" style="font-size: 14px; margin-left: 20px; text-decoration: none; color: #0099cc;">Click here to login</a>

<?=$this->lang->line('sentry_citation_message')?>
		</pre>

	</div>
</body>
</html>
