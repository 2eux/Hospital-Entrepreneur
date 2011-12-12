				<style type="text/css">
select { height: 22px !important; width: 208px !important; }
</style>
<form action="/index.php/auth/temp_full" method="post"><fieldset>
<legend>Registration</legend>
<div class="required">
	<label for="user_name">User Name:</label>
	<input type="text" name="user_name" value="" id="user_name" maxlength="45" size="45" style="width: 200px;" value="<?=$reg["user_name"]?>"  />    <span class="reg_error"></span>
</div>

<div class="required">
	<label for="user_alias">Hospital Name:</label>
	<input type="text" name="user_alias" value="" id="user_alias" maxlength="45" size="45" style="width: 200px;" value="<?=$reg["user_alias"]?>"  /></div>

<div class="required">
	<label><span>Password: </span>
	</label><input type="password" name="password" value="" id="password" maxlength="16" size="16" style="width: 200px;"  />    <span class="reg_error"></span>
</div>
<div class="required">
    <label><span>Confirm Password: </span>

	</label><input type="password" name="password_confirm" value="" id="password_confirm" maxlength="16" size="16" style="width: 200px;"  />    <span class="reg_error"></span>
</div>
<div class="required">
    <label><span>Email: </span>
	</label><input type="text" name="email" value="" id="email" maxlength="120" size="60" style="width: 200px;"  />    <span class="reg_error"></span>
</div>

</fieldset>

<fieldset>

    <label>
	</label><input type="submit" name="register" value="Upgrade from Trial to Normal account" id="register" class="inputSubmit"  />
</fieldset>
</form>