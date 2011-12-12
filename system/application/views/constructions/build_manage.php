<form action="/index.php/building/delete_room_multiple" method="post">

<table class="table manageRoom">
<thead>
	<tr class="header">
		<th colspan="5">Current hospitals</th>
	</tr>
	<tr class="subheader">
		<th style="width: 10px;"></th>
		<th style="width: 16px;"></th>
		<th>Building type</th>
		<th>Building size</th>
		<th style="width: 16px;"></th>
	</tr>
</thead>
<tbody>
<?php

if(count($buildingInfo) == 0) {
	echo "<tr class='row1'><td colspan=5 style='text-align:center'><i>You have not builded any rooms yet.</i></td></tr>";
}
else
{

	$r = 1;
	foreach($buildingInfo as $z)
	{	
		foreach($z as $b)
		{


			if($r == 1) { $r = 0; $row = "row1"; } else { $r = 1; $row = "row2"; }
			echo "<tr class='{$row}'>
					<td><input type='checkbox' name='room[]' value='{$b[id]}' /></td>
					<td><img src=\"/template/images/buildings/{$b[icon]}\" width=32 /></td>
					<td>{$b[name]}</td>
					<td>{$b[area][total]} m&#178;</td>
					<td><a href=\"/index.php/building/delete_roomRq/{$b[id]}\"><img src=\"/template/images/icons/remove.png\" /></a></td>
				</tr>";
		}
	}
}
?>
</tbody>
</table>
<br />
<input type="submit" class="inputSubmit" value="Destruct all selected rooms" name="submit" id="submit" />
<br />
<br />
</form>