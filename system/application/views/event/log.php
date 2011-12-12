<h1>Event Report</h1>
<p>Here you see a full list of events sorted by the time.</p>
<hr />

<table class="table">
	<thead>
		<tr class="header">
			<th colspan="6">Event Report</th>
		</tr>
		<tr class="subheader">
			<th></th><!-- Icon -->
			<!--<th>Type</th> Maybe added later -->
			<th>Subject Title</th>
			<th>Time</th>
			<th>From</th>
			<th></th> <!-- Button >> Go to -->
		</tr>
	</thead>
	<tbody>
<?php
	foreach($events as $e) {
		if($row == "row1") { $row = "row2"; } else { $row = "row1"; }

	$exp = explode(".",$e['icon']);
	if(isset($exp[1]) && $exp[1] == "png")
	{
		$e['icon'] = $exp[0];
	}
?>
		<tr class="<?=$row?>">
			<td><img src="/template/images/icons/<?=$e[icon]?>.png" <?php if($e['read'] == '1') { echo "style='opacity: 0.4';"; } ?> /></td>
			<!--<td><?=$e['type']?></td>-->
			<td><a href="/index.php/event/interact/<?=$e[id]?>"><?=$e['title']?></a></td>
			<td><?php echo date("h:i:s d-m-Y", $e['time']); ?></td>
			<td><?php if($e['fromuid'] !== '0') { echo "<a href='/index.php/user/profile/{$e[fromuid]}'>{$e[from]}</a>"; } else { echo $e['from']; } ?></td>
			<td>	<a href="/index.php/event/interact/<?=$e[id]?>" class="inputButton inputButtonIcon inputButtonFloatRight" style="margin-right: 5px; color: #FFF"><img src="/template/images/icons/email_open.png" />Open</a></td>
		</tr>
<?php
	}
?>
</table>
