<h1>Premium Transaction Logs</h1>
<p>In the table beneath there is a complete log of all transactions to Hospital Entrepreneur. What you bought, when you bought it and how much it cost you.</p>
<p>If you see something is Processing then that means the Payment Verification is still pending. This may take 5-10 minutes if you pay by credit card or longer if you pay by Check</p>
<p>If you see that a Payment Error has happened please <a href="/index.php/info/contactus">Contact Us</a> to get it sorted out.</p>
<table class="table">
	<thead>
		<tr class="header">
			<th colspan=4>Transaction Log</th>
		</tr>
		<tr class="subheader">
			<th>Transaction Status</th>
			<th style="text-align: right">Items Purchased</th>
			<th style="text-align: center">Date of Purchase</th>
			<th style="text-align: center">Amount</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($transactions as $l)
	{
		if($r == 1) { $r = 0; $row = "row1"; } else { $row = "row2"; $r = 1; }	

		switch($l['TransactionStatus'])
		{
			case 'Completed':
				$status = "<img src='/template/images/icons/accept.png'><b> Completed</b>";
			break;
			case 'Error':
				$status = "<img src='/template/images/icons/delete.png'> <b>Error!</b>";
			break;
			case 'Processing':
				$status = "<img src='/template/images/icons/arrow_refresh.png'><i> Processing...</i>";
			break;
			default:
				$status = "<img src='/template/images/icons/arrow_refresh.png'><i> Processing...</i>";
			break;
		}

		if($l['Money'] > 0) { $purchase = number_format($l['Money'], 0, ',', ' ') . "<img src='/template/images/icons/money.png'>";	}
		elseif($l['Pills'] > 0) { $purchase = "{$l[Pills]} <img src='/template/images/icons/pill.png'>"; }
	
		$payPalIPN = unserialize($l['PayPalIPN']);
		$orig = unserialize($l['PayPalOutput']);

		#print_r($payPalIPN);

		if(isset($payPalIPN['mc_gross'])) { $amount = $payPalIPN['mc_gross'] . " " . $payPalIPN['mc_currency']; } else { $amount = $orig['mc_gross'] . " " . $orig['mc_currency']; }

		$time = date('d/m/Y H:i:s', $l['Time']);

		echo "
		<tr class=\"{$row}\">
			<td>{$status}</td>
			<td style='text-align: right'>{$purchase}</td>
			<td style='text-align: center'>{$time}</td>
			<td style='text-align: center'>{$amount}</td>
		</tr>";
	}
?>
	</tbody>
</table>
