<h2 style="padding-top: 5px">Mailbox</h2>
<p>Welcome to your mailbox. Here you can send letters to fellow players or receive messages of great importance from the head of state.</p>

<a href="/index.php/mail/newMail" class="inputButton inputButtonIcon inputButtonFloatRight"><img src="/template/images/icons/email_add.png" />New Mail</a>

<table class="table">
<thead>
	<tr class="header">
		<th colspan="5">Inbox</th>
	</tr>
	<tr class="subheader">
		<th style="width: 16px;"></th>	
		<th>Title</th>
		<th>From</th>
		<th>Date of Arrival</th>
		<th></th>
	</tr>
</thead>
<tbody>
<?php
foreach($mail as $row)
{
if($i == 0) { $i = 1; $rowX = "row1"; } else { $rowX = "row2"; $i = 0; }
?>
	<tr class="<?=$rowX?> mail">
		<td><?php if($row['read'] == "1") { $emailImg = "email_open.png"; } else { $emailImg = "email.png"; } ?><img src="/template/images/icons/<?=$emailImg?>" alt="" /></td>
		<td><a href="/index.php/mail/read/<?=$row['id']?>"><?php if($row['read'] == "0") { echo "<b>{$row[title]}</b>"; } else { echo "{$row[title]}"; } ?></a></td>
		<td><?=$row['from'];?></td>
		<td><?php echo date("H:i:s d/m/Y", $row['time']); ?></td>
		<td style="width: 16px;"><a href="/index.php/mail/deleteMail/<?=$row['id']?>"><img src="/template/images/icons/remove.png" alt="X" /></a></td>
	</tr>
<?php
}
?>
</tbody>
</table>
