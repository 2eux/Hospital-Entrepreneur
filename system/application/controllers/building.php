<?php

class Building extends MY_Controller
{

  public function __construct()
  {
    parent::MY_Controller();

	$this->cancelOutput = false;

	$this->data['title'] = 'Building';
 	if($this->data["skipJS"] == false)
	{
		$this->loadscript("jquery.form");
		$this->loadscript("game/building");
		$this->loadscript("jquery.blockui");
	}
	

  }

  public function index()
  {
  
  	/* List all buildings */
	$query = $this->db->query("SELECT * FROM `buildings` ORDER BY `id`");
	$result = $query->result_array();
	foreach($result as $b)
	{
		$o[$b["id"]] = $b;
	}

	/* UserID */
	$userID = $this->authlib->getUserId();
	
	// Find the number of buildings a user has builded of building X
	$query = $this->db->query("SELECT * FROM `buildings_built` WHERE `uid` = '{$this->userID}' ORDER BY `bid`");
	$build = $query->result_array();
	foreach($build as $output)
	{
		$completed[$output['bid']]++;
		$buildingInfo[$output['bid']][] = array("id" => $output["id"],
												"icon" => $o[$output["bid"]]["image"],
												"name" => $o[$output['bid']]["name"],
												"doc" => $output["employeeAssigned"],
												"area" => array("length"	=> $output["areaLength"],
													 	"width" 	=> $output["areaWidth"],
													 	"total"	=> $output["areaOccupied"]
													 	));
	}
	
	$this->data['hospital'] = $this->hospitalInfo;

	$this->data['built'] = $completed;
	$this->data['buildingInfo'] = $buildingInfo;


	/* Print the template */
	if(!$this->cancelOutput) 
	{
		$this->load->view('constructions/building_top_menu', $this->data);
    	$this->load->view('constructions/build_manage', $this->data);
	}
  }

  public function build()
  {
  	/* List all buildings */
	$sql = $this->db->query("SELECT * FROM `buildings_category` ORDER BY `catID`");
	$x = 1;
	$result = $sql->result_array();
	foreach($result as $row)
	{
		$query = $this->db->query("SELECT * FROM `buildings` WHERE `cat` = '{$x}' ORDER BY `id`");
		$this->data['building'][$x]		=	$query->result_array();
		$this->data['category'][$x]		=	array("id" => $x, "name" => $row['name']);
		$x++;
	}
	/* UserID */
	$userID = $this->authlib->getUserId();
	
	// Find the number of buildings a user has builded of building X
	$query = $this->db->query("SELECT * FROM `buildings_built` WHERE `uid` = '{$this->userID}' ORDER BY `bid`");
	$build = $query->result_array();
	foreach($build as $output)
	{
		$completed[$output['bid']]++;
		$buildingInfo[$output['bid']][] = array("id" => $output["id"],
												"doc" => $output["employeeAssigned"],
												"area" => array("length"	=> $output["areaLength"],
													 	"width" 	=> $output["areaWidth"],
													 	"total"	=> $output["areaOccupied"]
													 	));
	}
	
	$this->data['hospital'] = $this->hospitalInfo;

	$this->data['built'] = $completed;
	$this->data['buildingInfo'] = $buildingInfo;


	/* Print the template */
	if(!$this->cancelOutput) 
	{
		$this->load->view('constructions/building_top_menu', $this->data);
    	$this->load->view('constructions/building', $this->data);
	}

	return $this;
  }
  public function build_post($id)
  {
		 $data = $_POST;
		if(empty($data))
		{
			show_error("Could not process your request. Missing _POST attribute");
		}
		if(!is_numeric($id))
		{
			show_error("Could not process your request. Wrong ID Attribute");
		}

		// Get building information
		$query = $this->db->query("SELECT * FROM `buildings` WHERE `id` = '{$id}'");
		$result = $query->result_array();
		$result = $result[0];

		// Production information
		$productionInfo = unserialize($result['action_production']);
		
		// Area size
		$length = intval($_POST["L_{$id}"]);
		$width	= intval($_POST["W_{$id}"]);
		$total	= $length * $width;

		$m = $this->data['hospitalInfo']['hospitalID'];
		switch($m)
		{
			case "1": $multiplier = 1; break;
			case "2": $multiplier = 4; break;
			case "3": $multiplier = 16; break;
			case "4": $multiplier = 40; break;
			case "5": $multiplier = 90; break;
			default: $multiplier = 1; break;
		}


		// Building Price
		$price = $result['cost_money'] * $total * $multiplier;

		// Get users money
		$money = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		$moneyResult = $money->result_array();
		$money = $moneyResult[0]['money'];

		// Get users area
		$userArea = $moneyResult[0]['hospitalArea'];

		// Check if theres enough area left to build
		if($userArea < $total)
			$this->error("You can't build this big. Please either build smaller or expand your hotel")->build();

		// Check if you have enough money
		if($money < $price)
			$this->error("You cannot afford this at the current time")->build();

		// No errors yet? Lets build then!
			$this->db->insert('buildings_built', array(	"uid" => $this->userID,
														"bid" => $id,
														'patientsCured' => $productionInfo["Cure per 5 min"],
														'patientsCost' => $productionInfo["Cost per cure"],
														"areaOccupied" => $total,
														"areaWidth" => $width,
														"areaLength" => $length ));

			$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
															"transactionType" => "Remove",
															"money" => $price,
															"contentType" => 9,
															"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$price} WHERE `id` = '{$this->userID}';",
															"time" => time(),
															"ip" => $_SERVER['REMOTE_ADDR']) );

			
		$this->db->query("UPDATE `user` SET `money` = `money` - $price, `hospitalArea` = `hospitalArea` - $total WHERE `id` = '{$this->userID}'");

		$this->highlight("You have successfully builded the room");
		$this->index();
  }

  public function build_ajax()
  {
		$this->layout = "xml";
		 $data = $_POST;
		if(empty($data))
		{
			echo "ERROR: Could not process your request. Missing _POST attribute";
		}

		$id = $_POST["buildingID"];

		// Get building information
		$query = $this->db->query("SELECT * FROM `buildings` WHERE `id` = '{$id}'");
		$result = $query->result_array();
		$result = $result[0];

		// Production information
		$productionInfo = unserialize($result['action_production']);
		
		// Area size
		$length = intval($_POST["L_{$id}"]);
		$width	= intval($_POST["W_{$id}"]);
		$total	= $length * $width;

		$m = $this->data['hospitalInfo']['hospitalID'];
		switch($m)
		{
			case "1": $multiplier = 1; break;
			case "2": $multiplier = 4; break;
			case "3": $multiplier = 16; break;
			case "4": $multiplier = 40; break;
			case "5": $multiplier = 90; break;
			default: $multiplier = 1; break;
		}


		// Building Price
		$price = $result['cost_money'] * $total * $multiplier;

		// Get users money
		$money = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		$moneyResult = $money->result_array();
		$money = $moneyResult[0]['money'];

		// Get users area
		$userArea = $moneyResult[0]['hospitalArea'];

		// Check if theres enough area left to build
		if($userArea < $total)
			die( "ERROR: You can't build this big. Please either build smaller or expand your hotel" );

		// Check if you have enough money
		if($money < $price)
			die( "ERROR: You cannot afford this at the current time");

		// No errors yet? Lets build then!
			$this->db->insert('buildings_built', array(	"uid" => $this->userID,
														"bid" => $id,
														'patientsCured' => $productionInfo["Cure per 5 min"],
														'patientsCost' => $productionInfo["Cost per cure"],
														"areaOccupied" => $total,
														"areaWidth" => $width,
														"areaLength" => $length ));

			$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
															"transactionType" => "Remove",
															"money" => $price,
															"contentType" => 9,
															"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$price} WHERE `id` = '{$this->userID}';",
															"time" => time(),
															"ip" => $_SERVER['REMOTE_ADDR']) );

			
		$this->db->query("UPDATE `user` SET `money` = `money` - $price, `hospitalArea` = `hospitalArea` - $total WHERE `id` = '{$this->userID}'");

		echo "SUCCESS: You successfully constructed the room";
  }


	function delete_room($id,$output = true)
	{
		if(!is_numeric($id)) { show_error("id must be numeric"); }
		else
		{
			$query = $this->db->query("SELECT * FROM `buildings_built` WHERE `id` = '{$id}' AND `uid` = '{$this->userID}'");
			if($query->num_rows() == 0)
			{
				$this->error("Sorry! Someone have played around with the system. Please try again!");
				$this->index();
	
				return false;
				die();
			}
			else
			{
				$result = $query->result_array();
				$area = $result[0]["areaOccupied"];

				$this->db->query("DELETE FROM `buildings_built` WHERE `id` = '{$id}' AND `uid` = '{$this->userID}'");
				$this->db->query("UPDATE `user` SET `hospitalArea` = `hospitalArea` + {$area} WHERE `id` = '{$this->userID}'");
				if($output == true) {
					$this->MY_Controller();
					$this->highlight("You have successfully destroyed the room");
					$this->index();
				} else { return $area; }
			}
		}
	}
	function delete_roomRq($id)
	{
		if(!is_numeric($id)) { show_error("ID Must be numeric"); }
		else
		{
			$this->data['roomID'] = $id;
			$this->load->view("constructions/deleteRoom", $this->data);
		}
	}
	
	function delete_room_multiple()
	{
		if(isset($_POST) && count($_POST["room"]) > 0)
		{
			foreach($_POST["room"] as $room)
			{
				$var = $this->delete_room( $room , false );
				if($var) { $area = $area + $var; }
			}
			if($area)
			{
				$this->MY_Controller(true);
				$this->highlight("You have successfully removed ".count($_POST["room"])." rooms and gained yourself " . $area . "m&#173 from the rooms.");
				$this->index();
			}
		}
		else
		{
			$this->error("Some error must have happened. Either you tried to reach this site from a distant location or you just forgot to select any rooms to destroy. Try again");
			$this->index();
		}
	}
} 
