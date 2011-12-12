<h2 style="margin-top: 10px;">Hired Employees</h2>
<p>Welcome to your Employee Management Panel! <br/> Here you can access vital information about your employees such as their working morale (e.g. How motivated they are to work at your Hospital), their level of Skill in their particilar area of knowledge, their salary and ofcourse their name.</p>
<!--<h3>Information about your Employees</h3>
<ul>
	<li>You currently have: X employees</li>
	<li>Your Employee/Hospital Ratio is: 6.22</li>
</ul>-->

<table class="table">
<thead>
	<tr class="header">
		<th colspan="10">Hired Employees</th>
	</tr>
	<tr class="subheader">
		<th style="width: 32px;"></th>
		<th style="text-align: left; width: 200px;">Employee Name</th>
		<th style="width: 85px;">Type</th>
		<th style="text-align: center;">Salary</th>
		<th style="text-align: center;width: 85px;">Working Morale</th>
		<!--<th>Tiredness</th>-->
		<th style="text-align: center;">Skill</th>
		<th><!-- Increase salary --></th>
		<!--<th> Give Bonus </th>-->
		<th><!-- Fire --></th>
	</tr>
</thead>
<tbody>
<?php
$i = 1;

$r = 1;

foreach($employees_hired as $row)
{
if($row['tiredness'] == 0) { $row['tiredness'] = 1; }
$employees_hired_id[$row['eid']] = true;

if($r == 1) { $rowX = "row1"; $r = 0; } else { $rowX = "row2"; $r = 1; }

?>
	<tr id="employed_row_<?=$row['id']?>" class="<?=$rowX?>">
		<td><img src="/template/images/people/<?=$row[img]?>.png" width="32" height="32" border="0" alt="<?=$row[employeeType]?>" /></td>
		<td  style="text-align: left;"><?=$row['name']?></td>
		<td><?=$row['type']?>
		<td style="text-align: center; "><span id="salary_<?=$row['id']?>" ><?=$row['salary']?></span> <img src="/template/images/icons/money.png"></td>
		

		<?php
			if($row['enabled'] == "No")
			{
				echo '<td colspan="6" style="text-align: center"><i>Employee is currently in the Staff Room</i><br /><i>Time Remaining: <b>~'.($row['inRestroom']*60).' Minutes</b></i></td>';
			}
			else
			{
		?>
		<td width="15%" style="text-align: center;  width: 50px;"><?=$row['happyness']?>%</td>
		<td width="15%" style="text-align:center; width: 50px;"><?=$row['skill']?></td>
		<td style="width: 16px;"><form action="/index.php/units/ajax/increaseSalary" method="post"><input type="hidden" name="employeeID" value="<?=$row['id']?>" /><input type="submit" value="Incease Salary" class="inputSubmit" /></form></td>
		<td style="width: 16px;"><form action="/index.php/units/ajax/fireEmployee" method="post"><input type="hidden" name="employeeID" value="<?=$row['id']?>" /><input type="submit" value="Fire!" class="inputSubmit" /></form></td>
		<?php
			}
		?>
	</tr>
<?php
$i++;
}
?>
</tbody>
</table> 
