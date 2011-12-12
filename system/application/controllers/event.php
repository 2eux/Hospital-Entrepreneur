<?php

class Event extends MY_Controller
{
	public $layout = 'default';

	private $skipDATA = array();

	public function __construct()
	{
		parent::MY_Controller();
	}

	function index()
	{
		$this->log();
	}
	
	function log()
	{

		$query = $this->db->query("SELECT * FROM `events` WHERE `uid` = '{$this->userID}' ORDER BY `time` DESC");
		$result = $query->result_array();

		$this->data['title'] = "Event Report";
		$this->data['events'] = $result;

		$this->load->view("event/log", $this->data);

	}

	function admin()
	{
		$this->_load_admin();

		$this->data['title'] = "Events Management";

		$events = $this->db->query("SELECT * FROM `event_messages`");

		$this->data['event'] = $events->result_array();

		$num = $this->db->query("SELECT * FROM `events`");

		$this->data['event_sent_num'] = $num->num_rows();
		$this->data['event_num'] = $events->num_rows();

		$this->load->view("event/admin", $this->data);

	}

	function _load_admin()
	{
		if($this->data['authLevel'] !== "Admin") { show_error("You do not have permission to do this!"); }

		$this->loadscript("jquery.form");
		$this->loadscript("admin/general");
		$this->loadscript("admin/event");
		$this->loadscript("jquery.autocomplete");
	}
	function admin_add()
	{
		$this->_load_admin();
		$this->data['title'] = "Add Event!";
		$this->load->view("event/admin_add", $this->data);

	}

	function admin_delete($id)
	{
		if(!is_numeric($id)) { show_error("ID Must be numeric!"); }
		$this->_load_admin();

		$query = $this->db->query("DELETE FROM `event_messages` WHERE `id` = '{$id}'");

		$this->data["highlight"] = "1";
		$this->data["highlight_message"] = "Event #{$id} was successfully deleted";

		$this->admin();

	}
	function admin_event_send()
	{

		$this->layout = "xml";
		#print_r($_POST);

		$query = $this->db->query("SELECT * FROM `user` WHERE `user_name` = '{$_POST[sendto]}'");
		$num = $query->num_rows();

		$user = $query->result_array();
		$user = $user[0];

		if($num > 0 || $_POST['eventAll'] == "checked") {
			$query = $this->db->query("SELECT * FROM `event_messages` WHERE `id` = '{$_POST[id]}'");

			$result = $query->result_array();
			$result = $result[0];

			// For our random thingy
			$query = $this->db->query("SELECT id, user_alias, user_name FROM `user` WHERE id >= (SELECT FLOOR( MAX(id) * RAND()) FROM `user` ) ORDER BY id LIMIT 1;");
			$randomUser = $query->result_array();
			$rndUsr = $randomUser[0];

			foreach($result as $key => $value)
			{
				$newResult[$key] = str_replace("%USER_TO%", $user["user_name"], $value);
				$newResult[$key] = str_replace("%USER_ALIAS%", $user["user_alias"], $newResult[$key]);
				$newResult[$key] = str_replace("%RANDOM_USER%", $rndUsr["user_name"], $newResult[$key]);
				$newResult[$key] = str_replace("%RANDOM_USER_ID%", $rndUsr["id"], $newResult[$key]);
			}
			$result = $newResult;
			
			#print_r($result);
			if($_POST['eventAll'] == "checked")
			{
				$query = $this->db->query("SELECT * FROM `user`");
				foreach($query->result_array() as $user)
				{
					$query = array(	"type" => $result["type"],
							"read" => "0",
							"icon" => $result["icon"],
							"title" => $result["title"],
							"time" => time(),
							"uid" => $user["id"],
							"from" => $result["from"],
							"fromuid" => $result["fromuid"],
							"content" => $result["content"],
							"action1" => $result["action1"],
							"action2" => $result["action2"],
							"action3" => $result["action3"],
							"action4" => $result["action4"]);
							$this->db->insert("events", $query);

							$_POST["sendto"] = "all users";
				}

			}
			else
			{
			$query = array(	"type" => $result["type"],
							"read" => "0",
							"icon" => $result["icon"],
							"title" => $result["title"],
							"time" => time(),
							"uid" => $user["id"],
							"from" => $result["from"],
							"fromuid" => $result["fromuid"],
							"content" => $result["content"],
							"action1" => $result["action1"],
							"action2" => $result["action2"],
							"action3" => $result["action3"],
							"action4" => $result["action4"]);
							$this->db->insert("events", $query);
			}

			$adminData = array( "adminID" => $this->userID,
							"module" => "event",
							"action" => "admin_event_send",
							"time"	=> time(),
							"content" => "Sent Event to {$_POST[sendto]}",
							"debug" => serialize($query) );

			$this->db->insert("log_admin", $adminData);

			echo "SUCCESS: Query Inserted";

		} else {
			echo "ERROR: User does not exist!";
		}

	}

	function admin_add_post()
	{
		foreach($_POST as $key => $value)
		{
			if(count(explode("event_", $key)) > 1 && $value == "random" && $key !== "event_type")
			{
				$num = explode("event_", $key);
				$array = array("From", "To", "MoreThan","LessThan","PositiveMessage", "NegativeMessage","PositiveEvent", "NegativeEvent", "PositiveEvent", "NegativeEvent");

				foreach($array as $var)
				{
					#echo "** Unsetting Variable RANDOM {$var} \n";
					$this->skipDATA["random_{$var}_{$num[1]}"] = "true";
				}

				$this->skipDATA["random_PositiveEvent_{$num[1]}_argv"] = "true";
				$this->skipDATA["random_NegativeEvent_{$num[1]}_argv"] = "true";
				$this->skipDATA["random_PositiveEvent_{$num[1]}_argv2"] = "true";
				$this->skipDATA["random_NegativeEvent_{$num[1]}_argv2"] = "true";
			}
			elseif(count(explode("random_", $key)) > 1)
			{
				if(!$this->skipDATA[$key] == "true")
				{
					$explode = explode("random_", $key);

					$num = explode("_", $explode[1]);
					if(count($num) == 3) {
						$data['random'][$num[1]]["{$num[0]}_{$num[2]}"] = $value;
					}
					else
					{
						$data['random'][$num[1]][$num[0]] = $value;
					}
				#	$this->skipDATA["{$num[1]}_argv"] = "true";
				#	$this->skipDATA["{$num[1]}_argv2"] = "true";
				}

			}
			elseif(count(explode("title_", $key)) > 1 && $value == "")
			{
				$num = explode("title_", $key);
				$n = $num[1];

				$this->skipDATA["title_{$n}"] = "true";
				$this->skipDATA["icon_{$n}"] = "true";
				$this->skipDATA["text_{$n}"] = "true";
				#$this->skipDATA["{$n}_argv"] = "true";
				#$this->skipDATA["{$n}_argv2"] = "true";

			}
			else
			{
				if(!$this->skipDATA[$key] == "true")
					$data[$key] = $value;
			}
		}

					#echo "<pre>";
					#print_r($_POST);
					#print_r($data);

		for($x = 1; $x < 5; $x++)
		{
			if(isset($data["event_{$x}"]) && $data["event_{$x}"] !== "empty")
			{
				if($data["event_{$x}"] == "random")
				{
					$serialize = array(	"title" => 	$data["title_{$x}"],
										"icon" => 	$data["icon_{$x}"],
										"Text" => "null",
										"Event" => "random",
										"Random" => array(
											"From" => 	$data['random'][$x]["From"],
											"To" => 	$data['random'][$x]["To"],
											"LessThan" => 	$data['random'][$x]["LessThan"],
											"MoreThan" => 	$data['random'][$x]["MoreThan"],
											"PositiveEvent" => "{$data['random'][$x]['PositiveEvent']}({$data['random'][$x]['PositiveEvent_argv']}, '{$data['random'][$x]['PositiveEvent_argv2']}')",
											"NegativeEvent" => "{$data['random'][$x]['NegativeEvent']}({$data['random'][$x]['NegativeEvent_argv']}, '{$data['random'][$x]['NegativeEvent_argv2']}')",
											"PositiveMessage" => $data['random'][$x]["PositiveMessage"],
											"NegativeMessage" => $data['random'][$x]["NegativeMessage"])
									);

					$action[$x] = serialize($serialize);

				}
				else
				{
					$argv1 = $x."_argv";
					$argv2 = $argv1."2";

					$serialize = array(	"Title" => 	$data["title_{$x}"],
										"Icon" => 	$data["icon_{$x}"],
										"Text" => $data["text_{$x}"],
										"Event" => $data["event_{$x}"] . "({$data[$argv1]}, '{$data[$argv2]}')" );

					$action[$x] = serialize($serialize);
				}
			}
			else
			{
				$action[$x] = "";
			}
		}

		$sqlData = array(	"language" => "english",
							"type" => $data['event_type'],
							"title" => $data['title'],
							"content" => nl2br($data['content']),
							"icon" => $data['icon'],
							"from" => $data['from'],
							"fromuid" => $data['fromuid'],
							"addedBy" => $this->userID,
							"action1" => $action[1],
							"action2" => $action[2],
							"action3" => $action[3],
							"action4" => $action[4]
						);

		print_r($sqlData);

		$adminData = array( "adminID" => $this->userID,
							"module" => "event",
							"action" => "event_add",
							"time"	=> time(),
							"content" => "Created a new Event Message",
							"debug" => serialize($sqlData) );

		$this->db->insert("event_messages", $sqlData);
		$this->db->insert("log_admin", $adminData);

		$this->data['highlight'] = "1";
		$this->data['highlight_message'] = "Your event have been successfully added";
		$this->admin();

	}

	function interact($id)
	{
		if(!is_numeric($id)) { show_error("ID Must be numeric"); }
		$query = $this->db->query("SELECT * FROM `events` WHERE `uid` = '{$this->userID}' AND `id` = '{$id}'");
		$result = $query->result_array();
		$result = $result[0];

		// Only update the read if theres no action that can be done by the user.
		if($result['read'] == 0 && $result['action1'] == "")
			$this->db->query("UPDATE `events` SET `read` = '1'");

		
		if(count(explode("base64:", $result['action1'])) > 1)
		{
			$result["action1"] = base64_decode(str_replace("base64:", "", $result["action1"]));
			$result["action2"] = base64_decode(str_replace("base64:", "", $result["action2"]));
			$result["action3"] = base64_decode(str_replace("base64:", "", $result["action3"]));
			$result["action4"] = base64_decode(str_replace("base64:", "", $result["action4"]));
		}

		#echo strlen($result["action1"]);		

		//$result["action1"] = base64_decode($result["action1"]);



		$this->data['interact'] = $result;

		$this->data['title'] = $result[0]["title"];

		$this->load->view("event/interact", $this->data);
		
	}
	// Attempt at the NO REPEAT method. This will handle all events
	function method_handler($EventHandler)
	{


		if(empty($EventHandler)) { show_error("Argument Missing (var)"); }
		
		$search = $EventHandler;
		$var = explode("(", $search);


		switch($var[0])
		{
			case "doNothing":
				$doNothing = true;
			break;
			case "removeMoney":
				preg_match("/removeMoney\((.*?), '(.*?)'\)/", $search, $matches);
				$this->db->query("UPDATE `user` SET `money` = `money` - {$matches[1]} WHERE id = '{$this->userID}'");
				$this->log_transaction("Remove", $matches[1], $matches[2]);
			break;
			case "addMoney":
				preg_match("/addMoney\((.*?), '(.*?)'\)/", $search, $matches);
				$this->db->query("UPDATE `user` SET `money` = `money` + {$matches[1]} WHERE id = '{$this->userID}'");
				$this->log_transaction("Add", $matches[1], $matches[2]);
			break;
			case "timedEvent":
				// This will create a timed Event. Perhaps create a process?			
			break;
			case "addPatient":
				// Add a patient after he was cured. 2nd Argument will be Money
				preg_match("/addPatient\((.*?), '(.*?)'\)/", $search, $matches);
				$this->db->query("UPDATE `user` SET `money` = `money` + {$matches[2]}, `patientsCured` = `patientsCured` + {$matches[1]} WHERE id = '{$this->userID}'");

				$this->log_transaction("Add", $matches[2], "1");
			break;
			case "addFriend":
				preg_match("/addFriend\((.*?)\)/", $search, $matches);
				print_r($matches);
			break;
			default:
				show_error("Incorrect Argument. Argument: {$var[0]}");
			break;
		}
		return $this;
	}

	function set_event_read($eventID) { 
		$this->db->query("UPDATE `events` SET `read` = '1' WHERE `id` = '{$eventID}'"); 
		return $this;
	}

	// The Method Scripting Language, Oh hai!
	function method($eventID, $actionID)
	{
		if(!is_numeric($eventID) | !is_numeric($actionID)) { show_error("EventID and ActionID must be numeric!"); }
		$query = $this->db->query("SELECT * FROM `events` WHERE `uid` = '{$this->userID}' AND `id` = '{$eventID}'");
		$result = $query->result_array();
	
		$result = $result[0];

		if($result["read"] == "0")
		{

			if($result['action1'] != "") { $action[1] = $result['action1']; }
			if($result['action2'] != "") { $action[2] = $result['action2']; }
			if($result['action3'] != "") { $action[3] = $result['action3']; }
			if($result['action4'] != "") { $action[4] = $result['action4']; }


			if(!isset($action[ $actionID ])) { show_error("Invalid ActionID"); }
			else
			{
				// Time to parse the actions!

				if(count(explode("base64:", $action[$actionID])) > 1)
				{
					$action[$actionID] = base64_decode(str_replace("base64:", "", $action[$actionID]));
				}
				$exec = unserialize($action[$actionID]);
	
				//var_dump($action[$actionID]);

				// QuickFix for some errors i made during my coding....
				$exec["Random"]["PositiveAction"] = $exec["Random"]["PositiveEvent"];
				$exec["Random"]["NegativeAction"] = $exec["Random"]["NegativeEvent"];
				// If its a Random Event then were doing some advanced stuff
				if($exec['Event'] == "random")
				{
						$rnd = rand( $exec['Random']['From'], $exec['Random']['To'] );
						// Check that it is within the range.
						if($rnd >= $exec['Random']['MoreThan'] && $rnd <= $exec['Random']['LessThan'])
						{
							$this->method_handler($exec['Random']['PositiveAction'])->set_event_read($eventID);
							$this->highlight($exec["Random"]["PositiveMessage"])->reload_data();
						}
						else
						{
							$this->method_handler($exec['Random']['NegativeAction'])->set_event_read($eventID);
							$this->highlight($exec["Random"]["NegativeMessage"])->reload_data();
						}
				} else 
				{
					$this->method_handler($exec["Event"])->set_event_read($eventID);
					$this->highlight($exec['Text'])->reload_data();
					
				}
				$this->interact($eventID);
			}
		}
		else
		{
			show_error("You may not repeat this action");
		}
	}

	function events()
	{
		$this->log();
	}

}
