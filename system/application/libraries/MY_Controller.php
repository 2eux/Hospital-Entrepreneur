<?php

class  MY_Controller  extends  Controller  {

	public $resources;
	public $data	= array();
	public $error	= array();
	public $layout	= 'default';

    function MY_Controller ($skipJS = false)
    {
        parent::Controller();
	
		if($this->authlib->check() !== true)
			redirect("auth/login"); 

		// Enable this when going to Beta
		#$this->output->enable_profiler(TRUE);

		$this->data["skipJS"] = $skipJS;

		// JS Scripts to always load.
		//$this->loadscript('treelib/jquery.tree');
		if($skipJS == false)
		{
			$this->loadscript("game/general");
			$this->loadscript("jquery.tipsy");
			$this->loadscript("jquery.growl");
		$this->loadscript("jquery.colorfade");
		}
		//$this->loadscript("jquery.sound");

		$query = $this->db->query("SELECT * FROM settings WHERE `name` = 'systemOnline'");
		$result = $query->result_array();
		$result = $result[0];
		if($result['valueInt'] == 0)
			show_error("Sorry! We are updating the system. Please try again later!");

		$query = $this->db->query("SELECT * FROM settings WHERE `name` = 'advertising'");
		$result = $query->result_array();
		$result = $result[0];
		$this->data['setting_advertising'] = $result["value"]; // FIXME: Advertising, either true or false

		// Advertising
		$query = $this->db->query("SELECT * FROM `adverts` WHERE `ExpireyDate` > NOW()");
		$addSpot = array("default_top","menu_left");
		foreach($query->result_array() as $result)
		{
			$ad[$result["AdvertisingSpot"]][] = array(	"image" => $result['imageSrc'],
														"href" => $result['href'] );
		}
		foreach($addSpot as $add)
		{
			if(count($ad[$add]) > 0)
			{
				$rnd = rand(1, count($ad[$add]));
				$rnd = $rnd - 1;

				$this->data['advertising'][$add] = $ad[$add][$rnd];
			}
		}


		// UserID
		$this->userID = $this->authlib->getUserId();
		$this->authLevel = $this->authlib->getSecurityRole();
		$this->data['authLevel'] = $this->authLevel;
		$data['currentUserId'] = $this->userID;
		$this->data['userID'] = $this->userID;
		// Hospital info
		$query = $this->db->query("SELECT `d`.`id` as `uid`, `d`.`trial` as `is_trial`, `d`.`hospitalID`, `d`.`premiumExpire`, `d`.`premiumPackage` as `is_premium`, `d`.`hospitalArea`, `h`.`id` as `hid`, `h`.`title`, `h`.`unlock` FROM `user` as `d`, `hospital` as `h` WHERE `d`.`id` = '{$this->userID}' AND `hospitalID` = `h`.`id`");
		$result = $query->result_array();
	
		$this->hospitalInfo = $result[0];

		$query = $this->db->query("SELECT money, user_name, trial as `is_trial`, tutorialStage, avatar, patientsCured as patients,stockValue, premiumExpire, premiumPackage, hospitalID, hoursInGame, hospitalArea, id, (SELECT COUNT(*) FROM `employees_hired` WHERE `uid` = '{$this->userID}') as numEmployee, (SELECT COUNT(*) FROM `mail` WHERE `uid` = '{$this->userID}' AND `read` = '0') as numMail, numPills FROM `user` WHERE `id` = '{$this->userID}'");
			$result = $query->result_array();
			$result = $result[0];

		$result['moneyInt'] = $result['money'];
		$result['money'] = number_format($result['money'], 0, ',', ' ');
	
		$this->data['stockValue'] = $result['stockValue'];	

		$this->data['hospitalInfo'] = $result;
		$this->data['hospitalWorth'] = number_format($this->_getUserWorth($this->userID), 0, ',', ' ');
	
		$usrValue = $this->_getUserWorth($this->userID);
		$stockValue = ($usrValue / 1000000);
				#$hospitalWorth = number_format($hospitalWorth, 2, ',', ' ');
		$stockValue = round($stockValue, 2);

		$this->db->query("UPDATE `user` SET `stockValue` = '{$stockValue}', `worth` = '{$usrValue}' WHERE `id` = '{$this->userID}'");


    }
	
	function ConvertOneTimezoneToAnotherTimezone($time,$currentTimezone,$timezoneRequired)
	{
	    $system_timezone = date_default_timezone_get();
	    $local_timezone = $currentTimezone;
	    date_default_timezone_set($local_timezone);
	    $local = date("Y-m-d h:i:s A");
	 
	    date_default_timezone_set("GMT");
	    $gmt = date("Y-m-d h:i:s A");
	 
	    $require_timezone = $timezoneRequired;
	    date_default_timezone_set($require_timezone);
	    $required = date("Y-m-d h:i:s A");
	 
	    date_default_timezone_set($system_timezone);

	    $diff1 = (strtotime($gmt) - strtotime($local));
	    $diff2 = (strtotime($required) - strtotime($gmt));

	    $date = new DateTime($time);
	    $date->modify("+$diff1 seconds");
	    $date->modify("+$diff2 seconds");
	    $timestamp = $date->format("m-d-Y H:i:s");
	    return $timestamp;
	}
	public function parse()
	{
		$userID =  $this->authlib->getUserId();
		 
		$this->load->vars($postTemplate);
	}

	public function log_transaction($type = "Add", $money = "0", $contentType = "1")
	{
		$this->db->query("INSERT INTO `log_transactions` (`id`, `userid`, `transactionType`, `money`, `contentType`, `ReverseSQL`, `time`, `ip`) VALUES (NULL, '{$this->userID}', '{$type}', '{$money}', '{$contentType}', 'NonReversable', '".time()."', '" . $_SERVER["REMOTE_ADDR"] . "');");
}

	function highlight($text)
	{
		$this->data['highlight'] = 1;
		$this->data['highlight_message'] = $text;
		return $this;
	}
	function error($text)
	{
		$this->data['error'] = 1;
		$this->data['error_message'] = $text;
		return $this;
	}
	function reload_data()
	{
		$this->MY_Controller();
		return $this;
	}
	function _getUserWorth($uid=0)
	{
		if($uid !== 0) { $this->userID = $uid; }
		// Get information about the rooms built
		$query = $this->db->query("SELECT `b`.`areaOccupied` , `b`.`bid` , `b`.`uid` , `o`.`id` , `o`.`cost_money`
FROM `buildings_built` AS `b` , `buildings` AS `o` WHERE `b`.`uid` = '{$this->userID}' AND `b`.`bid` = `o`.`id`") or show_error(mysql_error());

		$result = $query->result_array();
		$num = count($result);
		// And do the calculations
		if($num !== 0)
		{
			foreach($result as $r)
			{
				$roomWorth = ( $r['areaOccupied'] * $r['cost_money'] * 62.925 );
				#echo "[±] Room {$r[id]} is worth {$roomWorth} <br />";

				$hospitalWorth = $hospitalWorth + $roomWorth;
			}
		}
		else
		{

				$hospitalWorth = $hospitalWorth * 0.72525;

		}

		// Find information about the user, the hospital he owns, the price of the hospital and get  the stockConstant
		$query = $this->db->query("SELECT `u`.`id`, `u`.`money`, `u`.`hospitalID`, `u`.`hospitalArea`, `u`.`patientsCured`, `s`.`name`, `s`.`valueInt` as `value`, `h`.`price` as `hospitalPrice`, `h`.`id` as `hid` from `user` as `u`, `settings` as `s`, `hospital` as `h` WHERE `u`.`id` = '{$this->userID}' AND `s`.`name` = 'stockConstant' AND `h`.`id` = `u`.`hospitalID`");

		$result = $query->result_array();
		$result = $result[0];

		// Patients
		$patients = $result['patientsCured'] * 792 * 3;
		#echo "[--] Patients: {$patients} <br />";
		$hospitalWorth = $hospitalWorth + $patients;

		// Hospital Area left
		$hospitalArea = ( $result['hospitalArea'] * $result['hospitalArea'] ) / 2;
		$hospitalWorth = $hospitalWorth + $hospitalArea;

		// Current money sack.
		$hospitalWorth = $hospitalWorth + ( $result['hospitalPrice'] * 16.2 );

		// Set the stockConstant to its own variable
		$stock = $result['value'];

		// Calculate the hospital worth
		$hospital = ($result['hospitalPrice'] * $stock); + ( 100000 * $stock * 1.56);

		$hospitalWorth = $hospital + $hospitalWorth;

		#echo "[--] Hospital worth by itself: {$hospital} <br />";

		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}'");
		$result = $query->result_array();

		foreach($result as $r)
		{
			$salary = $salary + $r['salary'];
		}
		$salary = $salary * 24 * 20 * 0.8;
		$hospitalWorth = $salary + $hospitalWorth;

		#echo "[---] Salary of employees: {$salary}";

		#$hospitalWorth = number_format($hospitalWorth, 2, ',', ' ');
		#echo "<h1>[+] Total: {$hospitalWorth}</h1>";

		return $hospitalWorth;

	}

	private function convert_datetime($str) 
	{
	
		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);
		
		$timestamp = @mktime($hour, $minute, $second, $month, $day, $year);
		
		return $timestamp;
	}
	public function loadscript($path)
	{

		$filepath = BASEPATH . "../template/js/{$path}.js";

		#if(!file_exists($filepath))
		#	show_error("File {$filepath} does not exist");

		$output = "<script type=\"text/javascript\" language=\"javascript\" src=\"/template/js/{$path}.js\"></script>";
	
		$this->data['jQuery'][] = $output;
		
	}
}

?>
