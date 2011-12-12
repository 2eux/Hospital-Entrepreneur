<?php

class Units extends MY_Controller
{
  public $layout = 'default';

  
  public function __construct()
  {
    parent::MY_Controller();
	$this->data['title'] = 'Employee Manager';
  }

  public function index()
  {
		// Queries

		$query = $this->db->query("SELECT e.*, f.img FROM `employees_hired` as `e`, `employees` as `f` WHERE `e`.`eid` = `f`.`id` AND `uid` = '{$this->userID}' ORDER BY `type`");
		$this->data['employees_hired'] = $query->result_array();
		

		$this->load->view("employee/overview", $this->data);
  }
  
  public function hire()
  {

		$sql = array(	'`skill` > 1 AND `skill` < 19',
						'`skill` > 20 AND `skill` < 29',
						'`skill` > 30 AND `skill` < 59',
						'`skill` > 60 AND `skill` < 74',
						'`skill` > 75 AND `skill` < 90');

		switch($this->hospitalInfo['hospitalID'])
		{
			case '1': $sql_result = $sql[0]; break;
			case '2': $sql_result = $sql[1]; break;
			case '3': $sql_result = $sql[2]; break;
			case '4': $sql_result = $sql[3]; break;
			case '5': $sql_result = $sql[4]; break;
			default: $sql_result = $sql[0]; break;
		}
		#switch($this->hospitalInfo['hospitalID']);

		$query_count = $this->db->query("SELECT * FROM `employees` WHERE `id` NOT IN (SELECT eid FROM `employees_hired`)");
		$this->data['num'] = $query_count->num_rows();

		$query_0 = $this->db->query("SELECT * FROM `employees` WHERE `id` NOT IN (SELECT eid FROM `employees_hired`) AND {$sql_result} AND `employeeType` = 'Doctor' ORDER BY `id` LIMIT 5");
		$query_1 = $this->db->query("SELECT * FROM `employees` WHERE `id` NOT IN (SELECT eid FROM `employees_hired`) AND {$sql_result} AND `employeeType` = 'Nurse' ORDER BY `id` LIMIT 5");
		$query_2 = $this->db->query("SELECT * FROM `employees` WHERE `id` NOT IN (SELECT eid FROM `employees_hired`) AND {$sql_result} AND `employeeType` = 'Janitor' ORDER BY `id` LIMIT 5");
		$query_3 = $this->db->query("SELECT * FROM `employees` WHERE `id` NOT IN (SELECT eid FROM `employees_hired`) AND {$sql_result} AND `employeeType` = 'Receptionist' ORDER BY `id` LIMIT 5");

		$this->data['employees'] = array_merge($query_0->result_array(), $query_1->result_array(), $query_2->result_array(), $query_3->result_array());

		$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `uid` = '{$this->userID}' ORDER BY `type`");
		$this->data['employees_hired'] = $query->result_array();


		$this->loadscript("game/employee");
		$this->loadscript("game/tablesorter");

		$this->load->view("employee/hire", $this->data);
  }
  public function ajax($function,$id=null)
  {
	switch($function)
	{	
		case 'increaseSalary':
			$employeeID = $_POST['employeeID'];
			if(!is_numeric($employeeID)) { die("Not numeric Employee ID!"); }
			$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `id` = '{$employeeID}'");
			$result = $query->result_array();
			$this->db->query("UPDATE `employees_hired` SET `happyness` = '100', `salary` = `salary` + 25 WHERE `id` = '{$employeeID}' AND `uid` = '{$this->userID}'");
			
			$this->data['highlight'] = 1;
			$this->data['highlight_message'] = "You've successfully given {$result[0][name]} a increased salary";
			$this->index();
		break;
		case 'giveBonus': 
			$employeeID = $_POST['employeeID'];
			if(!is_numeric($employeeID)) { die("Not numeric Employee ID!"); }
			$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `id` = '{$employeeID}'");
			$result = $query->result_array();

			$num = $this->db->query("SELECT * FROM `buildings_built` WHERE `uid` = '{$this->userID}' AND `bid` = '20'");
			$numnum = $num->num_rows();

			if($numnum == 0) {
				$this->data['error']  = 1;
				$this->data['error_message'] = "You <u>must</u> first build a staff room before sending anyone to the staff room";
				$this->index();
			}
			else
			{

				$tiredness = $result[0]["tiredness"];
				$happyness = $result[0]["happyness"];

				if($tiredness < 100 && $tiredness > 80) { $time = 1; }
				if($tiredness < 80  && $tiredness > 50) { $time = 2; }
				if($tiredness < 50  && $tiredness > 30) { $time = 3; }
				if($tiredness < 30) { $time = 4; }

				$this->db->query("UPDATE `employees_hired` SET `inRestroom` = '1', `timeRestroom` = '{$time}', `enabled` = 'No' WHERE `id` = '{$employeeID}' AND `uid` = '{$this->userID}'");

				$this->data['highlight'] = 1;
				$this->data['highlight_message'] = "You've successfully sent {$result[0][name]} to the Restroom. He will require ".(60*$time)."minutes to recover.";
				$this->index();

			}

		break;
		case 'fireEmployee':
			$employeeID = $_POST['employeeID'];
			if(!is_numeric($employeeID)) { die("Not numeric Employee ID!"); }
			$query = $this->db->query("SELECT * FROM `employees_hired` WHERE `id` = '{$employeeID}'");
			$result = $query->result_array();
			$this->db->query("DELETE FROM `employees_hired` WHERE `id` = '{$employeeID}' AND `uid` = '{$this->userID}'");

			$this->data['highlight'] = 1;
			$this->data['highlight_message'] = "You've successfully fired {$result[0][name]}";
			$this->index();
		break;
		case 'hireEmployee':

			
			/* Hire multiple employees */
			if(isset($_POST["submitMany"]) && count($_POST["multipleHire"]) > 0)
			{

				// Create the query!
				$query = "SELECT * FROM `employees` WHERE ";
				foreach($_POST["multipleHire"] as $val)
					$query .= "id={$val} OR ";

				$query = substr($query, 0, -3);
			
				$query = $this->db->query($query);
				$result = $query->result_array();

				foreach($result as $result[0])
				{
					$names[] = $this->_hireEmployee($result[0]);
				}

				foreach($names as $name)
					$n .= $name . ", ";

				$n = substr($n, 0,-2);

				$this->highlight("You've successfully hired {$n}");

			} else {
				$employeeID = $id;
				if(!is_numeric($employeeID)) { show_error("Not numeric Employee ID!"); }
		
				$query = $this->db->query("SELECT * FROM `employees` WHERE `id` = '{$employeeID}'");
				$result = $query->result_array();

				$this->_hireEmployee($result[0]);

				$this->highlight("You've successfully hired {$result[0][name]}");
			}
			$this->index();
	}
  }

	private function _hireEmployee($result)
	{

			

			$this->db->query("UPDATE `user` SET `money` = `money` - {$result[price]} WHERE `id` = '{$this->userID}'");
			

			$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
															"transactionType" => "Remove",
															"money" => $result['price'],
															"contentType" => 11,
															"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$result[price]} WHERE `id` = '{$this->userID}';",
															"time" => time(),
															"ip" => $_SERVER['REMOTE_ADDR']) );

			if($result[0]["extraFunction"] == "") { $extraSkill = ""; }
			else { $extraSkill = $result[0]["extraFunction"]; }

			$this->db->insert('employees_hired', array(	"uid" => $this->userID,
														"name" => $result["name"],
														"salary" => $result["price"],
														"eid" => $result["id"],
														"happyness" => 100,
														"tiredness" => 100,
														"type" => $result["employeeType"],
														"skill" => $result["skill"],
														"enabled" => "Yes",
														"x" => "0",
														"inRestroom" => "0",
														"extraSkill" => "{$extraSkill}"));

		return $result["name"];
	}

} 
