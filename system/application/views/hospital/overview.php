<h2 style="padding-top: 5px;"><?php $CI =& get_instance(); echo $CI->authlib->getUserName(); ?>'s Hospital</h2>
<p>Welcome to the Hospital Upgrade Menu. Here you can upgrade your Hospital. When you upgrade your hospital the hospital unlocks new features. However it has its costs, this will become more expensive when you upgrade your Hospital and you will need to expand.</p>


<table class="HospitalOverView">
	<thead>
		<?=$menu_bar?>
	</thead>
	<tbody>
<!-- Requirements -->		
		<tr>
			<?=$td_phase_1?>
			<td>
				<ul>
					<li id="text">Current Hospital:</li>
					<li><img src="/template/images/icons/Hospital.png" /><b><?=$hospitalInfo['hospitalArea']?></b> m&#178;</li>
				</ul>
			</td>
<?php if($hospitalID != 5): ?>
			<td>
				<ul>
					<li id="text">Requirement:</li>
					<li class="<?=$requirementClass['Doctor']?>">
					<img src="/template/images/people/doctor-32.png" />
						<b><?=$employeesHired['Doctor']?></b>/<b><?=$requirement['Doctor']?></b> Doctors
					</li>
					<li class="<?=$requirementClass['Nurse']?>">
					<img src="/template/images/people/nurse-32.png" />
						<b><?=$employeesHired['Nurse']?></b>/<b><?=$requirement['Nurse']?></b> Nurses
					</li>
					<li class="<?=$requirementClass['Janitor']?>">
					<img src="/template/images/people/Broom-icon.png" />
						<b><?=$employeesHired['Janitor']?></b>/<b><?=$requirement['Janitor']?></b> Janitors
					</li>
					<li class="<?=$requirementClass['Receptionist']?>">
						<img src="/template/images/people/receptionist-icon.png" /><b><?=$employeesHired['Receptionist']?></b>/<b><?=$requirement['Receptionist']?></b> Receptionists
						</li>
					<li class="<?=$requirementClass['Room']?>"><img src="/template/images/icons/Hospital.png" /><b><?=$roomsBuilt?></b>/<b><?=$requirement["Room"]?></b> Rooms</li>
				</ul>
			</td>
<?php endif; ?>
			<?=$td_phase_2?>
		</tr>
<!-- Unlocks -->
<?php if($hospitalID != 5): ?>
		<tr>
			<?=$td_phase_1_upgrade?>

			<td>
				<ul id="unlock">
					<li id="text">Unlocks:</li>
					<li><img src="/template/images/icons/building_add.png" /><?=$upgradeInfo['Set Area']?> m&#179;</li>
					<?=$unlock?>
				</ul>
			</td>

			<?=$td_phase_2?>
		</tr>
<!-- Cost -->
		<tr id="border_bottom">
			<?=$td_phase_1_upgrade?>
			<td>
				<ul>
					<li id="text">Upgrade Price:</li>
					<li>
				<img src="/template/images/icons/green-dollar-icon-32.png" /><b><?=number_format($upgradeInfo["price"], 2, ',', ' ');?></b>
					</li>
				</ul>
			</td>
			<?=$td_phase_2?>
		</tr>
<?php if($disableUpgrade != "true"): ?>
<!-- Upgrade Button -->
		<tr>
			<?=$td_phase_1_upgrade?>
			<td><a href="/index.php/hospital/upgrade" class="inputButton" style="padding-left: 26px;"><img src="/template/images/icons/wrench_orange.png" style="position: absolute; margin-left: -20px; margin-top: -1px;" />Upgrade Hospital</a></th>
			<?=$td_phase_2?>
		</tr>
<?php endif; endif; ?>
	</tbody>
</table>
<br />
<br />
