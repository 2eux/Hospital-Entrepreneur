<?php if($hospitalInfo["is_trial"] != 1): ?>
<form name="mail" method="post" action="/index.php/mail/sendMail">
<fieldset><legend>Send Mail</legend>
<div class="required">

<label for="mail_to">To:(case sensitive!)</label>
<input type="text" class="inputText" name="mail_to" id="mail_to" style="<?=$error_field['mail_to']?>" value="<?=$data['to']?>" />
</div>
<div class="required">
<label for="mail_title">Title:</label>
<input type="text" class="inputText" name="mail_title" id="mail_title" style="<?=$error_field['mail_title']?>" value="<?=$data['title']?>" />
</div>

        <label for="message" style="margin-left: 48px; font-weight: bold;">Your Message:</label>
        <textarea name="message" id="message" style="width: 600px; height: 300px; margin-left: 143px; margin-top: -10px; <?=$error_field['message']?>"><?=$data['message']?></textarea>




</fieldset>
<fieldset>
	<div class="submit">
		<input type="submit" name="submit" class="inputSubmit" value="&#187; Send &#187;" />
	</div>
</form>

		<?php else: ?>
		<p class='restricted_text' style="margin-left: 0px;">Restricted. Please <a href="/index.php/auth/temp_full">upgrade to full account</a>
		<?php endif; ?>