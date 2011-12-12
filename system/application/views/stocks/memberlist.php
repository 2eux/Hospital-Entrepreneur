<table class="table">
	<thead>
		<tr class="header">
			<th colspan="5">Members list</th>
		</tr>
		<tr class="subheader">
			<th>Name</th>
			<th style="text-align: center">Stock Value</th>
		<th style="text-align: center">Current number of stocks</th>
		<th style="text-align: center">Buy stocks</th>
			<th>Purchase Button</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($member as $mem)
		{
			if($row == "row1") { $row = "row2"; } else { $row = "row1"; }
		?>
<form action="/index.php/stocks/buy_stocks/<?=$mem[id]?>" class="ajaxForm" id="form_<?=$mem[id]?>" method="post">
		<tr class="<?=$row?>" id="row_<?=$mem[id]?>">
			<td style="padding-left: 20px;"><a href="/index.php/user/profile/<?=$mem['id']?>"><?=$mem['user_alias']?></a></td>
			<td style="text-align: center"><?=$mem['stockValue']?></td>
			<td style="text-align: center"><span id="stocks_<?=$mem[id]?>"><?=$user_stock[$mem["id"]]["amount"]?></span></td>
			<td style="text-align: center"><input type='text' id='amount' name='amount' /><input type='hidden' name='price' value="<?=$mem['stockValue']?>" /></td>
			<td style="text-align: center"><input type="hidden" name="id" id="id" value="<?=$mem['id']?>" /><input type='submit' class="inputSubmit button_purchase" name='Submit' value='Purchase' /><a href="javascript: void(0);" onclick="purchaseStocks(<?=$mem[id]?>)" class="inputButton inputButtonIcon" style="margin-right: 5px; color: #FFF"><img src="/template/images/icons/chart_curve_add.png" />Purchase Stocks</a></td>
		</tr>
</form>
	<?php
		}
	?>
	</tbody>
</table>
