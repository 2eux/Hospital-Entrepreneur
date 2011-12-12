<?php
	

		echo "<table>\n\t<tbody>";

		foreach($report as $report)
		{
			?>
		<tr>
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

		echo "</table>";
?>
