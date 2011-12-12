<?php

class Info extends Controller
{
	public $layout;
	public $data = array();

	public function __construct()
	{
		parent::Controller();

		if($this->authlib->getUserId() != "") {
			$this->layout = "default";

			if($this->authlib->getSecurityRole() == "Admin")
			{
				$this->loadscript("admin/information");
				$this->loadscript("admin/general");
				$this->loadscript("jquery.form");
				$this->loadscript("tiny_mce/jquery.tinymce");
			}
			$this->loadscript("jquery.tipsy");
			$this->loadscript("game/general");

			$query = $this->db->query("SELECT * FROM settings WHERE `name` = 'systemOnline'");
			$result = $query->result_array();
			$result = $result[0];
			if($result['valueInt'] == 0)
				show_error("Sorry! We are updating the system. Please try again later!");

			// UserID
			$this->userID = $this->authlib->getUserId();
			$this->authLevel = $this->authlib->getSecurityRole();
			$this->data['authLevel'] = $this->authLevel;
			$data['currentUserId'] = $this->userID;
			$this->data['userID'] = $this->userID;
			// Hospital info
			$query = $this->db->query("SELECT `d`.`id` as `uid`, `d`.`hospitalID`, `d`.`hospitalArea`, `h`.`id` as `hid`, `h`.`title`, `h`.`unlock` FROM `user` as `d`, `hospital` as `h` WHERE `d`.`id` = '{$this->userID}' AND `hospitalID` = `h`.`id`");
			$result = $query->result_array();
	
			$this->hospitalInfo = $result[0];

			$query = $this->db->query("SELECT money, patientsCured as patients,stockValue, hospitalID, hoursInGame, hospitalArea, id, (SELECT COUNT(*) FROM `employees_hired` WHERE `uid` = '{$this->userID}') as numEmployee, (SELECT COUNT(*) FROM `mail` WHERE `uid` = '{$this->userID}' AND `read` = '0') as numMail, numPills FROM `user` WHERE `id` = '{$this->userID}'");
				$result = $query->result_array();
				$result = $result[0];

			$result['moneyInt'] = $result['money'];
			$result['money'] = number_format($result['money'], 2, ',', ' ');
	
			$this->data['stockValue'] = $result['stockValue'];	

			$this->data['hospitalInfo'] = $result;
			$this->data['hospitalWorth'] = number_format($this->_getUserWorth($this->userID), 2, ',', ' ');
			$this->data["hospitalInfo"]["tutorialStage"] = "completed";
	
			$usrValue = $this->_getUserWorth($this->userID);
			$stockValue = ($usrValue / 1000000);
					#$hospitalWorth = number_format($hospitalWorth, 2, ',', ' ');
			$stockValue = round($stockValue, 2);

			$this->db->query("UPDATE `user` SET `stockValue` = '{$stockValue}', `worth` = '{$usrValue}' WHERE `id` = '{$this->userID}'");

		} else {
			$this->layout = "auth";
		}
	}

	function contactus($msg="")
	{
		if($msg == "ok") { $this->data["highlight"] = "1"; $this->data["highlight_message"] = "Mail sent successfully!"; }
		$query = $this->db->query("SELECT * FROM `info` WHERE `site` = 'contactus'");
		$result = $query->result_array();

		$this->data['title'] = $result[0]["Site_Title"];
		$this->data['info'] = $result[0];
		$this->load->view('info', $this->data);
	}
	function termsofusage()
	{
		$query = $this->db->query("SELECT * FROM `info` WHERE `site` = 'termsofusage'");
		$result = $query->result_array();

		$this->data['title'] = $result[0]["Site_Title"];
		$this->data['info'] = $result[0];
		$this->load->view('info', $this->data);
	}
	function faq()
	{
		$query = $this->db->query("SELECT * FROM `info` WHERE `site` = 'faq'");
		$result = $query->result_array();

		$this->data['title'] = $result[0]["Site_Title"];
		$this->data['info'] = $result[0];
		$this->load->view('info', $this->data);
	}
	function contributors()
	{
		$query = $this->db->query("SELECT * FROM `info` WHERE `site` = 'contributors'");
		$result = $query->result_array();

		$this->data['title'] = $result[0]["Site_Title"];
		$this->data['info'] = $result[0];
		$this->load->view('info', $this->data);
	}
	function privacy()
	{
		$query = $this->db->query("SELECT * FROM `info` WHERE `site` = 'privacy'");
		$result = $query->result_array();

		$this->data['title'] = $result[0]["Site_Title"];
		$this->data['info'] = $result[0];
		$this->load->view('info', $this->data);
	}

	function updateInfo()
	{
		if($this->authlib->getSecurityRole() == "Admin")
		{
			$data = array("Information" => $_POST['textarea_information']);

			$this->db->where('id', $_POST['pageID']);
			$this->db->update('info', $data);

			echo "OK";

					$log = array("adminID" => $this->userID, "module" => "info", "action" => "update info", "time" => time(), "content" => "Updated Information Article (ID: {$_POST[id]})", "debug" => serialize($_POST));
					$this->db->insert("log_admin", $log);

		}
		else
		{
			echo "NOTADMIN";
		}
	}
	/*
	* Taken from MY_Controler
	*/
	public function loadscript($path)
	{

		$filepath = BASEPATH . "../template/js/{$path}.js";

		#if(!file_exists($filepath))
		#	show_error("File {$filepath} does not exist");

		$output = "<script type=\"text/javascript\" language=\"javascript\" src=\"/template/js/{$path}.js\"></script>";
	
		$this->data['jQuery'][] = $output;
		
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

}
