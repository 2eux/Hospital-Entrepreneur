<h1><?php $CI =& get_instance(); echo $CI->authlib->getUserName(); ?>'s Hospital</h1>
<?php
$alreadyUnlocked = unserialize($currentInfo["unlock"]);

$o = "<ul>";
foreach($alreadyUnlocked as $a)
{
	$o .= "<li>{$a}</li>";
}
$o .= "</ul>";

?>
<h2>Current Hospital</h2>

<table class="table">
<thead>
	<tr class="header">
		<th colspan="3"><?=$currentInfo["title"]?></th>
	</tr>
	<tr class="subheader">
		<th></th>
		<th>Information</th>
		<th>Already unlocked</th>
	</tr>
</thead>
<tbody>
	<tr valign="top" class="row1">
		<td style="width: 120px;" rowspan="2"><img border='0' src="/template/images/<?=$currentInfo[image]?>" align='top' width='120' height='120'></td>
		<td align="left">
			<?=$currentInfo["desc"]?><br />
		</td>
		<td align="left" style="width: 200px;" rowspan="2">
			<?=$o?>
		</td>
	
	</tr>

<tr class="row1">
<td valign="bottom">
	<div style="width: 200px; text-align: right; font-weight: bold;">Total Hospital Value:</div><div style="position:absolute; margin-top: -14px; margin-left: 210px;"><?=$hospitalWorth?></div> <br />
	<div style="width: 200px; text-align: right; font-weight: bold; margin-top: -10px;">Building area remaining:</div><div style="position: absolute; margin-top: -15px; margin-left: 210px;"><?=$hospitalInfo['hospitalArea']?> m&#179;</div>
</td>
</tr>

</tbody>
</table>
<?php if($hospitalID != 5) { ?> 
<br />
<hr>

<h2>Upgrade Hospital</h2>

<table class="table">
<thead>
	<tr class="header">
		<th colspan="3"><?=$upgradeInfo["title"]?></th>
	</tr>
	<tr class="subheader">
		<th></th>
		<th>Information</th>
		<th>Unlocks</th>
</thead>
<tbody>
	<tr valign="top" class="row1">
		<td style="width: 120px;" rowspan="2"><img border='0' src="/template/images/<?=$upgradeInfo[image]?>" align='top' width='120' height='120'></td>
		<td align="left">
			<?=$upgradeInfo["desc"]?><br />
			
		</td>
		<td align="left" style="width: 200px;" rowspan="2">
			<ul>			
			<?php
				$unlock 		 = unserialize($upgradeInfo["unlock"]);

				foreach($unlock as $key => $value)
					{
						if(!array_key_exists($key, $alreadyUnlocked))
							echo "<li>{$value}</li>\n";
					}
			?>
			</ul>
		</td>
	
	</tr>
<tr class="row1">
<td valign="bottom">
	<div style="width: 200px; text-align: right; font-weight: bold;">Price:</div><div style="position:absolute; margin-top: -14px; margin-left: 210px;"><?=$upgradeInfo['price']?></div> <br />
	<div style="width: 200px; text-align: right; font-weight: bold; margin-top: -10px;">Building Area:</div><div style="position: absolute; margin-top: -15px; margin-left: 210px;"><?=$upgradeInfo['Set Area']?> m&#179;</div>
<!--
Price: <strong><image src="/template/images/icons/money.png" /><?=$upgradeInfo["price"]?></strong> <br />
			Building area: <strong><image src="/template/images/icons/building.png" /> <?=$upgradeInfo["Set Area"]?> m&#179;</strong> -->		</td>
</tr>
</tbody>
</table>
<hr>

<div align="center">
<br />
<a href="/index.php/hospital/upgrade" class='ui-state-default ui-corner-all button'>Upgrade Hospital to <?=$upgradeInfo['title']?></a>
<br /><br />
</div>
<?php } ?>
