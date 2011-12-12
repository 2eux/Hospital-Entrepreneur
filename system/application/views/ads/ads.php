<table class="table">
	<thead>
		<tr class="header">
			<th colspan=7>Advertising</th>
		</tr>
		<tr class="menu">
			<th colspan="8">
				<ul>
					<li class="text">Menu:</li>
					<li class="item-add"><a href="/index.php/admin/ads_add">Add Item</a></li>
				</ul>
			</th>
		</tr>
		<tr class="subheader">
			<th>ID#:</th>
			<th>Client:</th>
			<th>Advertising Spot:</th>
			<th>Image:</th>
			<th>Link:</th>
			<th>Expirey Date:</th>
			<th></th>
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

			<th>
				<a href="/index.php/admin/ads_edit/<?=$result[id]?>" title="Edit Ad" class="tipsyNorth"><div style="display: none" id="content_<?=$row['id']?>"><?=$row['content']?></div><img src="/template/images/icons/pencil.png" border="0" style="border-width: 0; margin-top: 1px;" /></a>
				<a href="/index.php/admin/ads_delete/<?=$result[id]?>" onclick="confirmAdsDelete('<?=$result[id]?>');" title="Delete Ad" class="tipsyNorth"><img src="/template/images/icons/delete.png" border="0" /></a>
				<!--<a href="/index.php/admin/ads_inactive/<?=$result[id]?>" title="Set Inactive" class="tipsyNorth"><img src="/template/images/icons/clock_stop.png" border="0" /></a>-->
			</th>

		</tr>
	<?php
	}

?>
	</tbody>
</table>
