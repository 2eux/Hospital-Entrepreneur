
<table border="0" cellspacing="5" cellpadding="4" align="center" style="width: 1024px;">
	<tr valign="top">
		<td style="width: 600px">
			<h1>It's completely free!</h1>
			<p>Another feature about this game is that it is absolutely free! You do not have to pay any subscription fee. (Like World of Warcraft)</p>

			<br />
<h1>No downloads required!</h1>
			<p>The game is completely based in a web browser, there is no requirement for you to download anything to play the game what-so-ever. (Except a web browser ofcourse, but since your viewing this page, I'm just going to assume you already have that)</p>

			<br />

		</td>
<td class="front_box front_box_news">
			<h1>Latest News</h1>
			<ul>
<?php

foreach($latestNews as $row)
{
	echo "<li><a href=\"/index.php/news/read/{$row[id]}\">{$row[title]}</a></li>\n";
}
?>
			</ul>
			<br />
			<a href="/index.php/news/list">More news</a>
		</td>

	</tr>


</table>
<?php /*
<table border="0" cellspacing="5" cellpadding="4" align="center">
	<tr valign="top">
		<td class="front_box front_box_news">
			<h1>Latest News</h1>
			<ul>
<?php

foreach($latestNews as $row)
{
	echo "<li><a href=\"/index.php/news/read/{$row[id]}\">{$row[title]}</a></li>\n";
}
?>
			</ul>
			<br />
			<a href="/index.php/news/list">More news</a>
		</td>
		<td class="front_box front_box_forum">
			<h1>Latest Event</h1>
			<ul>
<?php foreach($latestEvents as $event):	?>
			<li>
				<img src="/template/images/icons/<?=$event['icon']?>.png">
				<span class='topic_header'><a><?=$event['title']?></a></span>
				<span class='topic_forum'><a><?php echo date("h:i:s d-m-Y", $event['time']); ?></a></span>
			</li>
	<?php endforeach; ?>
			</ul>
			<br />
		</td>
		<td class="front_box front_box_top5">
			<h1>Top 5 Hospitals</h1>
			<ul>
<?php
foreach($top5 as $row)
{
	echo "<li><a href=\"/index.php/highschore/show/{$row[userID]}\">{$row[user_alias]}</a></li>\n";
}
?>
			</ul>
			<br />
			<!--<a href="/index.php/highscore/list">Top hospitals in Hospital Entrepeneur</a>-->
		</td>
	</tr>
</table> */ ?>
