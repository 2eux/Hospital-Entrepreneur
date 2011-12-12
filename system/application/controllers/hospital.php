<?php

class Hospital extends MY_Controller
{
	 var $hospitalID;
 	 public function __construct()
 	 {
   	 parent::MY_Controller();


		$this->data['title'] = 'My Hospital';
		$this->_reloadAll();

  	}

  	public function _reloadAll()
  	{
	  	// Load all hospital types
		$sql = $this->db->query("SELECT * FROM `hospital` ORDER BY `id`");
		$result = $sql->result_array();

		$hospitalQuery	= $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		$hospitalResult	= $hospitalQuery->result_array();
		$hospitalID		= $hospitalResult[0]["hospitalID"];

		$this->hospitalID = $hospitalID;	
		$this->data['hospitalID'] = $hospitalID;

		// Hospital Area used
		$this->data["hospitalArea"]	= $hospitalResult[0]["hospitalArea"];

		// Information from THIS hospial
		$this->data['currentInfo']	= $result[ $hospitalID - 1 ];


		// Upgrade information
		$this->data['upgradeInfo']	= $result[$hospitalID];

		return $this;
	}

	public function getEmployees()
	{
		$query = $this->db->query("SELECT id, uid, type FROM `employees_hired` WHERE `uid` = '{$this->userID}' ORDER BY `type`");
		$result = $query->result_array();

		$num = array();
		foreach($result as $key)
		{
			$num[$key["type"]]++;
		}

		$this->data["employeesHired"] = $num;

		return $this;
	}
	public function getRooms()
	{
		$query = $this->db->query("SELECT uid FROM `buildings_built` WHERE `uid` = '{$this->userID}'");
		$num = $query->num_rows();

		$this->data["roomsBuilt"] = $num;

		return $this;
	}
	public function setHospitalRequirement($hospitalID)
	{
				// Doctor,Nurse,Janitor,Receptionist,Rooms
		$requirement = array(
			"1" => array(3,1,1,1,8),
			"2" => array(12,4,2,1,20),
			"3" => array(24,8,4,2,50),
			"4" => array(50,16,10,6,80),
			"5" => array(85,40,20,10,150)
				);
		
		$this->data["requirement"] = array(	"Doctor" => $requirement[$hospitalID][0],
							"Nurse" => $requirement[$hospitalID][1],
							"Janitor" => $requirement[$hospitalID][2],
							"Receptionist" => $requirement[$hospitalID][3],
							"Room" => $requirement[$hospitalID][4],
							);

		return $this;
	}
	public function generateLists()
	{

		$alreadyUnlocked = unserialize($this->data["currentInfo"]["unlock"]);
		$this->data['alreadyUnlocked'] = "<ul>";
		foreach($alreadyUnlocked as $a)
		{
			$this->data['alreadyUnlocked'] .= "<li>{$a}</li>";
		}
		$this->data['alreadyUnlocked'] .= "</ul>";

		if($this->hospitalID != 5) {
			$unlock 		 = unserialize($this->data["upgradeInfo"]["unlock"]);
			foreach($unlock as $key => $value)
			{
				if(!array_key_exists($key, $alreadyUnlocked))
					$this->data['unlock'] .= "<li><img src=\"/template/images/icons/add.png\"/> {$value}</li>\n";
			}
		}


		return $this;

	}
	public function analyseData()
	{
		// Generate Data
		$this->getEmployees()->getRooms();
		// Put them into variables
		$needData 		= $this->data["requirement"];
		$gotData  		= $this->data["employeesHired"];
		$gotData["Room"] 	= $this->data["roomsBuilt"];


		foreach($needData as $key => $data)
		{
			if($data <= $gotData[$key]):
				$this->data["requirementClass"][$key] = "check";
			else:
				$this->data["requirementClass"][$key] = "missing";
				$this->data["disableUpgrade"] = "true";
			endif;
		}

		// Generate the necessary TDs for table
		$hospitalID = $this->hospitalID;
		$hospitalMx = 5;

		// Previous:
		for($x = 1; $x < $hospitalID; $x++)
		{
			$this->data["td_phase_1"] .= "<td></td>";
		}
		$this->data["td_phase_1_upgrade"] = $this->data["td_phase_1"] . "<td></td>";
		// After:
		for($x = 4; $x > $hospitalID; $x--)
		{
			$this->data["td_phase_2"] .= "<td></td>";
		}

		// Generate the top menu bar
		$hospitals = array("Clinic","Small Hospital", "Medium Hospital", "Large Hospital", "Region Hospital");
		$output = "<tr>";
		$x = 1;
		foreach($hospitals as $data)
		{
	
			$active = $hospitalID;
			$upgrad = $hospitalID + 1;

			if($x == $active) { $class = "id='active'"; }
			elseif($x == $upgrad) { $class = "id='upgradeTo'"; }
			else { $class = ""; }
			
			$output .= "<td {$class} >{$data}</td>";
		
			$x++;

		}
		$output .= "</tr>";

		$this->data["menu_bar"] = $output;

		return $this;
	}
  	public function index()
  	{
	$this->setHospitalRequirement($this->hospitalID)->analyseData()->generateLists();
    	$this->load->view('hospital/overview', $this->data);
  	}
  	public function upgrade()
  	{
		$this->load->view("hospital/upgrade", $this->data);
	}
	public function upgradeOK()
	{
		if( $this->hospitalID == 5 )
		{
				$this->data['error'] = 1;
				$this->data['error_message'] = "You may not upgrade your hospital further!";
				$this->index();
		}
		else
		{
			$upgrade = $this->data['upgradeInfo'];

			if( $this->data['hospitalInfo']['moneyInt'] < $upgrade['price'] )
			{
				$this->data['error'] = 1;
				$this->data['error_message'] = "Insufficent funds! You may not upgrade without enough money";
				$this->index();
			}
			else
			{
				$this->db->query("UPDATE `user` SET `hospitalID` = `hospitalID` + 1, `money` = `money` - {$upgrade[price]}, `hospitalArea` = `hospitalArea` + {$upgrade['Set Area']} WHERE `id` = '{$this->userID}'");
				// Delete all employees
				$this->db->query("DELETE FROM `employees_hired` WHERE `uid` = '{$this->userID}'");

				$this->log_transaction("Remove", $upgrade['price'], "13");

				$this->data['highlight'] = 1;
				$this->data['highlight_message'] = "Congratulations! Your hospital have been upgraded!";
				
				$this->MY_Controller();
				$this->_reloadAll();
				$this->index();
			}

		}
	}
}
?>
