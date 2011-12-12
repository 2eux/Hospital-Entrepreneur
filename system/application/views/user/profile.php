<?php
switch($user[0]["activated"]):
	case "1": // User is active
		$URI 		= "ban";
		$TXT		= "Ban";
		$STATUS 	= "Active";
	break;
	default: // User is inactive
		$URI		= "unban";
		$TXT		= "Unban";
		$STATUS		= "Inactive";
	break;
endswitch;
?>

<ul class="adminlist">

<?php
if($authLevel == "Admin"):
?>

	<li class="status<?=$STATUS?>"><b>Status:</b> <?=$STATUS?></li>

	<li><img src="/template/images/icons/application_form_edit.png" alt="Edit"><a href="/index.php/user/edit/<?=$user[0]['id']?>">Edit Profile</a></li>
	<li><img src="/template/images/icons/application_key.png" alt="Ban"><a href="/index.php/user/<?=$URI?>/<?=$user[0]['id']?>" onclick="if(confirm('Are you sure you want to <?=$URI?> <?=$user[0]['user_name']?>?') !== true) { return false; }"><?=$TXT?> User</a></li>

<?php
 	endif;

	if($myProfile == true):
?>
	<li><a href="/index.php/user/edit/" class="" style="margin-right: 5px;"><img src="/template/images/icons/pencil.png" />Edit My Profile</a></li>
<?php else: ?>
	<li><a href="/index.php/mail/newMail/<?=$user[0]['user_name']?>" class="" style="margin-right: 5px;"><img src="/template/images/icons/email_add.png" />Send Message</a></li>
<?php endif; ?>
</ul>
<br /><br />

<table class="table profile_table">
	<thead>
		<tr class="header">
			<th colspan=4><?=$user[0]["user_alias"]?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row1 profile" style="width: 50%"><img src="/template/images/icons/user.png" /><b>Hospital Owner</b></td>
			<td class="row1" style="width: 50%"><?=$user[0]["user_name"]?></td>

			<td colspan=2 rowspan=8 class="row2" style="width: 300px">
				<div style="width: 300px; height: 200px; background-image: url('/template/images/buildings/hospital_grey.png'); background-position: center; background-repeat: no-repeat;"><?php if(!empty($user[0]["avatar_link"])): echo "<img src=\"{$user[0][avatar_link]}\" width=\"300\" height=\"200\" />"; endif; ?></div>
			</td>
		</tr>
		<tr><td class="row1 profile"><img src="/template/images/icons/chart_curve.png" /><b>Stock Value</b></td><td class="row1"><?php echo number_format($user[0]["stockValue"], 2, ',', ' ');?></td></tr>
		<tr><td class="row1 profile"><img src="/template/images/icons/building.png" /><b>Hospital Type</b></td><td class="row1"><?=$hospital[0]["title"]?></td></tr>
		<tr><td class="row1 profile"><img src="/template/images/icons/money.png" /><b>Money</b></td><td class="row1"><?php echo number_format($user[0]["money"], 2, ',', ' ');?></td></tr>
		<tr><td class="row1 profile"><img src="/template/images/icons/money_euro.png" /><b>Company Value</b></td><td class="row1"><?php echo number_format($user[0]["worth"], 2, ',', ' ');?></td></tr>
		<tr><td class="row1 profile"><img src="/template/images/icons/user_suit.png" /><b>Patients Cured</b></td><td class="row1"><?=$user[0]["patientsCured"]?></td></tr>
		<!--<tr><td class="row1 profile"><img src="/template/images/icons/clock.png" /><b>Hours In Game</b></td><td class="row1"><?=$user[0]["hoursInGame"]?></td></tr>-->
		<tr><td class="row1 profile"><img src="/template/images/icons/group.png" /><b>Number of Employees</b></td><td class="row1"><?=$user[0]["numEmployee"]?></td></tr>
	</tbody>
</table>
