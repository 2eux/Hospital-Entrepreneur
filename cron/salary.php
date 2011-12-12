<?php

echo "\n *************************************** ";
echo "\n  Hospital entrepreneur v 1				 ";
echo "\n  	Cron script: Employee Salary Handler ";
echo "\n *************************************** ";
echo "\n";

include("inc/global.php");


$user = mysql_query("SELECT * FROM `user` WHERE DATE_SUB(NOW(), INTERVAL 100800 MINUTE) <= last_visit");
while($row = mysql_fetch_array($user))
{
	echo "* UserID: {$row[id]}\n";
	echo "* Salary Payment Percentage: {$row[salaryPayment]}\n";

	$query = mysql_query("SELECT * FROM `employees_hired` WHERE `uid` = '{$row[id]}'");
	$num = mysql_num_rows($query);
	
	echo "* Number of Employees: {$num}\n";

	if($num > 0) {
		while($result = mysql_fetch_array($query))
		{
			echo "** Employee Hire ID: {$result[id]} ; Salary: {$result[salary]}\n";

			$sum = $sum + $result['salary'];
		}
		echo "* Total Salary Payment: {$sum}\n";
		if($row["salaryPayment"] !== "100") {
			$calc = ($row["salaryPayment"] / 100) * $sum; 
			echo "*** Premium Member. New Salary: {$calc}\n";
			$sum = $calc;
			
		}
		
		$sum = ceil($sum);
		

		mysql_query("UPDATE `user` SET `money` = `money` - {$sum} WHERE `id` = '{$row[id]}");
		mysql_query("INSERT INTO `log_transactions` (`id`, `userid`, `transactionType`, `money`, `contentType`, `ReverseSQL`, `time`, `ip`) VALUES (NULL, '{$row[id]}', 'Remove', '{$sum}', '2', 'UPDATE `user` SET `money` = `money` + {$sum} WHERE `id` = {$row[id]}', '".time()."', '" . $_SERVER["REMOTE_ADDR"] . "');");

	}


	echo "------------------------------------------------------------------------------\n";
}

//sleep( 60 * 60 * 24 );
//}

echo "\n *************************************** ";
echo "\n  Hospital entrepreneur v 1				 ";
echo "\n  	Cron script: Daily work to do ";
echo "\n *************************************** ";
echo "\n";


/* Variables: */
$todaysStocks = ( mt_rand(20, 99) + mt_rand(102, 129) + mt_rand(10, 40) + mt_rand(90 , 120) ) / 4;
$todaysStocks = round( $todaysStocks );

$floatTS = $todaysStocks;
$StringTS = strval ( $todaysStocks);

mysql_query("UPDATE `settings` SET `value` = '{$StringTS}', `valueInt` = '{$floatTS}' WHERE `settings`.`name` = 'stockConstant';");
echo "*** Stocks Value updated to: {$todaysStocks} \n";

// Delete temporarily accounts
$num = mysql_query("SELECT * FROM `user` WHERE `trialExpire` != '' AND `trialExpire` <= '" . time() . "'");
$n = mysql_num_rows($num);

$user = mysql_query("DELETE FROM `user` WHERE `trialExpire` != '' AND `trialExpire` <= '" . time() . "'");
echo "** {$n} Trial Users Cleared\n";