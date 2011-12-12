<style type='text/css'>
.restricted_text { text-align: center; }
</style>
<form action="/index.php/user/editPOST" method="post" autocomplete="off">
<fieldset>
	<legend onclick="javascript: accordion('password');"><img class="password_img legend_image_right" src="/template/images/icons/add.png" />Password</legend>
	<div class="password_">
		<?php if($hospitalInfo["is_trial"] != 1): ?>
		<div class="optional">
		<label for="password">Password:</label>
			<input type="password" name="password" id="password" />
		</div>
		<div class="optional">
		<label for="password_repeat">Repeat Password:</label>
			<input type="password" name="password_repeat" id="password_repeat" />
		</div>
		<?php else: ?>
		<p class='restricted_text'>Restricted. Please <a href="/index.php/auth/temp_full">upgrade to a full account (it's free!)</a>
		<?php endif; ?>
	</div>
</fieldset>
<fieldset>
	<legend onclick="javascript: accordion('email');"><img class="password_img legend_image_right" src="/template/images/icons/add.png" />E-Mail Settings</legend>
	<div class="email_">
		
		<?php if($hospitalInfo["is_trial"] != 1): ?>

		<div class="optional">
		<label for="newsletter">Receive Newsletters:</label>
			<input type="checkbox" name="newsletter" id="newsletter" <?php if($result["newsletter"] == 1): echo 'checked="checked"'; endif; ?> value="1" />
		</div>
		
		<?php else: ?>
		<p class='restricted_text'>Restricted. Please <a href="/index.php/auth/temp_full">upgrade to a full account (it's free!)</a>
		<?php endif; ?>

	</div>
</fieldset>

<fieldset>
	<legend onclick="javascript: accordion('gui');"><img class="password_img legend_image_right" src="/template/images/icons/add.png" />User Interface Settings</legend>
	<div class="gui_">
		<div class="optional">
		<label for="newsletter">Show Notifications</label>
			<input type="checkbox" name="notifyDisabled" id="notifyDisabled" <?php if($result["notifyDisabled"] == 0): echo 'checked="checked"'; endif; ?> value='0' />
		</div>
	</div>
</fieldset>

<fieldset>
	<legend onclick="javascript: accordion('timezone');"><img class="timezone_img legend_image_right" src="/template/images/icons/add.png" />Timezone</legend>
	<div class="required timezone_">
<?php if($hospitalInfo["is_trial"] != 1): ?>
	<label for="timezone">Timezone:</label>
	<select name="timezone" id="timezone" style="height: 32px">
	<option value="<?=$result['timezone']?>">Current Timezone: GMT<?php if($result["timezone"] > 0) { echo "+"; } echo $result["timezone"]; ?></option>
	
      <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
      <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
      <option value="-10.0">(GMT -10:00) Hawaii</option>
      <option value="-9.0">(GMT -9:00) Alaska</option>
      <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
      <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
      <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
      <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
      <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
      <option value="-3.5">(GMT -3:30) Newfoundland</option>
      <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
      <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
      <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
      <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
      <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
      <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
      <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
      <option value="3.5">(GMT +3:30) Tehran</option>
      <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
      <option value="4.5">(GMT +4:30) Kabul</option>
      <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
      <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
      <option value="5.75">(GMT +5:45) Kathmandu</option>
      <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
      <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
      <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
      <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
      <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
      <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
      <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
      <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
</select>
		<?php else: ?>
		<p class='restricted_text' style="margin-left: 0px;">Restricted. Please <a href="/index.php/auth/temp_full">upgrade to a full account (it's free!)</a>
		<?php endif; ?>
	</div>
</fieldset>

<fieldset>
	<legend onclick="javascript: accordion('logo');"><img class="logo_img legend_image_right" src="/template/images/icons/add.png" />Logo & Avitar</legend>
	<div class="logo_">
		<?php if($hospitalInfo["is_trial"] != 1): ?>

		<div class="optional">
			<div class="notes"><h4>Important Information!</h4>Must be to either a Imageshack, Flicker or Tinypic Image and must end with <b>.jpg, .gif or .png</b></div>
			<label style="width: 300px; display: block">Hospital Logo (300x200):</label>
			<input type="text" value="<?=$result[avatar_link]?>" name="avatar_link" id="avatar_link" />
		</div>

		<div class="optional">
			<p>To select a user avatar use the free <a href="http://www.gravatar.com">Gravatar</a> service</p>
		</div>	

			<?php else: ?>
		<p class='restricted_text'>Restricted. Please <a href="/index.php/auth/temp_full">upgrade to a full account (it's free!)</a>
		<?php endif; ?>	
	</div>
</fieldset>
<?php
if($authLevel == "Admin")
{
?>
<fieldset>
	<legend onclick="javascript: accordion('admin');"><img class="admin_img legend_image_right" src="/template/images/icons/add.png" />Admin Values</legend>
	<div class="admin_">
		<div class="required">
		<label for="user_name">Username:</label>
			<input type="text" name="user_name" id="user_name" value="<?=$result['user_name'];?>" />
		</div>

		<input type="hidden" id="id" name="id" value="<?=$result['id']?>" />

		<div class="required">
		<label for="user_alias">Hospital Name:</label>
			<input type="text" id="user_alias" name="user_alias" value="<?=$result['user_alias'];?>" />
		</div>

		<div class="required">
		<label for="email">Email:</label>
			<input type="text" id="email" value="<?=$result['email'];?>" name="email" />
		</div>

		<div class="required">
		<label for="money">Money:</label>
			<input type="text" id="money" value="<?=$result['money'];?>" name="money" />
		</div>

		<div class="required">
		<label for="numPills">Number of Pills:</label>
			<input type="text" id="numPills" value="<?=$result['numPills'];?>" name="numPills" />
		</div>

		<div class="required">
		<label for="security_role_id">Security Level:</label>
			<input type="text" id="security_role_id" value="<?=$result['security_role_id']?>" name="security_role_id" />
		</div>

		<div class="required">
		<label for="activated">Activated:</label>
			<input type="text" id="activated" value="<?=$result['activated']?>" name="activated" />
		</div>

		<div class="required">
		<label for="activated">Tutorial Stage:</label>
			<input type="text" id="tutorialStage" value="<?=$result['tutorialStage']?>" name="tutorialStage" />
		</div>

		<div class="required">
		<label for="stocksRemaining">Stocks Remaining:</label>
			<input type="text" id="stocksRemaining" value="<?=$result['stocksRemaining'];?>" name="stocksRemaining" />
		</div>

		<div class="required">
		<label for="hospitalID">Hospital ID:</label>
			<input type="text" id="hospitalID" value="<?=$result['hospitalID']?>" name="hospitalID" />
		</div>

		<div class="required">
		<label for="hospitalArea">Hospital Area:</label>
			<input type="text" id="hospitalArea" value="<?=$result['hospitalArea']?>" name="hospitalArea" />
		</div>
	</div>

</fieldset>
<?php
}
?>
<fieldset>
	<input type="submit" name="submit" id="submit" class="inputSubmit" value="Update Profile!" />
</fieldset>
</form>
