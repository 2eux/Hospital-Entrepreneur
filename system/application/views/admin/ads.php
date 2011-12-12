<pre>
<?php
	print_r($result);
?>
</pre>


<table class="table">
	<thead>
		<tr class="header">
			<th colspan=6>Advertising</th>
		</tr>
		<tr class="subheader">
			<th>ID#:</th>
			<th>Client:</th>
			<th>Advertising Spot:</th>
			<th>Image:</th>
			<th>Link:</th>
			<th>Expirey Date:</th>
		</tr>
	</thead>
	<tbody>
<?php

$row = "row2";

foreach($result as $result)
	{
	#if($row == "row1") { $row = "row2"; } else { $row = "row1"; }
		?>
		<tr class="<?=$row?>">
			<td><?=$result['id'];?></td>
			<td><?=$result['ClientName'];?></td>
			<td><?=$result['AdvertisingSpot'];?></td>
			<td><a href="<?=$result[imageSrc];?>"><?=$result["imageSrc"];?></a></td>
			<td><a><?=$result['href'];?></a></td>
			<td><?=$result['ExpireyDate'];?></td>
		</tr>
	<?php
	}

?>
	</tbody>
</table>
