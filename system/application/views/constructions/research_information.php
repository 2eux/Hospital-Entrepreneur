<div style="padding: 5px;" align="center">
<?php foreach($research as $r) { ?>
<div style="width: 80%; text-align: right">
	<div style="padding: 5px; border: 1px solid #000; text-align: left">
		<b>TITLE:</b> <?=$r['name'];?> <br />
		<b>IMAGE:</b> <?=$r['image'];?> <br />
		<b>DESCRIPTION:</b><br/>
		<?=$r['desc'];?> <br />
		<b>BUILDTIME:</b><?=$r['buildtime'];?><br/>
		<b>COST RESOURCE:</b> <br />
		<?php $str = explode(';', $r['cost_resources']); foreach($str as $f) { echo $f . "<br />"; } ?>
		<b>COST MONEY:</b> <?=$r['cost_money'];?>
		<br /><br />
		<b>REQUIRED STUFF:</b> <br />
		<b>RESEARCH:</b> <?=$r['required_research'];?> <br />
		<b>BUILDING:</b> <?=$r['required_buildings'];?> <br />
		<b>ITEM:</b> <?=$r['itemid'];?> <br />
	</div>
	<?php
		if($researching == "true") { echo "Busy (Time remaining: ".$researchingEndTime.")"; }
		elseif($r['completed'] == "1") { echo "/RESEARCH/"; }
		
		else { echo "<a href=\"/index.php/research/investigate/{$r[id]}/\">[RESEARCH]</a>"; }
	?>
</div>
<?php } ?>
</div>
