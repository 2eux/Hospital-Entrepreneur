<div class="content">
<?php 

$buildings = unserialize($hospital['unlock']);

$x = 0;
$y = 1;
foreach($category as $cat) {
echo "<h1>{$cat[name]}</h1>";
foreach($building[$cat["id"]] as $row) {

if(array_key_exists($row['id'], $buildings))
	{
	$cRes = unserialize($row['cost_resources']);
	?>
	<div class="content_box">
	<table border="0" width="100%" cellpadding="3" cellspacing="0" class="building_box">
		<tr>
			<td colspan="4"><h1>
	<?php
	// Echo name
	echo $row['name'];


	// Check how many buildings that already exists.
	if($built[$row['id']] > 0)
	{
		echo "({$built[$row[id]]} already exists)";
	}

	?>
	</h1>
	</div></td>
		</tr>	
		<tr valign="top">
			<td style="width: 120px;"><img border='0' src="/template/images/buildings/<?=$row['image']?>" align='top' width='120' height='120'></td>
			<td align="left"><?php echo nl2br($row['desc']); ?><br />Price: <strong><image src="/template/images/icons/coins.png" /><?=$row['cost_money']?></strong></td>
			<td align="left" style="width: 350px;">
			<strong>Statistics</strong><br />
			<strong>Total area covered by <?=$row['name']?>:</strong> 2000 <br />
			<strong>Enough employed doctors:</strong> Yes/No <br />
			<strong>Patients cured at <?=$row['name']?>: NUM
			</td>
			<td align="left" style="width: 120px;">

	<form action="/index.php/building/build_post/<?=$row['id']?>" method="post">

	<label for="W_<?=$row['id']?>" class="building_label">Width:</label>
	<select  name="W_<?=$row['id']?>" id="W_<?=$row['id']?>" class="building_div_select_width" onchange="javascript: area_change(<?=$row['id']?>);">
	<?php
	$min = $cRes["Min Area Width"];
	$max = $cRes["Max Area Width"] + 1;
	$num = $max - $min;

	for($x = $min; $x < $max; $x++)
	{
		echo "<option>{$x}</option>";
	}
	?>
	</select>

	<br />

	<label for="L_<?=$row['id']?>" class="building_label">Lenght:</label>
	<select name="L_<?=$row['id']?>" id="L_<?=$row['id']?>" class="building_div_select_lenght"  onchange="javascript: area_change(<?=$row['id']?>);">
	<?php
	$min = $cRes["Min Area Length"];
	$max = $cRes["Max Area Length"] + 1;
	$num = $max - $min;

	for($x = $min; $x < $max; $x++)
	{
		echo "<option>{$x}</option>";
	}
	?>
	</select>

	<br />
	<b>Total area:</b>
	<span class="building_div_select_total" id="T_<?=$row['id']?>">
	<?php
	echo $cRes["Min Area Length"] * $cRes["Min Area Width"];
	?>
	</span> m&#178;

	<br />
	<div class="button" align="center">
	<input type="submit" name="mysubmit" value="Build">  
	</div>

	</form>

	</td>
		</tr>
	</table>






	</div>
<?php
if(isset($buildingInfo[$row["id"]]))
{
	$c = $buildingInfo[$row["id"]];
	foreach($c as $key => $row)
	{
		echo "<div class=\"content_minibox\">";

		print_r($row);

		echo "<img src=\"/template/images/icons/cancel.png\" style=\"float: right; \" />";
		echo "</div>";
	}
}
?>

	<?php
	}
		$x++;
		$y++;
	}

}
?>
</div>
