<html>
<head><title>Creating trial account...</title></head>
<link rel='stylesheet'  href='/template/css/main.css' type='text/css' /> 
<body onLoad="document.forms['login'].submit();">
<div style="width: 600px; margin-left: auto; margin-right: auto"><br /><br /><?php if(isset($error)): ?>
<p>Error: <?=$error?></p>
<?php else: ?>
<h1>Please Wait...</h1><p>Please wait, your account is being created</p>
<form method="post" action="/index.php/auth/login" name="login"/>

<input type="hidden" name="user_name" value="<?=$reg["user_name"]?>" />


<input type="hidden" name="password" value="<?=$reg["chr"]?>" />

<p><input type="submit" name="pp_submit" value="Click here if you're not automatically redirected..."  /></p></form>
<?php endif; ?>
</div></body></html> 