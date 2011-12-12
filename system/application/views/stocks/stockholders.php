<h1>Stockholders</h1>
<p>Welcome to the Stockholders stock exchange window. Here you'll see a list of other companies owning stocks in your company.</p>
<table class="table">
<thead>
	<tr class="header">
		<th colspan="2">
			Stockholders
		</th>
	</tr>
	<tr class="subheader">
		<th>Title</th>
		<th style="text-align: center">Current number of stocks</th>
	</tr>
</thead>
<tbody>
<?php
foreach($stocks_result as $stocks)
{
if ( $r == 1 ) { $r = 0; $row = "row2" ; } else { $row = "row1"; $r = 1; }

$total = round ( $stocks['stockValue'] * $user_stock[ $stocks['id'] ] [ 'amount' ] ) . "$";

echo "
	<tr class='{$row}'>
		<td style=\"padding-left: 20px\"><a href='/index.php/user/profile/{$stocks[id]}'>{$stocks[user_alias]}</a></td>		
		<td style=\" text-align: center;\">{$stocks[amount]}</td>
	</tr>
</form>";
}
?>
</tbody>
</table>
