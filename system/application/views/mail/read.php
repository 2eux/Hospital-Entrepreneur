<!--
Another Easter Egg for those interrested in reading our code :)
We will possibly add this sort of nagivation style later on. However we have not yet decided
FIXME: Just to highlight it we add the FIXME tag
<div class="nav">
<a href="/index.php">Hospital Entrepreneur</a> &#187; <a href="/index.php/mail">My Mailbox</a> &#187; <a href="<?=$_SERVER['REQUEST_URI']?>">Reading <?=$mail['title']?></a>
</div>
<br />
-->
<?php if($mail['fromuid'] !== '0') { ?>
<a href="/index.php/mail/reply/<?=$mail[id]?>" class="inputButton inputButtonIcon inputButtonFloatRight"><img src="/template/images/icons/email_go.png" />Reply</a>
<?php } ?>
<a href="/index.php/mail/deleteMail/<?=$mail[id]?>" class="inputButton inputButtonIcon inputButtonFloatRight"><img src="/template/images/icons/email_delete.png" />Delete</a>

<br /><br /><br />
<h2 style="color: #000"><?=$mail['title']?></h2>
<ul class="authors">
	<li id="from">From: <?php if($mail['fromuid'] !== "0") { echo "<a href=\"/index.php/users/profile/{$mail['fromuid']}\">{$mail[from]}</a>"; } else { echo "{$mail[from]}"; } ?></li>
	<li id="date"><?php echo date("h:i:s d-m-Y", $mail['time']); ?></li>
</ul>

<p><?php echo nl2br($mail['content']); ?></p>

