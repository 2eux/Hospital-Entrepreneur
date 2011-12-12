<style type="text/css">
	img.border { border: 1px dashed #0099cc; }
	img.right_align { float: right; margin: 10px; margin-top: 0; }
	ul.text14 li { font-size: 150%; }
ul#unlock {
	list-style-type: none;
	margin-left: -40px;
}
ul#unlock li {
	background-color: #f8f1c9;
	border: 1px solid #f2cf0d;
	padding: 5px;
	margin-bottom: 4px;
	-moz-border-radius: 5px;
	-webkit-borde-radius: 5px;
	margin-top: 20px;
	padding-left: 40px;
	width: 200px;
}
ul#unlock li.check {
	background-color: #f1f6ec;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #b0ce94;
}
ul#unlock li.missing {
	background-color: #fef1ec;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #cd0a0a;
} 
ul#unlock li img {
	position: absolute;
	margin-left: -35px;
	margin-top: -20px;
}
ul#unlock li#text {
	background-color: #FFF;
	font-size: 12px;
	border-width: 0;
	margin-top: 0;
	padding: 0;
	margin-bottom: -4px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
}
</style>


<h1>Upgrade your Hospital</h1>
<p>You have now almost completed the tutorial and its time to upgrade your Hospital. When you upgrade your Hospital the hospital gains access to additional rooms, employees and equipment. It costs a bit of money but it is worth it. First of all lets find it!</p>
<br />
<h2>Nagivate</h2>
<img class="border right_align" src="/template/images/tutorial/step3/a.png" />
<p>To upgrade your hospital all you got to do is to click "<b>My Hospital</b>".
<p>If you can't find it, look at the image.</p>
<br />
<p>You should now be presented with a view similar to this:</p>
<img class="border" src="/template/images/tutorial/step3/b.png" />
<p>Here you see the requirements to upgrade as well as what you gain from purchasing the upgrade. When you are ready click the "Upgrade Hospital" button.
<h2>Requirement for stage completion</h2>
<p>Underneath is the requirement to complete this stage of the tutorial. Just click the "Getting Started!" item on the Menu to come back here to check your progress or to progress further!</p>
<?php if($user_data["hospitalID"] > 1): $upgrade = "1"; else: $upgrade = "0"; endif; ?>
<ul id="unlock">
	<li class="<?php if($upgrade == '1') { echo 'check'; } else { echo 'missing'; $missing = true; } ?>">
		<img src="/template/images/icons/Hospital.png" />
		<b><?=$upgrade?></b>/<b>1</b> Upgrade Hospital
	</li>
</ul>
<?php if(!isset($missing)): ?>
<br /><hr /><br />
<a href="/index.php/gettingstarted/complete/5" class="inputButton inputButtonIcon"><img src="/template/images/icons/accept.png" />Complete Stage 5</a>
</br /><br /><br /><br />
<?php endif; ?>
