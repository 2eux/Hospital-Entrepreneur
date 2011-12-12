<?php

echo "\n *************************************** ";
echo "\n  Hospital entrepreneur v 1				 ";
echo "\n  	Cron script: Events Handler ";
echo "\n *************************************** ";
echo "\n";

include("inc/global.php");
include("event/eventTemplates.php");

$user = mysql_query("SELECT * FROM `user` WHERE DATE_SUB(NOW(), INTERVAL 15 MINUTE) <= last_visit");
while($row = mysql_fetch_array($user))
{
	$userID		= $row["id"];
	$hospitalID	= $row["hospitalID"];
	$username	= $row["user_name"];
	$useralias	= $row["user_alias"];
	echo "* UserID: $userID\n";
	echo "* HospitalID: $hospitalID\n";

	$query = mysql_query("SELECT id, user_name, user_alias FROM `user` WHERE `id` != {$userID} LIMIT 20");
	while($result = mysql_fetch_array($query))
	{
		$random_user[] = $result;
	}

	$numRandomUser = count($random_user);
	echo "** Random Users List: {$numRandomUser}\n";
	$randomUserNum = rand(0, ($numRandomUser - 1));
	echo "** Random User ID: {$randomUserNum}\n";


	/*
	// Strings that needs to be replaced:
	// USER_NAME 	: Username
	// USER_ALIAS	: Hospital Name
	// UID		: UserID
	// MONEY:	: Random Amount between 10000 and 20000 * HospitalID
	// PATIENT	: 1

	// RANDOM_USER	: Random Username
	// RANDOM_USER_ID: Random Username's ID

	// DOCTOR:	: Random Doctor. If this happens then set happyness to 5
	*/

	switch($hospitalID) 
	{
		case "1": $hospital_multiplier = 0.75; 	break;
		case "2": $hospital_multiplier = 1.75;	break;
		case "3": $hospital_multiplier = 5;	break;
		case "4": $hospital_multiplier = 9;	break;
		case "5": $hospital_multiplier = 16;	break;
	}

	$data["USER_NAME"]	=	$username;
	$data["USER_ALIAS"]	=	$useralias;
	$data["UID"]		=	$userID;
	$data["MONEY"]		=	round( (rand(10000,20000) * $hospital_multiplier) , -2);
	$data["PATIENT"]	=	1;

	$data["RANDOM_USER"]	=	$random_user[$randomUserNum]["user_name"];
	$data["RANDOM_USER_ID"]	=	$random_user[$randomUserNum]["id"];
	$data["RANDOM_USER_ALIAS"] =	$random_user[$randomUserNum]["user_alias"];

	$template = $templates;
	$num = count($template);
	
	$event = rand(0, ($num - 1));

	echo "_________ EVENTS TEMPLATE #" . ($event + 1) . " ________\n";
	

	$rows = $template[$event];

	$action_sql[1] = $rows["action1"];
	$action_sql[2] = $rows["action2"];
	$action_sql[3] = $rows["action3"];
	$action_sql[4] = $rows["action4"];

	//foreach($action_sql as $key => $result)
	//{
	for($x = 1; $x < 5; $x++)
	{
		if(!empty($action_sql[$x])) {		

			// Ok we are now in Action
			print_r($action_sql[$x]);


			foreach($action_sql[$x] as $key_sub => $value)
			{
				$info[$x][$key_sub] = $value;
				foreach($data as $key_sub_sub => $output)
				{
					//echo "** REPLACING {$key_sub_sub} WITH {$output} FROM {$value} \n";
					$info[$x][$key_sub] = str_replace("%".$key_sub_sub."%", $output, $info[$x][$key_sub]);
				}


				$actionsql[$x] = $info[$x];
			}


			$actionsql[$x] = "base64:" . base64_encode( serialize ( $actionsql[$x] ) );

		} else {
			echo "Action {$x} is empty \n";

			$actionsql[$x] = "";
		}
	}



	$query = mysql_insert_array("events", array(
		"type" => $rows["type"], 
		"read" => "0", 
		"icon" => $rows["icon"], 
		"title" => $rows["title"], 
		"time" => time(), 
		"uid" => $userID, 
		"from" => $rows["from"], 
		"content" => $rows["content"],
		"fromuid" => $rows["fromuid"], 
		"action1" => $actionsql[1], 
		"action2" => $actionsql[2], 
		"action3" => $actionsql[3], 
		"action4" => $actionsql[4]
));

	foreach($data as $key => $value)
	{
		$query = str_replace("%".$key."%", $value, $query);
	}
	

	print_r($query);

	//preg_match("/removeMoney\((.*?), '(.*?)'\)/", $search, $match1);
	//preg_match("/addMoney\((.*?), '(.*?)'\)/", $search, $match2);
	//preg_match("/addPatient\((.*?), '(.*?)'\)/", $search, $match3);

	//$array = array_merge($match1, $match2, $match3);

	//print_r($array);

	//$query = str_replace("Event\";s:24:","Event\";s:22:", $query);
	//$query = str_replace("Event\";s:25:","Event\";s:23:", $query);
	//$query = str_replace("Event\";s:26:","Event\";s:24:", $query);

	//var_dump($query);

	mysql_query($query) or die(mysql_error());

	echo "__________________________________________________________________________\n\n";
}

function mysql_insert_array($table, $data, $password_field = "") {
	foreach ($data as $field=>$value) {
		$fields[] = '`' . $field . '`';
		
		if ($field == $password_field) {
			$values[] = "PASSWORD('" . mysql_real_escape_string($value) . "')";
		} else {
			$values[] = "'" . mysql_real_escape_string($value) . "'";
		}
	}
	$field_list = join(',', $fields);
	$value_list = join(', ', $values);
	
	$query = "INSERT INTO `" . $table . "` (" . $field_list . ") VALUES (" . $value_list . ")";
	
	return $query;
}

