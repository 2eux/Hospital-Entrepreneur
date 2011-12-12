<br />
<h1>Administration Panel</h1>
<h2 class="grey">Welcome <?php $CI = &get_instance(); echo $CI->authlib->getUserName(); ?> to Hospital Entrepreneur Administration Panel</h2>
<p>Here you get quick access to some of the administration tools, as well as a help guide with being an Administrator / Moderator at Hospital Entrepreneur.</p>
<br />

<table class="table">
	<thead>
		<tr class="header">
			<th colspan=7>Administration Log (Showing 20 entries)</th>
		</tr>
		<tr class="subheader">
			<th>ID#</th>
			<th>Module</th>
			<th>Action</th>
			<th>Content</th>
			<th>Administrator</th>
			<th>Date</th>
			<th>Data</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($log as $report)
	{
		if($row == "row1") { $row = "row2"; } else { $row = "row1"; }
?>
		<tr class="<?=$row?>">
			<td><?=$report['id']?></td>
			<td><?php echo ucfirst($report['module']); ?></td>
			<td><?php echo ucfirst($report['action']); ?></td>
			<td><?=$report['content']?></td>
			<td><a href="/index.php/user/profile/<?=$report['adminID']?>"><?=$report['user_name']?></a></td>
			<td><?php echo date("h:i:s d-m-Y", $report['time']); ?></td>
			<td><a href="javascript: void(0);" onclick="showAdminLog(<?=$report[id]?>);">Show Report</a><div id="AdminLog_<?=$report[id]?>" style="display: none"><?php $string = unserialize($report['debug']); echo "<pre>"; print_r($string); echo "</pre>"; ?></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
