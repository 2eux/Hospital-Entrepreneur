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


<h1>Build your first room!</h1>
<p>Alright, now you've understood how the game UI functions. Lets take it a step further and build the neccessary rooms to make the Hospital function.</p>
<p>This tutorial will help you through the stage of building a GP's Office. However to complete this tutorial you will have to build the rooms stated later in this tutorial.</p>
<br />
<h2>Nagivate</h2>
<img class="border right_align" src="/template/images/tutorial/step1/a.png" />
<p>To get to the place were you can build rooms you first have to go to the User Menu. Click <b>Room Designer</b> and then <b>Add Room</b> (Standard Choice).
<p>If you can't find it, look at the image.</p>
<br />
<p>You should now be presented with a view similar to this:</p>
<img class="border" src="/template/images/tutorial/step1/b.png" />
<p>The user interface is pretty simple, you have each of the rooms divided into categories: <b>Diagnosis, Treatment, Clinics</b> and <b>Facilities</b>.</p>
<hr />
<p><b>Diagnosis</b> is the rooms that all patients starts to go through. Here experienced doctors will find out whats wrong with that unique patient and suggest the <i>treatment</i> or <i>clinic</i> that he or she has to proceed to.</p>
<p><b>Treatment</b> is what solves most of the patients problems by operation or through pills</p>
<p><b>Clinics</b> are for those with a decease that needs further research or has an issue that requires a treatment through specialized equipment. This is the category with most rooms and each of them are vital to cure all possible deceases.</p>
<p><b>Facilities</b> are rooms, objects or places that are necessary for the welfare of your patients and employees. This category features essential items such as the staff room and toilets. </p>
<hr />

<br />
<br />
<br /><br />
<h2>Build your first room</h2>
<p>You now have to build your first room. First of all lets take a look at the requirements for a GP's Office.</p>
<img class="border" src="/template/images/tutorial/step1/d.png" />
<p>Okay, 2500$ per squared meter and we need one doctor. We will sort the doctor out later.</p>
<p>Lets build then. Change the length to 5 and width to 5. The best is to try and <b>keep the room as large as possible because a larger rooms will make the employees more happy.</b> However, you should not make them too large because many rooms brings lots of profit. For this example set length to 5 and width to 5.</p>
<img class="border" src="/template/images/tutorial/step1/c.png" />
<p>Now click Build!<p>
<p>When you've completed that the room is built.<p>
<?php
$requirement = array("1" => 2, "2" => 1, "11" => 1, "20" => 1, "22" => 2, "24" => 1);
$name = array("1" => "GP's Office", "2" => "Generals Diagnosis", "11" => "Pharmacy", "20" => "Staff Room", "22" => "Toilets", "24" => "Reception");
?>
<br />
<h2>Requirement for stage completion</h2>
<p>Underneath is the requirement to complete this stage of the tutorial. Just click the "Getting Started!" item on the Menu to come back here to check your progress or to progress further!</p>
<ul id="unlock">
<?php foreach($requirement as $key => $need): if(!isset($user_data['building'][$key])) { $user_data['building'][$key] = 0; } ?>
	<li class="<?php if($user_data['building'][$key] >= $need) { echo 'check'; } else { echo 'missing'; $missing = true; } ?>">
		<img src="/template/images/icons/Hospital.png" />
		<b><?=$user_data['building'][$key]?></b>/<b><?=$need?></b> <?=$name[$key]?>
	</li>
<?php endforeach; ?>
</ul>
<?php if(!isset($missing)): ?>
<br /><hr /><br />
<a href="/index.php/gettingstarted/complete/3" class="inputButton inputButtonIcon"><img src="/template/images/icons/accept.png" />Complete Stage 3</a>
</br /><br /><br /><br />
<?php endif; ?>
