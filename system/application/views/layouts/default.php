<?php
@session_start();
$CI =& get_instance();

global $benchmark;


if($CI->authlib->getSecurityRole() == "Admin") {
		$query = $CI->db->query("SELECT * FROM `user` WHERE DATE_SUB(NOW(), INTERVAL 15 MINUTE) <= last_visit");
		$num = $query->num_rows();
		$query2 = $CI->db->query("SELECT * FROM `user`");
		$num2 = $query2->num_rows();


		$benchmark['people_online'] = $num;
		$benchmark['people_registered'] = $num2;
		$benchmark['queries'] = $CI->db->total_queries(); 
}

$_SESSION['username'] = $CI->authlib->getUserName();
//$_SESSION['username'] = $userID;
$_SESSION['userid'] = $userID;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Hospital Entrepreneur - <?=$title?></title>
		<link type="text/css" href="/template/jqueryUI/css/custom-theme/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<link type="text/css" href="/template/css/main.css" rel="stylesheet" />
		<link type="text/css" href="/template/css/tipsy.css" rel="stylesheet" />
		<link type="text/css" href="/template/css/screen.css" rel="stylesheet" />
		<link rel="shortcut icon" href="/favicon.ico" /> 
		<link type="text/css" href="/template/css/chat.css" rel="stylesheet" />
		<!--[if lte IE 7]>
		<link type="text/css" rel="stylesheet" media="all" href="/template/css/screen_ie.css" />
		<![endif]-->
		<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-1.3.2.min.js"></script>
		<?php if(isset($jQuery) && count($jQuery) > 0) foreach($jQuery as $j) { echo $j . "\n"; } ?>
		<script type="text/javascript" language="javascript" src="{baseurl}template/js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="{baseurl}template/js/chat.js"></script>
	</head>
	<body>
<!--
	<table class="logo_table">
		<tr>
			<td class="logo_left"></td>
			<td class="logo"  valign="top"><?php include("menu_top.php"); ?></td>
			<td class="logo_right"></td>
		</tr>-->
<?php if($setting_advertisin): ?>
		<!-- FIXME: ad:default_top start -->

		<a href="<?=$advertising[default_top][href]?>"><div class="adDefault_middle" style="background-image: url('<?=$advertising[default_top][image]?>');"></div></a>
		<!-- FIXME: ad:default_top end -->
<?php endif; ?>
	<!--</table>-->

<div class="width100">

	<div class="header_nav">
		<ul>
			<li>Welcome to Hospital Entrepreneur <a href="/index.php/user/profile/<?=$userID?>"><?php echo $hospitalInfo["user_name"]; ?></a> (<a href="/index.php/auth/logout">Log out</a>)</li>
			<li id="event" class="noNew">
				<ul class="eventList">
					<li class="msg"><span>Events</span></li>
					<li class="noNew">No New Events</li>
					<li onclick="javascript: window.location='/index.php/event/log'" class="last"><a href="/index.php/event/log">View all Events</a></li>
				</ul>
			</li>
			<li id="money" title="Your current money" class="tipsySouth"><?=$hospitalInfo["money"]?></li>
			<li id="companyvalue" title="Your company value" class="tipsySouth"><?=$hospitalWorth?></li>
			<li id="premiumexpire" class="tipsySouth" title="Premium Expiration date"><?php if($hospitalInfo["premiumPackage"] > 1): $pp = explode("-",$hospitalInfo['premiumExpire']); $premiumExpire = $pp[2] . "/" . $pp[1] . "/" . $pp[0]; echo $premiumExpire; else: echo "<a href='/index.php/premium/buy'>Purchase Premium</a>"; endif; ?></li>
			<li id="stockvalue"  class="tipsySouth" title="Your stock value"><?=$stockValue?></li>
			<li id="hospitalarea" class="tipsySouth" title="Remaining hospital area"><?=$hospitalInfo["hospitalArea"]?></li>
<?php if($hospitalInfo["numMail"] > 0): $style = "new"; $mail = "<b>{$hospitalInfo[numMail]}</b>"; else: $style = ""; $mail = "0"; endif; ?>
			<li id="mail<?=$style?>" class="tipsySouth" title="Your mail"><?=$mail?></li>
			<li id="patients" class="tipsySouth" title="The number of patients you have cured"><?=$hospitalInfo["patients"]?></li>
			<li id="group" class="tipsySouth" title="The number of employees at your hospital"><?=$hospitalInfo["numEmployee"]?></li>
			<li id="pills" class="tipsySouth" title="Premium points"><?=$hospitalInfo["numPills"]?></li>
		</ul>
	</div>

	<div class="logo_background">
		<a href="/"><div class="logo">Hospital Entrepreneur.com</div></a>
	</div>


	<div class="content">
		
		<div class="left">	
<?php if($IAMDISABLED): ?>
			<!-- FIXME: ad:menu_left start -->
			<div class="full_menu">
				<ul class="menu_full">
					<li><a><img src="/template/images/icons/transmit.png" /><i>Advertising Spot</i><br />ad:menu_left</a></li>
				</ul>
			</div>
			<!-- FIXME: ad:menu_left end -->
<?php endif; ?>

			<div class="full_menu">
				<div class="top"><img src="/template/images/menu_header.gif" alt="" /></div>
				<ul class="menu_full">
					<?php  if($hospitalInfo["tutorialStage"] !== "completed"): ?>
					<li><a href="/index.php/gettingstarted"><img src="/template/images/icons/star.png" /><b>Getting Started!</b></a>

					<?php endif; if(count(explode("/index.php/overview", $_SERVER['REQUEST_URI'])) == 2 | count(explode("/index.php/news", $_SERVER['REQUEST_URI'])) == 2 | count(explode("/index.php/event", $_SERVER['REQUEST_URI'])) == 2) {
						echo '<li><a href="/index.php/overview"><img src="/template/images/icons/application_view_detail.png" ><b>Overview</b></a></li>';
						echo "<ul class='noBg'><li><a href=\"/index.php/news\"><img src=\"/template/images/icons/page_white_stack.png\" />News</a></li>";
						echo "<li><a href=\"/index.php/event/log\"><img src=\"/template/images/icons/report.png\" />Events Report</a></li></ul>";
					} else {
						echo '<li><a href="/index.php/overview"><img src="/template/images/icons/application_view_detail.png">Overview</a></li>';
					}

					/*if(count(explode("/index.php/bank", $_SERVER['REQUEST_URI'])) == 2):
						echo '<li><a href="/index.php/bank"><img src="/template/images/icons/application_view_detail.png" ><b>Bank</b></a></li>';
						echo "<li><ul><a href=\"/index.php/news\"><img src=\"/template/images/icons/page_white_stack.png\" />Withdraw</a></ul>";
						echo "<ul><a href=\"/index.php/event/log\"><img src=\"/template/images/icons/report.png\" />Deposit</a></ul>";
						echo "<ul><a href=\"/index.php/event/log\"><img src=\"/template/images/icons/report.png\" />Loan</a></ul></li>";
					else:
						echo '<li><a href="/index.php/bank"><img src="/template/images/icons/application_view_detail.png">Bank</a></li>';
					endif;
					*/
					if(count(explode("/index.php/hospital", $_SERVER['REQUEST_URI'])) == 2) {
						echo '<li><a href="/index.php/hospital"><img src="/template/images/icons/building.png" ><b>Hospital</b></a></li>';
						
					} else {
						echo '<li><a href="/index.php/hospital"><img src="/template/images/icons/building.png" >Hospital</a></li>';
					}
					if(count(explode("/index.php/building", $_SERVER['REQUEST_URI'])) == 2) { ?>
<li>
	<a href="/index.php/hospital">
		<img src="/template/images/icons/shape_move_back.png" ><b>Room Designer</b>
	</a>
</li>
<ul class="noBg">
	<li><a href="/index.php/building/build"><img src="/template/images/icons/shape_square_add.png" >Add Rooms</a></li>
	<li><a href="/index.php/building"><img src="/template/images/icons/shape_ungroup.png" >Manage Rooms</a></li>
</ul>
<?php
					} else {
echo '<li><a href="/index.php/building/build"><img src="/template/images/icons/shape_move_back.png" >Room Designer</a></li>';
					}
					if(count(explode("/index.php/units", $_SERVER['REQUEST_URI'])) == 2)
					{
					?>
					<li><a href="/index.php/units"><img src="/template/images/icons/group.png" ><b>Employees</b></a></li>
					<ul class="noBg">
						<li><a href="/index.php/units"><img src="/template/images/icons/group_gear.png" alt="" />Manage Employees</a></li>
						<li><a href="/index.php/units/hire"><img src="/template/images/icons/group_edit.png" alt="" />Hire Employees</a></li>
					</ul>
					<?php
					} else
					{
					?>
					<li><a href="/index.php/units"><img src="/template/images/icons/group.png" >Employees</a></li>
					<?php
					}
					
					if($hospitalInfo["numMail"] > 0): $mail = "&nbsp;&nbsp;({$hospitalInfo["numMail"]})"; else: $mail = ""; endif;

					if(count(explode("/index.php/mail", $_SERVER['REQUEST_URI'])) == 2)
					{
					 ?>
					<li><a href="/index.php/mail"><img src="/template/images/icons/email.png" ><b>Mailbox</b></a><?=$mail?></li>					
					<ul class="noBg">
						<li><a href="/index.php/mail/newMail"><img src="/template/images/icons/email_add.png" alt="" />New Mail</a></li>						
						<li><a href="/index.php/mail"><img src="/template/images/icons/email_open.png" alt="" />Inbox</a></li>
						<!-- FIXME: Will be added later :) <ul><a href="/index.php/mail/outbox"><img src="/template/images/icons/email_go.png" alt="" />Outbox</a></ul> -->
					</ul>						
					<?php } else {
						echo '<li><a href="/index.php/mail"><img src="/template/images/icons/email.png" >Mailbox</a> '.$mail.'</li>';
					}
					if(count(explode("/index.php/stocks", $_SERVER['REQUEST_URI'])) == 2)
					{


						echo '
<li>
	<a href="/index.php/stocks">
		<img src="/template/images/icons/chart_curve.png" />
		<b>Stocks</b>
	</a>
</li>
	<ul class="noBg" style="margin-left: -20px">
		<li><a href="/index.php/stocks">
			<img src="/template/images/icons/chart_curve.png" />
			Overview
		</a>
		</li>
		<li>
		<a href="/index.php/stocks/myStocks">
			<img src="/template/images/icons/chart_curve_edit.png" />
			Stocks
		</a>
		</li>
		<li>
		<a href="/index.php/stocks/memberslist">
			<img src="/template/images/icons/building_go.png">
			List of Hospitals
		</a>
		</li>
		<li>
		<a href="/index.php/stocks/stockholders">
			<img src="/template/images/icons/user_go.png" />
			Stockholders
		</a>
		</li>
	</ul>';
					}
					else
					{
						echo '<li><a href="/index.php/stocks"><img src="/template/images/icons/chart_curve.png" />Stocks</a></li>';
					}
					?>
					<?php /*<li><a href="/forum"><img src="/template/images/icons/comments.png">Forum</a></li> */ ?>
					<?php /*<li><a href="/index.php/highscores"><img src="/template/images/icons/award_star_gold_2.png" >Hi-scores</a></li>
					<li><a href="/index.php/highscores/myachivements"><img src="/template/images/icons/medal_gold_1.png" >Acheivements</a></li> */ ?>
					<li style="background-color: #FFF !important"></li>
					<?php if(count(explode("/index.php/premium", $_SERVER['REQUEST_URI'])) == 2) {
					echo '
<li class="premium">
	<a href="/index.php/premium/buy">
		<img src="/template/images/icons/pill_go.png" >
		Premium Features
	</a>
</li>
<ul style="margin-left: -20px">
	<li>
		<a href="/index.php/premium/spend">
			<img src="/template/images/icons/pill.png">
			Spend Pills
		</a>
	</li>
	<li>
		<a href="/index.php/premium/log">
			<img src="/template/images/icons/text_list_bullets.png">
			Transactions
		</a>
	</li>
</ul>';
					} else {
						echo '<li class="premium"><a href="/index.php/premium/buy"><img src="/template/images/icons/pill.png" >Premium Features</a></li>';
					}
					?>
				</ul>
				<div class="bottom"><img src="/template/images/menu_footer.gif" alt="" /></div>
			</div>

<?php
if($authLevel == "Admin")
{ ?>
			<div class="full_menu admin_menu">
				<div class="top"><img src="/template/images/menu_header.gif" alt="" /></div>
				<ul class="menu_full">
					<li><a href="/index.php/admin"><img src="/template/images/icons/application_view_detail.png" />Admin Overview</a></li>
					<li><a href="/index.php/admin/server_status"><img src="/template/images/icons/server.png" />Server Status</a></li>
					<li><a href="/index.php/event/admin"><img src="/template/images/icons/report_edit.png" />Events Management</a></li>
					<li><a href="/index.php/admin/log"><img src="/template/images/icons/text_list_bullets.png"/>Admin Log</a></li>
					<li><a href="/index.php/admin/ads"><img src="/template/images/icons/images.png" />Manage Ads</a></li>
				</ul>
				<div class="bottom"><img src="/template/images/menu_footer.gif" alt="" /></div>
			</div>
<?php
}
?>


		</div>
		<div class="right">
			<div class="content_padding5px">
<div class="ajaxmenu">
	<div class="ajaxsuccess"><img src="/template/images/icons/accept.png" /><span id="message">Success!</span></div>
	<div class="ajaxfailure"><img src="/template/images/icons/exclamation.png" /><span id="message">Error! </span></div>
		<div class="ajaxloading"><img src="/template/images/littleloader.gif" /><span id="message">Loading...</span></div>
<div class="ajaxmove" style="display: none">
<br /><br /><br />
</div>
</div>

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
				echo "<br /><div class=\"ui-widget\">
					<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span> 
						<strong>Alert:</strong>{$o}</p>
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
				
				echo "<br /><div class=\"ui-widget\">
					<div class=\"ui-state-highlight ui-corner-all\" style=\" padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>
						<strong>Notice:</strong> {$o}</p>
					</div>
				</div><br />";
					}
				?>
				{yield}
			</div>
		</div>
		<div class="copyright">
		<p>Copyright 2010 Hospital Entrepreneur , All rights reserved.  | Hospital Entrepreneur was created by <a href="http://www.thereall.com">Arne-Christian Blystad</a> <br /> <a href="/index.php/info/privacy">Privacy Policy</a> | <a href="/index.php/info/termsofusage">Terms of Usage</a> | <a href="/index.php/info/contributors">Project Contributors</a> | <a href="/index.php/info/contactus">Contact Us</a></p>
		</div>
<?php
if($CI->authlib->getSecurityRole() == "Admin") {
?>
		<div class="copyright debug">
		<ul>
			<li>Page Execution Time: <b>{elapsed_time}</b></li>
			<li>Memory Used By Page: <b>{memory_usage}</b></li>
			<li>Queries Executed: <b><?=$benchmark['queries']?></b></li>
			<li>Users Online: <b><?=$benchmark['people_online']?></b></li>
			<li>Users Registered: <b><?=$benchmark['people_registered']?></b></li>
		</ul>
		</div>
<?php
}
?>

	</div>
<div id="bottom">
<ul class="menu_bottom">
<?php if($hospitalInfo["is_trial"] == 1): ?>
<li class="nav2"><b>Chat is disabled for temporarily accounts</b></li>
<?php else: ?>
<li class="nav"><img src="/template/images/icons/tick.png" /><a>Chat (<span>...</span> Online)</a></li>
	<li class="sub" id="chatbar_friendslist" style="display: none">
		<ul class="title">Players Online (<span></span>)</ul>
		<ul class="user">
			<li style="color: #666666" id='noUser'>No users online....</li>
		</ul>
	</li>
<?php endif; ?>
</ul>

</div>
<?php /*
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16756684-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
*/ ?>

<div id="event"></div>
<div id="sound"></div>

</div>

	</body>
</html>


