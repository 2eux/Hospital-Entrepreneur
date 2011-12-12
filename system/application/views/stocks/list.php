<?php if($totalStocks == "") { $totalStocks = 0; } ?>

<h2>My Stocks</h2>
<p>Welcome to the My Stocks Stock Exchanger window. Here you see your own stocks, how many you own in a hospital and their value.
<br /><br />
<b>You have currently used: </b> <?=$totalStocks?> / 1000000 <br />
<table class="table">
<thead>
	<tr class="header">
		<th colspan="6">
			Your Stocks
		</th>
	</tr>
	<tr class="subheader">
		<th>Title</th>
		<th>Stock Value</th>
		<th style="text-align: center">Current number of stocks</th>
		<th style="text-align: center">Total Value</th>
		<th style="text-align: center">Buy/Sell stocks</th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php

$num = count($user_stock);

if($user_stock > 0)
{

	foreach($user_stock as $stocks)
	{
	if ( $r == 1 ) { $r = 0; $row = "row2" ; } else { $row = "row1"; $r = 1; }
	$total = number_format( $stocks['stockValue'] * $user_stock[ $stocks['id'] ] [ 'amount' ] , 2, ',', ' ');

	echo "<form action=\"/index.php/stocks/buy_stocks/{$stocks[id]}\"  class=\"ajaxForm\" id=\"form_{$stocks[id]}\" method=\"post\">
		<tr class='{$row}' id='row_{$stocks[id]}'>
			<td style=\"padding-left: 20px\"><a href='/index.php/user/profile/{$stocks[id]}'>{$stocks[user_alias]}</a></td>
			<td style=\"text-align: center;\">{$stocks[stockValue]}$</td>
		
			<td style=\" text-align: center;\"><span id=\"stocks_{$stocks[id]}\">{$user_stock[ $stocks[id] ] [ amount ]}</span></td>
			<td style=\"text-align: center;\"><span id='stocks_value_{$stocks[id]}'>{$total}</span></td>
			<td style=\" text-align: center;\"><input type='text' id='amount' name='amount' /><input type='hidden' name='price' value='{$stocks[stockValue]}'/></td>"; /* Another dirty HotFix */ ?>
	<td style="text-align: center">
		<input type="hidden" name="id" id="id" value="<?=$stocks['id']?>" />
		<input type='submit' class="inputSubmit button_purchase" name='Sell' value='Sell' />
		<input type='submit' class="inputSubmit button_purchase" name='Submit' value='Purchase' />

		<a href="javascript: void(0);" onclick="purchaseStocks(<?=$stocks[id]?>)" class="inputButton inputButtonIcon" style="margin-right: 5px; color: #FFF"><img src="/template/images/icons/chart_curve_add.png" />Buy</a>
		<a href="javascript: void(0);" onclick="sellStocks(<?=$stocks[id]?>)" class="inputButton inputButtonIcon" style="margin-right: 5px; color: #FFF"><img src="/template/images/icons/chart_curve_delete.png" />Sell</a>

	</td>
	<?php
		echo "
		</tr>
	</form>";
	}

} else {
	echo "<tr class='row1'><td colspan=5 style='text-align: center'><i>You have not yet purchased any stocks</i></td></tr>";
}
?>
</tbody>
</table>
