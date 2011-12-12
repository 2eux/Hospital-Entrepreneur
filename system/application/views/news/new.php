<ul class="adminlist">
	<li><img src="/template/images/icons/add.png" alt="New"><a href="/index.php/news/newArticle">New Article</a></li>
	<li><img src="/template/images/icons/page_white_stack.png" alt="List"><a href="/index.php/news/listArticle">List Articles</a></li>
</ul>

<br /><br />
<div class="form_update">
	<form action="/index.php/news/newArticlePOST" id="newsForm" method="POST" />
	<fieldset>
		<legend id="title_information">New News Article</legend>
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
<div style="display:none" id="article_view">
<h1 id="title"></h1>
<h2 id="sub_title" class="grey"></h2>
<ul class="authors">
	<li id="author">Author: <a href="/index.php/user/profile/<?=$news['author_id']?>"><?=$news['author']?></a></li>
	<li id="date"><i>Please load this article normally to display date</i></li>
</ul>

<div id="article"></div>

</div>
