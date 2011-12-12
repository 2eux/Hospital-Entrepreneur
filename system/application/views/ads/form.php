<form action="/index.php/admin/<?=$form?>" method="post">
<fieldset>
	<legend onclick="javascript: accordion('password');"><img class="password_img legend_image_right" src="/template/images/icons/add.png" />Advertising</legend>
	<div class="password_">
		<div class="required">
		<label for="ClientName">Client Name:</label>
			<input type="text" name="ClientName" id="ClientName" value="<?=$ClientName?>" />
		</div>

		<div class="required">
		<label for="AdvertisingSpot">Advertising Spot:</label>
			<input type="text" value="default_top" disabled="disabled" name="AdvertisingSpot" id="AdvertisingSpot" style="border: 1px solid transparent;" />
		</div>

		<div class="required">
		<label for="imageSrc">Image URL:</label>
			<input type="text" name="imageSrc" onchange="updateImage()" id="imageSrc" value="<?=$imageSrc?>" />
		</div>
		

		<img style="<?php if(strlen($imageSrc) == 0): ?>display: none;<?php endif; ?> border-width: 0;"  src="<?=$imageSrc?>" id="image_ads" />

		<div class="required">
		<label for="ExpireyDate">Expire Date:</label>
			<input type="text" name="ExpireyDate" id="ExpireyDate" value="<?=$ExpireyDate?>" />
		</div>
	</div>
</fieldset>
<fieldset>
	<input type="submit" name="submit" id="submit" class="inputSubmit" value="<?=$submitText?>" />
</fieldset>
</form>
