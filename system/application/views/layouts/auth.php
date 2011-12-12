<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Hospital Entrepreneur - <?=$title?></title>
		<link type="text/css" href="/template/jqueryUI/css/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<link type="text/css" href="/template/css/main.css" rel="stylesheet" />

		<style type="text/css">
			.header { background-image: url("/template/images/web2front/header.gif"); color: #FFFFFF; font-size: 11px; }
.header ul { list-style-type: none; width: 1024px; margin-left: auto; margin-right: auto; height: 30px; margin-top: 0; margin-bottom: 0; padding-top: 10px; }
.header ul li { display: inline; margin-right: 10px; }
.header ul li a { text-decoration: none; color: #0099cc; }
.header ul li a:hover { text-decoration: underline; }
		</style>

		<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-1.3.2.min.js"></script>
		<?php if(isset($jQuery) && count($jQuery) > 0) foreach($jQuery as $j) { echo $j . "\n"; } ?>
		<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-ui-1.7.2.custom.min.js"></script>
	</head>
	<body>


	<div class="header">
		<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/index.php/auth/register">Sign Up</a></li>
		<li><a href="/index.php/auth">Login</a></li>
		<li><a href="/index.php/auth/forgotten_password">Forgotten password</a></li>
		<li><a href="/index.php/info/contactus">Contact Us</a></li>
	</ul>
</div>
	</div>
	<div class="logo_background">
		<a href="/"><div class="logo">Hospital Entrepreneur.com</div></a>
	</div>



	<div class="content">
		

		<div class="right_auth">
			<div class="content_padding5px">
<?php
					if($error == 1 || $error == true)
					{
						if(is_array($error_message))
						{
							$o = "<ul>";							
							foreach($error_message as $e)
							{
								$o .= "<li>{$e}</li>";
							}
							$o .= "</ul>";
						}
						else
						{
							$o = $error_message;
						}
				echo "<div class=\"ui-widget\">
					<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span> 
						{$o}</p>
					</div>
				</div><br />";
					}
					if($highlight == 1 || $highlight == true)
					{
						if(is_array($highlight_message))
						{
							$o = "<ul>";							
							foreach($highlight_message as $e)
							{
								$o .= "<li>{$e}</li>";
							}
							$o .= "</ul>";
						}
						else
						{
							$o = $highlight_message;
						}
				
				echo "<div class=\"ui-widget\">
					<div class=\"ui-state-highlight ui-corner-all\" style=\" padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>
						{$o}</p>
					</div>
				</div><br />";
					}
				?>
				{yield}
			</div>
		</div>

		<div class="copyright">
		<p>Copyright 2010 Hospital Entrepreneur , All rights reserved. | Hospital Entrepreneur was created by <a href="http://www.thereall.com">Arne-Christian Blystad</a>.</p>
		</div>

	</div>

	

	</body>
</html>


