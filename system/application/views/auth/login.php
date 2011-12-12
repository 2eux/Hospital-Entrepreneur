<style type="text/css">
input[type=checkbox] {

}
div.required label {
	font-weight: normal !important;
}
form fieldset {
	border: 0;
}
form legend {
	text-align: center;
}
form {
	width: 500px;
	margin-left: auto;
	margin-right: auto;
}
</style>
<?php 

$CI =& get_instance();

#print_r($CI->db_session->flashdata());
#print_r($CI->db_session->flashData);

if(!empty($CI->db_session->flashData['AUTH_STATUS'])) {

				$output = $CI->db_session->flashData["AUTH_STATUS"];

				echo "<div class=\"ui-widget\">
					<div class=\"ui-state-error ui-corner-all\" style=\"padding: 0 .7em;\"> 
						<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: .3em;\"></span> 
						{$output}</p>
					</div>
				</div><br />";
}

 ?>
<form action="/index.php/auth/login" method="post"><fieldset><legend>Please Login or Register</legend>

<div class="required">

	<label for="user_name">User Name: 
	</label><input type="text" name="user_name" id="user_name" maxlength="30" size="30"  /></div>

    <span class="reg_error"></span>
<div class="required">
	<label for="">Password:
	</label><input type="password" name="password" id="password" maxlength="30" size="30"  /></div>

    <span class="reg_error"></span>
   
<div class="required">

     <label for="auto_login" class="labelCheckbox" style="margin-left: 70px">Auto Login:</label>
	     <input type="checkbox" name="auto_login" value="" id="auto_login" style="display: block; position: absolute; margin-top: -16px; margin-left: 140px;"  />
</div>

<br>

	</fieldset>
	<fieldset>
	<div class="submits">
	<input type="submit" name="login" value="Login" id="login" class="inputSubmit iconKey" />    
	<a href="/index.php/auth/forgotten_password" class='ui-state-default ui-corner-all button buttonIcon'><img src="/template/images/icons/key_go.png" alt="" />Forgotten Password?</a>
	<a href="/index.php/auth/register" class='ui-state-default ui-corner-all button buttonIcon'><img src="/template/images/icons/paste_plain.png" alt="" />Register</a>	</div>

</fieldset></form>

