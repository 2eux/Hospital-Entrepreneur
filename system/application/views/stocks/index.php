<?php if(empty($totalStocks)): $totalStocks = 0; endif; ?>
<h1>Current User Information</h1>
<p>Welcome to the stock market. Here you can purchase stocks. You may not own more then 200 000 stocks <br />in any company or a total of 1 000 000 stocks.</p>
<b>You currently have used: </b> <?=$totalStocks?> / 1 000 000 <br />

<table class="table">
<thead>
	<tr class="header">
		<th colspan="5">
			Top 10 stocks
		</th>
	</tr>
	<tr class="subheader">
		<th>Title</th>
		<th>Stock Value</th>
		<th style="text-align: center">Current number of stocks</th>
		<th style="text-align: center">Buy stocks</th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php
foreach($top10 as $stocks)
{
if ( $r == 1 ) { $r = 0; $row = "row2" ; } else { $row = "row1"; $r = 1; }
echo "<form action=\"/index.php/stocks/buy_stocks/{$stocks[id]}\"  class=\"ajaxForm\" id=\"form_{$stocks[id]}\" method=\"post\">
	<tr class='{$row}'>
		<td style=\"padding-left: 20px\"><a href='/index.php/user/profile/{$stocks[id]}'>{$stocks[user_alias]}</a></td>
		<td style=\"\">{$stocks[stockValue]}$</td>
		<td style=\" text-align: center;\"><span id=\"stocks_{$stocks[id]}\">{$user_stock[ $stocks[id] ] [ amount ]}</span></td>
		<td style=\" text-align: center;\"><input type='text' id='amount' name='amount' /><input type='hidden' name='price' value='{$stocks[stockValue]}' /></td>
		"; /* A Bit dirty fix but Whatever */ ?>
<td style="text-align: center"><input type="hidden" name="id" id="id" value="<?=$stocks['id']?>" /><input type='submit' class="inputSubmit button_purchase" name='Submit' value='Purchase' /><a href="javascript: void(0);" onclick="purchaseStocks(<?=$stocks[id]?>)" class="inputButton inputButtonIcon" style="margin-right: 5px; color: #FFF"><img src="/template/images/icons/chart_curve_add.png" />Purchase Stocks</a><input type="hidden" name="id" id="id" value="<?=$stocks['id']?>" /></td>
<?php echo "
	</tr>
</form>";
}
?>
</tbody>
</table>
