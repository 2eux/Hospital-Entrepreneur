<h2 style="margin-top: 10px;">Hire Employee</h2>
<p>Welcome to the national CV database. Here you can hire fresh nurses or experienced doctors to service at your Hospital. A employee may only be hired once and there are currently only <b><?=$num?></b> employees remaining. <br /><br /><!--<i><b>FIXME:</b> In the future it will be possible to transfer a employee between hospitals and even demand money to get him at your hospital</i></p>-->

<form action="/index.php/units/ajax/hireEmployee" method="post">

<table class="table" width="100%" id="hire">
<thead>
	<tr class="header">
		<th colspan="7">Hire Employees</th>
	</tr>
	<tr class="subheader">
		<th style="width: 16px; "></th>
		<th style="width: 32px;"></th>
		<th style="text-align: left;">Employee Name</th>
		<th style="text-align: center";>Type</th>
		<th style="text-align: center";>Salary</th>
		<th style="text-align: center";>Skill level</th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php

#print_r($employees_hired_id);
#if(count($employees) == 0) { $employees = array(); }
if(count($employees_hired_id) == 0) { $employees_hired_id = array(999999999999999999999999999999999999999999); }

$r = 1;

foreach($employees as $row)
{
if($r == 1) { $rowX = "row1"; $r = 0; } else { $rowX = "row2"; $r = 1; }
?>
	<tr class="<?=$rowX?>" id="employees_row_<?=$row[id]?>" <?php if(array_key_exists($row['id'],$employees_hired_id)) { echo "style=\"display: none\""; } ?>>
		<td><input type="checkbox" name="multipleHire[]" id="multipleHire[]" value="<?=$row[id]?>" /></td>
		<td><img src="/template/images/people/<?=$row[img]?>.png" width="32" height="32" border="0" alt="<?=$row[employeeType]?>" /></td>
		<td><?=$row['name']?></td>
		<td style="text-align: left; width: 120px;"><?=$row['employeeType']?></td>
		<td style="text-align: center"><?=$row['price']?></td>
		<td style="text-align: center"><?=$row['skill']?><div align="center"><table class="progress-bar-bg"><tr><td width="<?=$row['skill']?>%" class="progress-bar-front"></td><td></td></tr></table></div></td>
		<td style="text-align: center; width: 80px;"><input type="hidden" name="employeeID" value="<?=$row['id']?>" /><a href="/index.php/units/ajax/hireEmployee/<?=$row[id]?>" class="inputButton inputButtonIcon" style="padding-left: 30px; padding-right: 16px;"><img src="/template/images/icons/add.png" />Hire</a></td>
	</tr>
<?php
}
?>
</tbody>
</table>

<hr />

<input type="submit" value="Hire multiple employees" name="submitMany" id="submitMany" class="inputSubmit iconHire" style="margin-left: 32px" />

<p>Instead of to hire just one and one employee you may select multiple employees and click "Hire multiple employees" to hire all of those you selected.</p>

</form>