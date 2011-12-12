<?php

class Gettingstarted extends MY_Controller
{
	public $layout = 'default';

	public function __construct()
	{
		parent::MY_Controller();
		
		/* User Data */
		$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		$result = $query->result_array();
		$this->data["user_data"] = $result[0];


		/* Employee Data */
		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}' AND `type` = 'Doctor'");
		$doctor = $query->num_rows();

		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}' AND `type` = 'Nurse'");
		$nurse = $query->num_rows();

		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}' AND `type` = 'Janitor'");
		$janitor = $query->num_rows();

		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}' AND `type` = 'Receptionist'");
		$receptionist = $query->num_rows();
		
		$this->data["user_data"]["employee"] = array("Doctor" => $doctor, "Nurse" => $nurse, "Janitor" => $janitor, "Receptionist" => $receptionist);

		/* Building Data */
		$query = $this->db->query("SELECT * FROM `buildings_built` WHERE `uid` = '{$this->userID}'");
		$result = $query->result_array();
		foreach($result as $value)
			$completed[$value['bid']]++;

		$this->data["user_data"]["building"] = $completed;
	}

	function index()
	{
		
		$this->stage($this->data["user_data"]["tutorialStage"]);
	}

	function stage($id)
	{
		switch($id)
		{
			case "1":
				$view = "overview";
			break;
			case "2":
				$view = "step1";
			break;
			case "3":
				$view = "step2";
			break;
			case "4":
				$view = "step3";
			break;
			case "5":
				$view = "step4";
			break;
			case "6":
				$view = "step5";
			break;
		}

		$this->load->view("gettingstarted/{$view}", $this->data);

		return $this;
	}

	function update($to)
	{
		$this->db->query("UPDATE `user` SET `tutorialStage` = '{$to}' WHERE `id` = '{$this->userID}'");
		return $this;
	}

	function complete($stage)
	{
		// Current Stage
		$currentStage = $this->data["user_data"]["tutorialStage"];

		// Completed Stage
		$completedStage = $stage;

		switch($completedStage)
		{
			case "1":
				//if($currentStage == "1") {
				//	echo "HI";
					$this->update(2);
					redirect("/gettingstarted/stage/2");
				//}
			break;
			case "2":
				if($currentStage == "2") {
					$this->update(3);
					redirect("/gettingstarted/stage/3");
				}
			break;	
			case "3":
				if($currentStage == "3") {
					$this->update(4);
					redirect("/gettingstarted/stage/4");
				}
			break;
			case "4":
				if($currentStage == "4") {
					$this->update(5);
					redirect("/gettingstarted/stage/5");
				}
			break;
			case "5":
				if($currentStage == "5") {
					$this->update(6);
					redirect("/gettingstarted/stage/6");
				}
			break;
			case "complete":
				if($currentStage == "6") {
					$this->load->view("gettingstarted/complete", $this->data);
				}
			break;
			case "claim":
				if($currentStage == "6") {
					$this->db->query("UPDATE `user` SET `tutorialStage` = 'completed', `money` = `money` + 100000 WHERE `id` = '{$this->userID}'");
					redirect("/overview");
				}
			break;
		}
	}		

}
