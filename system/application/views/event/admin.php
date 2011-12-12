<br />
<h1>Events Management</h1>
<p>Welcome</p>
<p>Here you modify the events an user can have. The events are controlled at random by both the Employee and the Patient cronjob</p>


<div align="center">
	<ul style="list-style: none; color: #999;" align="center">
		<li style="display: inline; padding: 3px; text-align: center; width: 50%">Number of Events experienced by Users: <b><?=$event_sent_num?></b></li>
		<li style="display: inline; padding: 3px; text-align: center; width: 50%">Number of Event Messages: <b><?=$event_num?></b></li>
	</ul>
</div>

<br />

<table class="table">
	<thead>
		<tr class="header">
			<th colspan="8">Event Messages (Showing <?=$event_num?> in English)</th>
		</tr>

		<tr class="menu">
			<th colspan="8">
				<ul>
					<li class="text">Menu:</li>
					<li class="item-add"><a href="/index.php/event/admin_add">Add Item</a></li>
				</ul>
			</th>
		</tr>

		<tr class="subheader">
			<th></th><!-- Icon -->
			<th>Type:</th>
			<th>Title:</th>
			<th>From:</th>
			<th style="text-align: center">Actions:</th>
			<th></th><!-- Buttons -->
		</tr>



	</thead>

	<tbody>
<?php
	foreach($event as $row)
	{
		if($table_row == "row2") { $table_row = "row1"; } else { $table_row = "row2"; }
	?>
		<tr class="<?=$table_row?>">
			<td><img src="/template/images/icons/<?=$row['icon']?>.png" alt="error" /></td>
			<td><?=$row['type']?></td>
			<td><?=$row['title']?></td>
			<td><?=$row['from']?></td>
		<td style="padding-right: 0; margin-right: 0; text-align: center;">
		<div class="adminShowAction" style="display: none" id="action_<?=$row[id]?>">
			<pre style="font-size: 10px"><?php 
						for($x = 1; $x < 5; $x++)
						{
echo "-----------ACTION {$x}------\n";							
							$txt = unserialize($row["action{$x}"]);
							if(!empty($txt)) {			
								print_r($txt);
							}
							else
							{
echo "NO ACTION\n";
							}
						}
				?>
			</pre>
		</div>
		<div class="adminShowMessage" style="display: none" id="message_<?=$row[id]?>"><?=$row['content']?></div>
		<a href="javascript: void(0);" onclick="eventAdminShowAction(<?=$row[id]?>);" class="inputButton inputButtonIcon" style="margin-right: 5px; margin-top: 2px; margin-bottom: 2px; padding-top: 2px; padding-bottom: 2px;">
			<img src="/template/images/icons/script_code.png" />Show Actions</a>
		</td>
			<td>
				<a href="javascript: void(0);" onclick="eventAdminSendEvent(<?=$row[id]?>);" title="Send Event" class="tipsyNorth"><div style="display: none" id="content_<?=$row['id']?>"><?=$row['content']?></div><img src="/template/images/icons/email_go.png" border="0" style="border-width: 0; margin-top: 1px;" /></a>
				<a href="javascript: void(0);" onclick="eventAdminReadMessage(<?=$row[id]?>);" title="Read Message" class="tipsyNorth"><div style="display: none" id="content_<?=$row['id']?>"><?=$row['content']?></div><img src="/template/images/icons/email_open.png" border="0" style="border-width: 0; margin-top: 1px;" /></a>
				<a href="/index.php/event/admin_delete/<?=$row[id]?>" onclick="confirmDelete()" title="Delete Event" class="tipsyNorth"><img src="/template/images/icons/delete.png" border="0" /></a>
			</td>
		</tr>
<?php
}
?>
	</tbody>
</table>

<div id="event_form_send" style="width: 400px; display: none" title="Send Event to User">
<div class="ui-widget" id="event_form_send_error" style="display: none">
					<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
						<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
						<strong>Error:</strong>User does not exist</p>
					</div>
				</div>
<form>
	<fieldset>
		<legend>Event Variables</legend>
		
		<input type="hidden" name="event_id" id="event_id" />

		<div class="required">
		<label for="event_to">Send Event To:</label>
			<input name="event_to" id="event_to" />

		</div>
		<div class="required">
			<label for="all">All</label>
			<input type="checkbox" value="checked" id="all" name="all" onclick="disableEventTo()" />
		</div>
		<hr />
		<p>If this is powered by %USER_ALIAS% variables please fill in these values beneath:</p>
		<div class="required">
		<label for="fromUA">User Alias (From:)</label>
			<input name="fromUA" id="fromUA" />
		</div>

		<div class="required">
		<label for="fromUID">User ID (From:)</label>
			<input name="fromUID" id="fromUID" />
		</div>

	</fieldset>
</form>
</div>
