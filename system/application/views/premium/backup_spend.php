<h1>Spend Premium Points</h1>
<p>Here you may spend Premium Points (or Pills) on features which can come handy when playing Hospital Entrepreneur</p>
<p>If you have no more Premium points you can <a href="/index.php/premium/buy">Buy more here</a></p>





<form action="/index.php/premium/spend_submit" method="post">
<table class="table" style="width: 400px; margin-left: auto; margin-right: auto; border: 1px solid #000;">
	<thead>
		<tr class="header">
			<th colspan=3>Spend Premium Points</th>
		</tr>
		<tr class="subheader">
			<th>What</th>
			<th>Cost in Pills</th>
			<th><!-- Radio Button --></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($feats as $f)
		{
		if($row == "row1") { $row = "row2"; } else { $row = "row1"; }
		echo "
		<tr class=\"{$row}\">
			<td>{$f[Title]}</td>
			<td>{$f[Value]}</td>
			<td><input type=\"radio\" name=\"premium\" value=\"{$f[InputID]}\" /></td>
		</tr>";
		}
	if($row == "row1") { $row = "row2"; } else { $row = "row1"; }
	echo "<tr class=\"{$row}\">";
?>	
		<td colspan=3 style="text-align: center"><input type="submit" class="inputSubmit" value="Purchase!"></td>
	</tr>
	</tbody>
</table>



<table class='premium_table'>
<thead>
<tr>
<th></th>
<th>Bronze</th>
<th>Silver</th>
<th>Gold</th>
</tr>
</thead>
<tbody>
<tr>
<td>Lowered Employee Salaries</td>
<td>5</td>
<td>10</th>
<td>12.5</th>
</tr>
<tr>
<td>Bank Interest</td>
<td>0.2%</td>
<td>0.4%</th>
<td>0.5%</th>
</tr>
<tr>
<td>Patients Cured/5 minutes</td>
<td>1.5</td>
<td>2</th>
<td>2.5</th>
</tr>
<tr>
<td>Stock Rate</td>
<td>10</td>
<td>25</th>
<td>50</th>
</tr>
<tr>
<td>Friends priviledges</td>
<td>Extra 20 friends</td>
<td>Extra 50 friends</th>
<td>Extra 100 friends + Block players</th>
</tr>
<tr>
<td>Other Extras</td>
<td>N/A</td>
<td>Adverts removed from all pages</th>
<td>Adverts removed from all pages</th>
</tr>
</tbody>
</table>
