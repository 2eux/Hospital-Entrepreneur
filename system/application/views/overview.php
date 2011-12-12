<?php if($hospitalInfo["is_trial"] == 1): ?>
<div class="ui-widget" style="margin-top: 10px;">
	<div class="ui-state-highlight ui-corner-all" style=" padding: 0 .7em; background-color: #fafafa; border-color: #a6a6a6; background-image: none;"> 
	<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	<strong>Temporary Account</strong></p>
	<p>Welcome to Hospital Entrepreneur,<br /> You are currently using a temporary account. A temporary account has some restrictions like no chatting and some settings that cannot be changed. As well as the fact that it expire within less then 24 hours. However do not fear! Turning your trial account into a normal account is easy and free!

	<p><a href="/index.php/auth/temp_full" style="font-size: 16px">Please click to go to make yourself a permanent account (Everything will stay the same)</a></p>

	</div>
</div><br />
<?php endif; if($hospitalInfo["tutorialStage"] !== "completed"): ?>
<div class="ui-widget" style="margin-top: 10px;">
	<div class="ui-state-highlight ui-corner-all" style=" padding: 0 .7em;"> 
	<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
	<strong>Tutorial</strong></p>
	<p>Welcome to Hospital Entrepreneur,<br />I am your personal helper, you may call me M. Jackson. I will aid you throughout these steps in Hospital Entrepreneur, to help you enhance your knowledge of the game and enhance your gaming experience.</p>
	<ul style="list-style: number" class="text14">
		<li>Understand the overview</li>
		<li>Build your first room</li>
		<li>Build the necessary rooms for the hospital to function</li>
		<li>Hire three doctors, a nurse, a janitor and a receptionist.</li>
		<li>Upgrade your Hospital</li>
		<li>Purchase Stocks</li>
		<!--<li>Use Premium Points (Pills)</li>
		<li>Understand the Events System</li>-->
	</ul>

	<p><a href="/index.php/gettingstarted" style="font-size: 16px">Please click to go to "Getting Started"</a></p>

	</div>
</div><br />
<?php
endif;


	// Do all the parsing here to make the code a bit cleaner

	$output['news'] = "<ul class=\"list_forum\">";
	foreach($news as $article)
	{
		$output['news'] .= "<li><img src=\"/template/images/icons/page_white.png\"><span class=\"topic_header\"><a href=\"/index.php/news/read/{$article[id]}\">{$article[title]}</a></span><span class=\"topic_forum\"><a href='/index.php/user/profile/{$article[author_id]}'>{$article[author]}</a></span></li>";
	}

	$output['news'] .= "</ul>";
?>

<table width="100%" class="overview_table">
	<thead>
		<tr>
			<!--<th>Latest Forum Topics</th>-->
			<th>Latest News Articles</th>
			<th>Last events</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<!--<td valign="top"><?=$forum?></td>-->
			<td valign="top"><?=$output['news']?></td>
			<td valign="top">
	<ul class="list_forum">
<?php
if(count($events) > 0) {
	foreach($events as $event) {
		if($event['read'] == 0) { $style = ""; }

	?>
	
			<li <?=$style?>>
				<img src="/template/images/icons/<?=$event['icon']?>.png">
				<span class='topic_header'><a href="/index.php/event/interact/<?=$event['id']?>"><?=$event['title']?></a></span>
				<span class='topic_forum'><a><?php echo date("h:i:s d-m-Y", $event['time']); ?></a></span>
			</li>

	<?php
	} }
else
{
?>
			<li>
				<img src="/template/images/icons/hourglass.png" style="margin-top: -0px;">
				<span class='topic_header'><a style="color: #999999;">No new events...</a></span>
				<span class='topic_forum'></span>
			</li>
<?php
}
?>		
</ul>
</td>
		</tr>
	</tbody>
</table>


<h2>Transactions</h2>

<table class="table overview">
<thead>
	<tr class="header">
		<th colspan="4">Transactions log</th>
	</tr>
	<tr class="subheader">
		<th style="text-align: center"></th>
		<th>Transaction type</th>
		<th style="text-align: center">Amount</th>
		<th style="text-align: center">Time and Date</th>
	</tr>
<tbody>
<?php

$num = count($log_transactions);
if($num > 0) {

	foreach($log_transactions as $row)
	{

if($r == "row1") { $r = "row2"; } else { $r = "row1"; }


	#if($row['contentType'] !== '1') {
		?>
		<tr class="<?=$r?>" style="background-color: <?php /* if($row['transactionType'] == "Add") { echo '#ccffcc'; } else { echo '#ffbebe'; } */ ?>">
			<td style="width: 16px"><img src="/template/images/icons/<?php echo strtolower($row['transactionType']); ?>.png" border="0" /></td>
			<td>
		<?php
		switch($row['contentType'])
		{
		case '1': $output = "" . $row["numPatients"]. " Patients Cured Last 24 hours"; break;
		case '2': $output = "Salary Payment"; break;
		case '3': $output = "Maintance"; break;
		case '4': $output = "Failing random event"; break;
		case '5': $output = "Succeeding random event"; break;
		case '6': $output = "Fees paid"; break;
		case '7': $output = "Stocks invested"; break;
		case '8': $output = "Stocks sold"; break;
		case '9': $output = "Bought new room"; break;
		case '10': $output = "Demolished room"; break;
		case '11': $output = "Hired new employee"; break;
		case '12': $output = "Stocks Fee"; break;
		case '13': $output = "Upgraded hospital"; break;

		case '14': $output = "Challenge Penalty"; break;
		case '15': $output = "Challenge Bonus"; break;

		case '16': $output = "Gift Withdrawal"; break;

		default: $output = "FIXME: Missing contentType"; break;
		}


		echo $output;
		?></td>
			<td style="text-align: center"><?php echo number_format( $row['money'], 0, ',', ' '); ?></td>
			<td style="text-align: center"><?php echo date('H:i:s d-m-Y', $row['time']); ?></td>
		</tr>
		<?php
	#	}
	}
} else {
?>
<tr>
	<td colspan="4" style="color: #999999;">No transactions have taken place yet...</td>
</tr>
<?php
} ?>
</tbody>

</table>
