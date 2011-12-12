<?php

echo "\n *************************************** ";
echo "\n Hospital entrepreneur v 1				";
echo "\n  	Cron script: Patient Handler		";
echo "\n *************************************** ";
echo "\n";

include("inc/global.php");


	$x = 1;
	echo "-----------------------------\n";	

	// Select all data from the users table from users that have been active the last 7 days
	$_query["user"] = mysql_query("SELECT * FROM `user` WHERE DATE_SUB(NOW(), INTERVAL 44640 MINUTE) <= last_visit");
	// For each of those users run this script	
	while($row = mysql_fetch_array($_query["user"]))
	{

		$effi = 0;

		$_query["buildings"] = mysql_query("SELECT * FROM `buildings_built` WHERE `uid` = '{$row[id]}'");

		echo " [".date("H:i:s")."] DB Query: Loading data from userID $row[id]\n";
		
		$_query["employees"] = mysql_query("SELECT * FROM `employees_hired` WHERE `uid` = '{$row[id]}' AND `Type` = 'Doctor' OR `Type` = 'Nurse' AND `inRestroom` = '0' AND `tiredness` > 0");
		while($result = mysql_fetch_array($_query["employees"]))
		{
			$formulae = $result['skill'] * 1 / 3 * $result['tiredness'] * 0.0008;

			$effi = $effi + $formulae;
		}

		echo " [".date("H:i:s")."] Employee Efficiency level: {$effi} (".mysql_num_rows($_query['employees'])." Doctor/Nurses Hired) \n"; 


		while($table = mysql_fetch_array($_query["buildings"]))
		{


			$size = $size + $table['areaOccupied'];


			$patientsIncreased	= ceil($patientsIncreased + $table["patientsCured"]);
			$moneyEarned 		= ceil($moneyEarned + ($table["patientsCost"] * $table["patientsCured"])) + 40;
		}

		echo " [".date("H:i:s")."] Hospital size: {$size}m^2 (".mysql_num_rows($_query['buildings'])." rooms) \n"; 
	
		$totalEff = $effi / $size * 50;

		echo " [".date("H:i:s")."] Total Employee Efficiency: {$totalEff} \n"; 

		$moneyEarned = ceil( ($moneyEarned * $totalEff) / 6);
		$patientsIncreased = ceil( ( $patientsIncreased * $totalEff ) / 6);

		//
		echo " [".date("H:i:s")."] ";
		$random = rand(1,3);
		echo "Random Value: {$random} ; ";
		
		echo "User Patient Multiplier: {$row[ptsCuredMultiplier]}\n";
		$moneyEarned = ceil($moneyEarned * $row["ptsCuredMultiplier"]);
		$patientsIncreased = ceil($patientsIncreased * $row["ptsCuredMultiplier"]);

		if(($patientsIncreased !== 0 || $moneyEarned !== 0) && $random == 1)
		{
			echo " [".date("H:i:s")."] RESULT: Increase money with: {$moneyEarned}\n";
			echo " [".date("H:i:s")."] RESULT: Increase patients with: {$patientsIncreased}\n";
			// Update DB			
			echo " [".date("H:i:s")."] DB Query: Updating DB....\n";

			mysql_query("INSERT INTO `log_transactions` (`id`, `userid`, `transactionType`, `money`, `contentType`, `ReverseSQL`, `time`, `ip`) VALUES (NULL, '{$row[id]}', 'Add', '{$moneyEarned}', '1', 'UPDATE `user` SET `money` = `money` - {$moneyEarned}, `patientsCured` = `patientsCured` - {$patientsIncreased} WHERE `id` = {$row[id]}', '".time()."', '" . $_SERVER["REMOTE_ADDR"] . "');");

			if(mysql_query("UPDATE `user` SET `money` = `money` + {$moneyEarned}, `patientsCured` = `patientsCured` + {$patientsIncreased} WHERE `id` = '{$row[id]}'"))
			{
				echo " [".date("H:i:s")."] DB Query: Successfully updated the users table \n";	
			}
			else
			{
				echo " [".date("H:i:s")."] DB Query: ERROR : " . mysql_error() . "\n";
				system("echo \" [".date("H:i:s d-m-Y")."] ".mysql_error()."\n\" > log_patient.txt");
			}
			// Random event generator
			$random = mt_rand(0, 100);
			if($random > 12 && $random < 24) { 
				echo " [".date("H:i:s")."] RANDOM EVENT: Decrease patients with a random num between 0.1 and 0.3\n"; 
			}
			elseif($random > 40 && $random < 46) {
				echo " [".date("H:i:s")."] RANDOM EVENT: Increase pills\n"; 
				mysql_query("UPDATE `user` SET `numPills` = `numPills` + 3 WHERE `id` = '{$row[id]}'");
			}
			elseif($random > 63 && $random < 74) { 
				echo " [".date("H:i:s")."] RANDOM EVENT: Increase patients with a random number between 0.1 and 0.3\n"; 
			}
			elseif($random > 82 && $random < 88) { 
				echo " [".date("H:i:s")."] RANDOM EVENT: Increase Hospital Area\n"; 
				mysql_query("UPDATE `user` SET `numPills` = `hospitalArea` + 1 WHERE `id` = '{$row[id]}'");
			}
			elseif($random > 94 && $random < 99) { 
				echo " [".date("H:i:s")."] RANDOM EVENT: Give the player a free employee (Doctor, Nurse)\n"; 
			}	
			
		}
		echo "\n";

		mysql_query("UPDATE `employees_hired` SET `inRestroom` = '0' WHERE `timeRestroom` < '". (time()+300) ."';");
			
	}
