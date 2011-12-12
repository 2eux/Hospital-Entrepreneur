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


<h1>Hire your first employee!</h1>
<p>You are starting to make progress now. Time to hire your first employee. To complete this tutorial you will have to hire the neccessary employees to let your hospital stay running.</p>
<br />
<h2>Nagivate</h2>
<img class="border right_align" src="/template/images/tutorial/step2/a.png" />
<p>To get to the place were you can hire employees you first have to go to the User Menu. Click <b>My Employees</b> and then <b>Hire Employees</b> (Standard Choice).
<p>If you can't find it, look at the image.</p>
<br />
<p>You should now be presented with a view similar to this:</p>
<img class="border" src="/template/images/tutorial/step2/b.png" />
<br />
<br />
<br /><br />
<h2>Hire your first employee</h2>
<p>You now have to hire your first employee. As stated in the text there are only a set amount of doctors at the market at any set time. This will change when people hires new employees and fire their old ones. Also new people come at the market every now and then.</p>
<p>Lets hire a doctor first of all. Click the "Hire" button next to a doctor you find sensible to hire for your Hospital.</p>
<p>Now that you have done that you'll be sent to the "Manage Employee" page, this is the page seen in the picture below.
<img class="border" src="/template/images/tutorial/step2/c.png" />
<p>Here you can Fire a employee or increase its salary. You can also monitor its working morale. A Employees working morale depends on the hospital, the rooms, the fellow employees, his or hers education and ofcourse the salary.</p>
<?php
//print_r($user_data);

$requirement = array("Doctor" => 3, "Nurse" => 1, "Janitor" => 1, "Receptionist" => 1);
$icon = array("Doctor" => "doctor-32.png", "Nurse" => "nurse-32.png", "Janitor" => "Broom-icon.png", "Receptionist" => "receptionist-icon.png");
?>
<br />
<h2>Requirement for stage completion</h2>
<p>Underneath is the requirement to complete this stage of the tutorial. Just click the "Getting Started!" item on the Menu to come back here to check your progress or to progress further!</p>
<ul id="unlock">
<?php foreach($requirement as $key => $need): if(!isset($user_data['employee'][$key])) { $user_data['employee'][$key] = 0; } ?>
	<li class="<?php if($user_data['employee'][$key] >= $need) { echo 'check'; } else { echo 'missing'; $missing = true; } ?>">
		<img src="/template/images/people/<?=$icon[$key]?>" />
		<b><?=$user_data['employee'][$key]?></b>/<b><?=$need?></b> <?=$key?>
	</li>
<?php endforeach; ?>
</ul>
<?php if(!isset($missing)): ?>
<br /><hr /><br />
<a href="/index.php/gettingstarted/complete/4" class="inputButton inputButtonIcon"><img src="/template/images/icons/accept.png" />Complete Stage 4</a>
</br /><br /><br /><br />
<?php endif; ?>
