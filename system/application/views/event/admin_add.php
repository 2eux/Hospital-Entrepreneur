<br />
<h1>Add new event</h1>
<p>Here you can add a new event. If you've never done it before then please don't add a new event before you've questioned either the Project Manager or the Lead Developer</p>
<h2>Transaction Log Codes:</h2>
<ul class="font">
	<ul>
		<li><b>1:</b> Cured Patients</li>
		<li><b>2:</b> Salary Payment</li>
		<li><b>3:</b> Maintance</li>
		<li><b>4:</b> Failing Random Event</li>
		<li><b>5:</b> Succeeding Random Event</li>
		<li><b>6:</b> Fees Paid</li>
		<li><b>7:</b> Stocks Invested</li>
		<li><b>8:</b> Stocks Sold
		<li><b>9:</b> Bought new room</li>
		<li><b>10:</b> Destroyed room</li>
		<li><b>11:</b> Hired New Employee</li>
		<li><b>12:</b> Stocks fee</li>
		<li><b>13:</b> Upgraded Hospital</li>
		<li><b>14:</b> Challenge Pentaly</li>
		<li><b>15:</b> Challenge Bonus</li>
		<li><b>16:</b> Gift Withdrawal</li>
	</ul>
</ul>
<br />

<form action="/index.php/event/admin_add_post" method="post" id="eventAdd" />
<fieldset>
	<legend>New Event</legend>

	<div class="required">
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" value="" style="width: 400px;" />
	</div>

	<div class="required">
		<label for="event_type">Event Type:</label>
			<select id="event_type" name="event_type" style="height: 22px; width: 408px;">
				<option value="normal_event_random">normal_event_random</option>
				<option value="important_event_random">important_event_random</option>

				<option value="gift_event_random">gift_event_random</option>
				<option value="gift_event_user">gift_event_user</option>

				<option value="friend_event_request">friend_event_request</option>
				<option value="friend_event_accept">friend_event_accept</option>
				<option value="friend_event_decline">friend_event_decline</option>

				<option value="mail_event_admin">mail_event_admin</option>
				<option value="mail_event_reminder">mail_event_reminder</option>
			</select>
	</div>

	<div class="required">
		<label for="icon">Icon:</label>
		<input type="text" name="icon" id="icon" style="width: 400px;" />
		<p>Relative to path: <b>/template/images/icons/</b> (Standard images: warning, exclamation, heart, email, script)</p>
	</div>

	<div class="required">
		<label for="from">From / FromUID:</label>
		<input type="text" name="from" id="from" style="width: 194px;" />
		<input type="text" name="fromuid" id="fromuid" style="width: 194px" />
		<p>Possible Values that will be replaced: <a class="tipsyNorth" title="Random Username">%RANDOM_USER%</a> <a class="tipsyNorth" title="This hospital">%USER_ALIAS%</a> / <a class="tipsyNorth" title="This will output the UserID to the random user">%RANDOM_USER_ID%</a> <a class="tipsyNorth" title="This will result in no UserID">0</a></p>	
	</div>
	
	<div class="required">
		<label for="content">Message:</label>
		<textarea name="content" id="content"></textarea>
	</div>

</fieldset>
<?php
for($x = 1; $x < 5; $x++) { ?>
<fieldset>

	<legend>Action <?=$x?></legend>

	<div class="required">
		<label for="title_<?=$x?>">Title</label>
		<input type="text" name="title_<?=$x?>" id="title_<?=$x?>" />
	</div>

	<div class="required">
		<label for="icon_<?=$x?>">Icon</label>
		<input type="text" name="icon_<?=$x?>" id="icon_<?=$x?>" />
	</div>

	<div class="required" id="text_on_click_<?=$x?>">
		<label for="text_<?=$x?>">Text on Click</label>
		<input type="text" name="text_<?=$x?>" id="text_<?=$x?>" />
	</div>

	<div class="required">
		<label for="event_<?=$x?>">Event on Click</label>
		<select name="event_<?=$x?>" id="event_<?=$x?>" onchange="javascript: checkIfEventRandom(<?=$x?>);" style="height: 22px;">
			<option value="empty" selected></option>
			<option value="addMoney">Add Money</option>
			<option value="removeMoney">Remove Money</option>
			<!--<option value="addFriend">Add Friend</option>
			<option value="removeFriend">Remove Friend</option>-->
			<option value="">----------------------------</option>
			<option value="random">Random Event</option>
		</select>
	</div>
	
	<div id="random_<?=$x?>" class="random_event"> <!-- Shown if Event = Random -->
		
<?php
	$array = array("From", "To", "MoreThan","LessThan","PositiveMessage", "NegativeMessage");
	$text  = array("From Value:", "To Value:", "More Than Value:", "Less Than Value:", "Positive Message:", "Negative Message:");
	foreach($array as $key => $value)
	{
		echo "
			<div class='required'>
				<label for='random_{$value}_{$x}'>{$text[$key]}</label>
				<input type='text' name='random_{$value}_{$x}' id='random_{$value}_{$x}' />
			</div>
			";
	}

	$array = array("PositiveEvent", "NegativeEvent");
	$text = array("Positive Event", "Negative Event");

	foreach($array as $key => $value)
	{ ?>
	<div class="required">
		<label for="random_<?=$value?>_<?=$x?>"><?=$text[$key]?></label>
		<select name="random_<?=$value?>_<?=$x?>" id="random_<?=$value?>_<?=$x?>" style="height: 22px;">
			<option value="addMoney">Add Money</option>
			<option value="removeMoney">Remove Money</option>
			<option value="doNothing">Do Nothing</option>
		</select>
	</div>
	<div class="required">
		<label for="random_<?=$value?>_<?=$x?>_argv">Arguments. (Amount, TranID)</label>
		<input type="text" name="random_<?=$value?>_<?=$x?>_argv" id="random_<?=$value?>_<?=$x?>_argv">
		<input type="text" name="random_<?=$value?>_<?=$x?>_argv2" id="random_<?=$value?>_<?=$x?>_argv2">
		<p>The Arguments will be placed here. <br/> <a>addMoney(Amount, 'TranID')</a> <br /> <a>removeMoney(Amount, 'TranID')</a> <br /><a>doNothing(NULL, NULL)</a></p>
	</div>
<?php
	}
?>
	</div>
	<div id="normalArg_<?=$x?>">
		<div class="required">
			<label for="<?=$x?>_argv">Arguments. (Amount, TranID)</label>
			<input type="text" name="<?=$x?>_argv" id="<?=$x?>_argv">
			<input type="text" name="<?=$x?>_argv2" id="<?=$x?>_argv2">
			<p>The Arguments will be placed here. <br/> <a>addMoney(Amount, 'TranID')</a> <br /> <a>removeMoney(Amount, 'TranID')</a><br /><a>doNothing(NULL, NULL)</a></p>
		</div>
	</div>
</fieldset>
<?php
} ?>
<fieldset>
	<input name="submit" type="submit" value="Submit!" class="inputSubmit" />
</fieldset>
</form>
