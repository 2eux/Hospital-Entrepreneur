<?php

class Overview extends MY_Controller
{
	public $layout = 'default';

	public function __construct()
	{
		parent::MY_Controller();
	

	}
	function newsletter()
	{
	
		$query = $this->db->query("SELECT newsletter, id, user_name, email FROM `user` WHERE `newsletter` = '1'");
		$this->load->library('email');		

		ob_start();

		$this->layout = "xml";

		foreach($query->result_array() as $row)
		{
			flush();
			$this->data["user_name"] = $row["user_name"];
		

			$message = $this->load->view("email/advertise", $this->data, true);

			$email = $row["email"];
			$subject = "Letters to users";

			$this->email->clear();
			$this->email->from($this->config->item('user_support'), $this->lang->line('auth_email_from_name'));
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->mailtype = "html";
			$this->email->alt_message = "";
			//$this->email->send();

			echo "Sent Email to: {$email} <br />";			
			ob_flush();

		}


	}
	function index()
	{
		
		$this->data['title'] = "Overview";	
		$query = $this->db->query("SELECT * FROM `log_transactions` WHERE `userid` = '{$this->userID}' AND `contentType` != '1' ORDER BY `id` DESC LIMIT 10");
		$log1 = $query->result_array();
		

		#$log[] = $array;
		#$log = array_merge($log, $log1);

		$this->data['log_transactions'] = $log1; #array_merge($array, $log1);

		$website = $this->config->item("base_url");

		$forum = file_get_contents($website."index.php/skipauth/parseForum");
		$this->data['forum'] = $forum;


		$events = $this->db->query("SELECT * FROM `events` WHERE `uid` = '{$this->userID}' AND `read` = '0' ORDER BY `time` DESC LIMIT 8");
		$this->data['events'] = $events->result_array();

		$query = $this->db->query("SELECT * FROM `gameNews` ORDER BY `publish` DESC LIMIT 5;");
		$result = $query->result_array();

		$this->data['news'] = $result;

		$this->load->view('overview', $this->data);
	}
	
	function events()
	{
		show_error("The Error Reports Function have not yet been started on. <br /><br /><b>Progress: 0%</b>");
	}

	function load($collum)
	{
		if($collum == "password")
			show_error("You are not allowed to load password out of the database");


		$this->layout = "xml";		

		$sql = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}';");
	

		$query = $sql->result_array();

		#print_r($query);

		$this->data["output"] = $query[0][$collum];
		$this->load->view("text", $this->data);
	}
	function ajax_post($function)
	{
		switch($function)
		{
			case "mail":
				// Set mail as read
				if(!is_numeric($_POST['mail'])) { show_error("ERROR: MailID incorrect"); }
				$this->db->query("UPDATE `mail` SET `read` = '1' WHERE `uid` = '{$this->userID}' AND `id` = '{$_POST[mail]}'");
				echo "OK";
			default:
				echo "ERROR: Wrong / Not existent function!";
			break;
		}
	}

	function trialok()
	{
		$this->highlight("You've successfully upgraded from trial account to full account");
		$this->index();
	}

	function allHospitals()
	{
		$query = $this->db->query("SELECT * FROM `user`");
		$result = $query->result_array();

		foreach($result as $r)
		{
			echo $this->_getUserWorth($r['id']) . "<br />";
		}
	}
	// FIXME: Loads of maths here!
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
	function users_xml()
	{
		$this->layout = "xml";
		header("Content-Type: text/xml");

		$userName = $this->authlib->getUserName();

		$user = $this->db->query("SELECT * FROM `user` WHERE DATE_SUB(NOW(), INTERVAL 5 MINUTE) <= last_visit AND `user_name` != '{$userName}'");
		$num =	$user->num_rows();

		echo "
<xml>
	<userOnline>{$num}</userOnline>";

		foreach($user->result_array() as $key => $result)
		{
			echo "<user><name>{$result[user_name]}</name><status>online</status><id>{$result[id]}</id></user>\n";

		}

		$query = $this->db->query("SELECT id, money, hospitalArea FROM `user` WHERE `id` = '{$this->userID}'");
		$result = $query->result_array();
		$result = $result[0];

		echo "\n<userdata>";
		foreach($result as $key => $value)
			echo "\t<{$key}>{$value}</{$key}>\n";
		echo "</userdata>\n";


		$query = $this->db->query("SELECT id, notifyDisabled FROM `user` WHERE `id` = '{$this->userID}'");
		$result = $query->result_array();
	
		if($result[0]["notifyDisabled"] == "0")
		{
			$events = $this->db->query("SELECT * FROM `events` WHERE `read` = '0' AND `uid` = '{$this->userID}' ORDER BY `id` DESC LIMIT 5");
			$result = $events->result_array();
			echo "<events>";
			foreach($result as $data)
			{
				echo "
<event>		
	<name>{$data[title]}</name>
	<link>http://www.hospital-entrepreneur.com/index.php/event/interact/{$data[id]}</link>
	<id>{$data[id]}</id>
	<icon>{$data[icon]}</icon>
</event>";
			}
			echo "</events>";
		}
echo "
</xml>";
	}
	function ajax_xml()
	{
		$this->layout = "xml";
		header("Content-Type: text/xml");

		$query = $this->db->query("SELECT money, patientsCured as patients, hospitalID, hoursInGame, hospitalArea, id FROM `user` WHERE `id` = '{$this->userID}'");
		$result = $query->result_array();
		$result = $result[0];

		$query = $this->db->query("SELECT * FROM `mail` WHERE `uid` = '{$this->userID}' AND `read` = '0'");
		$mail = $query->result_array();	

		$result['money'] = number_format($result['money'], 2, ',', ' ');

		$hospitalWorth = number_format($this->_getUserWorth(), 2, ',', ' ');

		$this->data["output"] = "
<xml>
	<info>
		<money>{$result[money]}</money>
		<patients>{$result[patients]}</patients>
		<area_left>{$result[hospitalArea]}</area_left>
		<uid>{$this->userID}</uid>
		<hospital_id>{$result[hospitalID]}</hospital_id>
		<hospital_worth>{$hospitalWorth}</hospital_worth>
		<hours>{$result[hoursInGame]}</hours>
	</info>
	<mail>";
		

		foreach($mail as $row) {
$this->data['output'] .= "
		<unread_mail id=\"{$row[id]}\">";
			foreach($row as $key => $val)
			{
				if($key == "time") { $val = date("H:i:s d-m-Y", $val); }
				#if($key == "content") { $val = nl2br($val); }
				$this->data['output'] .= "<{$key}>{$val}</{$key}>";
			}
		$this->data['output'] .= "</unread_mail>";
		}
$this->data['output'] .= "
	</mail>
</xml>";

		$this->load->view("text", $this->data);
	}
}
