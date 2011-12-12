<?php $CI =& get_instance(); if($CI->authlib->getSecurityRole() == "Admin") { ?>
<ul class="adminlist">
<li><img src="/template/images/icons/add.png" alt="New"><a href="/index.php/news/newArticle">New Article</a></li>
					<li><img src="/template/images/icons/pencil.png" alt="List"><a href="javascript: void(0);" onclick="editNewsPage();">Edit Article</a></li>
					<li><img src="/template/images/icons/page_white_stack.png" alt="List"><a href="/index.php/news/listArticle">List Articles</a></li>
</ul>
<br />
<div class="form_update" style="display: none">
<br />
<form action="/index.php/news/updateInfo" id="infoForm" method="POST" />
<fieldset>
	<legend id="title_information">Editing News Article</legend>
	<div class="required">
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" value="<?=$news['title']?>" style="width: 500px;">
	</div>

	<div class="required">
		<label for="author">Author Name:</label>
		<input type="text" name="author" id="author" value="<?=$news['author']?>" style="width: 500px;" />
	</div>
	
	<div class="required">
		<label for="author_id">Author ID:</label>
		<input type="text" name="author_id" id="author_id" value="<?=$news['author_id']?>" style="width: 500px;" />
	</div>

	<div class="required">
		<label for="content_short">Short Content:</label>
		<textarea name="content_short" id="content_short" style="letter-spacing: -1px; color: #999; font-size: 15pt;   line-height: 15pt; font-family: Georgia, Times, serif; font-weight: normal; margin: 0 0 5px 0; border-width: 1; width: 500px; height: 200px;"><?=$news['content_short']?></textarea>
	</div>

	<div class="required">
		<label for="textarea_information">Full Content:</label>
		<textarea name="textarea_information" id="textarea_information" style="width: 500px; height: 300px;"><?=$news['content_full']?></textarea>
		<input type="hidden" name="pageID" id="pageID" value="<?=$news['id']?>" />
	</div>
</fieldset>
<fieldset>
	<input type="submit" class="inputSubmitInactive" value="Please Click the Save Icon!" onclick="return false;" />
</fieldset>
</form>
</div>
<?php } ?>
<br />
<h1 id="title" style="border-bottom-width: 0;"><?=$news['title']?></h1>
<h2 id="sub_title" class="grey"><?=nl2br($news['content_short'])?></h2>
<ul class="authors">
	<li id="author">Author: <a href="/index.php/user/profile/<?=$news['author_id']?>"><?=$news['author']?></a></li>
	<li id="date"><?php echo date("h:i:s d-m-Y", $news['publish']); ?></li>
</ul>

<div id="article"><?=$news['content_full']?></div>

<hr />

<div id="comments">
	<h3><?=$comments["num"]?> comment<?php if($comments["num"] == 0 || $comments["num"] >= 2): echo "s"; endif; ?> on "<?=$news["title"]?>"</h3>
	<ol class="commentlist">

		<?php
			if($comments["num"] > 0):

			foreach($comments["c"] as $comment):
		?>
		<li class="comment <?php switch($comment["security_role_id"]): case "1": echo "byadmin"; break; default: echo "byuser"; break; endswitch; ?> comment-author-infcalle even thread-odd depth-1" id="comment-<?=$comment["id"]?>">
				<div id="div-comment-<?=$comment["id"]?>" class="comment-body">
				<div class="comment-author vcard">

		<img alt='' src='http://www.gravatar.com/avatar/<?php echo md5($comment["email"]) . "?d=" . urlencode("http://www.hospital-entrepreneur.com/template/images/images/ph_avitar.gif") . "&s=52";?>' class='avatar avatar-52 photo' height='52' width='52' />		<cite class="fn"><a href="/index.php/user/profile/<?=$comment["uid"]?>"><?=$comment["user_name"]?></a></cite><span class="says">(<?=$comment["user_alias"]?>) says:</span></div>

		<div class="comment-meta commentmetadata"><a href="http://www.hospital-entrepreneur.com/index.php/news/<?=$comment["newsID"]?>/#comment-<?=$comment["id"]?>"><?=date("d F, Y", $comment["time"]) . " at "  . date("H:i", $comment["time"])?></a></div>
		<p><?=nl2br($comment["content"])?></p>

				</div>
	</li>

		<?php
			endforeach;
	
			else:
		?>
		<li>No comments yet.</li>
		<?php

			endif;
		?>
	</ol>

	<div id="last-comment"></div>

<?php if($loggedin == 1): ?>

	<form method="post" action="/index.php/news/comment/<?=$news[id]?>">
	
		<fieldset>

			<legend>Comment on this article</legend>

			<?php if($hospitalInfo["is_trial"]): ?>

			<p class='restricted_text'>Restricted. Please <a href="/index.php/auth/temp_full">upgrade to a full account (it's free!)</a>

			<?php else: ?>

			<div class="required">

				<label for="comment">Comment:</label>
					<textarea name="comment" style="text-area: 11px;"></textarea>

			</div>

			<input type="submit" value="Comment" class="inputSubmit" style="margin-left: 143px; margin-top: 10px;" />

			<?php endif; ?>
		</fieldset>

	</form>

<?php endif; ?>

</div>