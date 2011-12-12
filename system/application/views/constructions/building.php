<div id="hospitalID" style="display:none"><?=$hospitalInfo["hospitalID"]?></div>
<?php 

$buildings = unserialize($hospital['unlock']);

$x = 0;
$y = 1;
foreach($category as $cat) {
?>	
<table class="table building_table">
	<thead>
		<tr class="header_th">
			<th colspan="3"><?=$cat["name"]?></th>
		</tr>
	</thead>
<?php
foreach($building[$cat["id"]] as $row) {

if(array_key_exists($row['id'], $buildings))
	{
	$cRes = unserialize($row['cost_resources']);
	?>
	<thead class="building_<?=$cat["name"]?>">
	<tr class="subheader_th" id="building_<?=$cat["id"]?>">
		
		<th colspan="3"><p style="font-size: 16px; margin: 0; padding: 0;">
	<?php
	// Echo name
	echo $row['name'];


	// Check how many buildings that already exists.
	//if($built[$row['id']] > 0)
	//{

	if($built[ $row[ "id" ] ] == "") $built[ $row[ "id"] ] = "0";

		echo "<span class='right_msg'><img src=\"/template/images/icons/shape_group.png\" alt='Rooms already existing' title='Rooms already builded' class='tipsyNorth' /><span  id='num_{$row[id]}'>{$built[$row[id]]}</span></span>";
	//}

	?></p>
			</th>
		</tr>	
	</thead>

	<tbody>
		<tr valign="top" class="<?php /* if($r == 1) { echo "row1"; $r = 0; } else { $r = 1; echo "row2"; } */ ?>">
			<td style="width: 83px; padding-right: 8px;"><img border='0' src="/template/images/buildings/<?=$row['image']?>" align='top'></td>
			<td align="left" style="width: 500px;"><?php echo nl2br($row['desc']); ?>
</td>
			<td align="left" style="width: 50px; padding-top: 15px;">

	<form action="/index.php/building/build_post/<?=$row['id']?>" method="post" class="ajaxBuildForm" style="width: 200px;">

	<input type="hidden" name="buildingID" value="<?=$row["id"]?>" />

	<label for="W_<?=$row['id']?>" style="display: block; width: 100px;">Width:</label>
	<select  name="W_<?=$row['id']?>" id="W_<?=$row['id']?>" style="position: absolute; margin-top: -19px; margin-left: 100px;" onchange="javascript: area_change(<?=$row['id']?>);">
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

	<label for="L_<?=$row['id']?>" style="display: block; width: 100px;">Length:</label>
	<select name="L_<?=$row['id']?>" id="L_<?=$row['id']?>" style="position: absolute; margin-top: -19px; margin-left: 100px;"  onchange="javascript: area_change(<?=$row['id']?>);">
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
	<b style="display: block;">Total area:</b>
	<span style="position: absolute; margin-top: -14px; margin-left: 100px;">
		<span class="building_div_select_total" id="T_<?=$row['id']?>">
		<?php

		$m = $hospitalInfo["hospitalID"];

		switch($m)
		{
			case "1": $multiplier = 1; break;
			case "2": $multiplier = 4; break;
			case "3": $multiplier = 16; break;
			case "4": $multiplier = 40; break;
			case "5": $multiplier = 90; break;
			default: $multiplier = 1; break;
		}

		$val = $cRes["Min Area Length"] * $cRes["Min Area Width"];
		echo $val;
		?>
		</span> m&#178;
	</span>
	<br />
	<b style="display: block;">Total price:</b>
	<span class="building_div_select_price" id="TP_<?=$row['id']?>" style="position: absolute; margin-top: -15px; margin-left: 100px;">
	<?php
		$val = $cRes["Min Area Length"] * $cRes["Min Area Width"] * $row['cost_money'] * $multiplier; 
		echo number_format($val); 
	?>
	</span>

	<hr />
	<div class="button" align="right" style="margin-left: -20px;">
	<input type="submit" name="mysubmit" class="inputSubmit" style="margin-left: -180px; width: 200px;" value="Build">  
	</div>


	</form>

<!-- Temporarily Placeholder for the real deal ;) -->
<div class="table_requirement">
	<ul>
		<li id="requirements">Requirements:</li>
		<li id="price"><img src="/template/images/icons/green-dollar-icon-32.png" /><span id="price_<?=$row[id]?>"><?=$row['cost_money']?></span></strong>/m&#178;</li>
<?php
$doctor = array(1,2,3,4,5,6,7,9); //,8,9,11,12,13,14,15,16,17,18,19);
$nurse = array(10,11);
$rec = array(24);
$jan = array(20, 22);
if(in_array($row["id"], $doctor)): ?>
		<li id="employee"><img src="/template/images/people/doctor-32.png"> <b>1</b> Doctor(s)</li>
<?php elseif(in_array($row["id"], $nurse)): ?>
		<li id="employee"><img src="/template/images/people/nurse-32.png"> <b>1</b> Nurse(s)</li>
<?php elseif(in_array($row["id"], $rec)): ?>
		<li id="employee"><img src="/template/images/people/receptionist-icon.png"> <b>1</b> Receptionist(s)</li>
<?php elseif(in_array($row["id"], $jan)): ?>
		<li id="employee"><img src="/template/images/people/Broom-icon.png"> <b>1</b> Janitor(s)</li>
<?php endif; ?>
	</ul>
</div>
<!-- End of Temporarily Placeholder -->

	</td>
		</tr>

<?php
/*
if(isset($buildingInfo[$row["id"]]))
{
	$c = $buildingInfo[$row["id"]];
	foreach($c as $key => $val)
	{
		echo "<div class=\"content_minibox\">";

		
		echo "<b>Room size:</b> {$val[area][total]}m&#178; <span style=\"width: 120px; display: block;\"></span>";


				echo "<a href='/index.php/building/delete_room/{$val[id]}'><img src=\"/template/images/icons/cancel.png\" style=\"float: right; margin-top: -15px; \" border='0' /></a>";
				echo "</div>";
			
		}
}
	*/
	}
		$x++;
		$y++;
	}

}

?>
</table>
