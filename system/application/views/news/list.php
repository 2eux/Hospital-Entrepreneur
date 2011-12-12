<?php if($authLevel == "Admin") { ?>
<ul class="adminlist">
	<li><img src="/template/images/icons/add.png" alt="New"><a href="/index.php/news/newArticle">New Article</a></li>
	<li><img src="/template/images/icons/page_white_stack.png" alt="List"><a href="/index.php/news/listArticle">List Articles</a></li>
</ul>
<br /><br /><br />
<?php
}
foreach($info as $article)
{
?>
<div id="article_<?=$article['id']?>">
	<h2><a href="/index.php/news/read/<?=$article['id']?>" style="color: #000; text-decoration: none; "><?=$article['title']?></a></h2>
	<ul class="authors">
		<li id="author">Author: <a href="/index.php/user/profile/<?=$article['author_id']?>"><?=$article['author']?></a></li>
		<li id="date"><?php echo date("h:i:s d-m-Y", $article['publish']); ?></li>
	</ul>
	<p><?=$article['content_short']?></p>
	<a href="/index.php/news/read/<?=$article['id']?>" class="inputButton inputButtonIcon inputButtonFloatRight" style="margin-right: 20px;"><img src="/template/images/icons/page_white_go.png" />Read More</a>
	<?php if($authLevel == "Admin") { ?><a href="javascript: void(0);" onclick="deleteNewsArticle(<?=$article['id']?>)" class="inputButton inputButtonIcon inputButtonFloatRight" style="margin-right: 5px;"><img src="/template/images/icons/exclamation.png" />Delete</a><?php } ?>
	<br /><br />
</div>
<?php
}
?>
