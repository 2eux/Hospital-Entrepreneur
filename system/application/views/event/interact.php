<br />
<h1 id="title"><?=$interact['title']?></h1>
<h2 id="sub_title" class="grey"><?=$interact['type']?></h2>
<ul class="authors">
	<li id="author">Author: <?php if($interact['fromuid'] !== "0") { echo "<a href=\"/index.php/user/profile/{$interact['fromuid']}\">{$interact['from']}</a>"; } else { echo "<a>{$interact[from]}</a>"; } ?></li>
	<li id="date"><?php echo date("h:i:s d-m-Y", $interact['time']); ?></li>
</ul>

<div id="article"><p><?=nl2br($interact['content'])?></p></div>

<?php

if($interact['action1'] !== "") { $action[1] = unserialize($interact['action1']); }
if($interact['action2'] !== "") { $action[2] = unserialize($interact['action2']); }
if($interact['action3'] !== "") { $action[3] = unserialize($interact['action3']); }
if($interact['action4'] !== "") { $action[4] = unserialize($interact['action4']); }

//var_dump($interact['action1']);

if(count($action) > 0 && $interact['read'] == '0') {


?>
<form>
<fieldset>
	<legend>Actions</legend>

	<div align="center" style="margin-top: 0px; margin-bottom: 10px;">
<?php
	foreach($action as $key => $button) { 

	if(!isset($button['icon'])) { $button['icon'] = $button['Icon']; }

	$exp = explode(".",$button['icon']);
	if(isset($exp[1]) && $exp[1] == "png")
	{
		$button['icon'] = $exp[0];
	}

?>

	

	<a href="/index.php/event/method/<?=$interact['id']?>/<?=$key?>" class="inputButton inputButtonIcon" style="margin-right: 5px;"><img src="/template/images/icons/<?=$button['icon']?>.png" border="0" style="border-width: 0; margin-top: 1px;" /><?=$button['Title']?><?=$button['title']?></a>
<?php } ?>
	</div>

</fieldset>
</form>

<?php
}
?>
