<?php $CI =& get_instance(); if($CI->authlib->getSecurityRole() == "Admin") { ?>
<div class="adminmenu" >
	<ul class="admintools" align="right">
		<li class="top"><img src="/template/images/icons/page_white_wrench.png" /><a href="javascript: void(0);" onclick="showAdminMenu()">Admin Menu</a></li>
			<li><ul>
					<li><img src="/template/images/icons/pencil.png" alt="Edit"><a href="javascript: void(0);" onclick="editInfoPage()">Edit</a></li>
			</ul></li>
	</ul>
</div>
<br />
<div class="form_update" style="display: none;">
<h1 id="title_edit"><?php echo "{$info[Site_Title]}"; ?></h1>
<form action="/index.php/info/updateInfo" id="infoForm" method="POST" />
<fieldset>
	<legend id="title_information"></legend>

	Text on the Page:<br />
	<textarea name="textarea_information" id="textarea_information" style="width: 782px; height: 200px;"></textarea>
	<input type="hidden" name="pageID" id="pageID" value="<?=$info['id']?>" />
</fieldset>
<fieldset>
	<input type="submit" class="inputSubmitInactive" value="Please Click the Save Icon!" onclick="return false;" />
</fieldset>
</form>
</div>
<?php } ?>

<h1 id="title"><?php echo "{$info[Site_Title]}"; ?></h1>

<div id="information"><?=$info['Information']?></div>


