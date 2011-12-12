<h1>You've successfully purchased a Premium Upgrade</h1>
<p>You've successfully purchased the <b><?=$package_name?></b><br />Here are the details for the package you purchased:</b>

<table class="table" align="center" style="width: 400px">
	<thead>
		<tr class="header">
			<th colspan=2>Premium Package: <b><?=$package_name?></b></th>
		</tr>
		<tr class="subheader">
			<th style="width: 200px">Option:</th>
			<th style="width: 200px">Value:</th>
		</tr>
	</thead>

	<tbody>

		<tr>
			<td>Money Bonus:</td>
			<td><?=$money?></td>
		</tr>

		<tr>
			<td>Salary Payment:</td>
			<td><?=$upgrade["salaryPayment"]?></td>
		</tr>

		<tr>
			<td>Patients Cured Multiplier:</td>
			<td><?=$upgrade["ptsCuredMultiplier"]?></td>
		</tr>

		<tr>
			<td>Stock Value Multiplier:</td>
			<td><?=$upgrade["stkValueMultiplier"]?></td>
		</tr>

		<tr>
			<td>Premium Expiration Date:</td>
			<td><?php
					$date = $upgrade["premiumExpire"];
					$d = explode("-", $date);

					echo "{$d[2]}/{$d[1]}/{$d[0]}";

				?></td>
		</tr>
	</tbody>
</table>

<br />
<a href="/index.php" class="inputButton inputButtonIcon" style="margin-left: 300px;"><img src="/template/images/icons/arrow_right.png" />Click Here to go back to the overview</a>
<br /><br />
