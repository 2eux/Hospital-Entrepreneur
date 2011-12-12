<?php

class News extends Controller
{
	public $layout;
	public $data = array();

	public function __construct()
	{
		parent::Controller();

		if($this->authlib->getUserId() != "") {
					// Enable this when going to Beta
		#$this->output->enable_profiler(TRUE);
		$this->layout = "default";

		$this->data["skipJS"] = $skipJS;

		// JS Scripts to always load.
		//$this->loadscript('treelib/jquery.tree');
		if($skipJS == false)
		{
			$this->loadscript("game/general");
			$this->loadscript("jquery.tipsy");
			$this->loadscript("jquery.growl");
		$this->loadscript("jquery.colorfade");
		$this->loadscript("jquery.form");

		$this->loadscript("tiny_mce/jquery.tinymce");
		$this->loadscript("admin/news");
		$this->loadscript("admin/general");
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

		} else {
			$this->layout = "auth";
		}

		if($this->userID != "") { $this->data["loggedin"] = 1; }

	}

	function index()
	{
		$query = $this->db->query("SELECT * FROM `gameNews` ORDER BY `publish` DESC");
		$result = $query->result_array();

		$this->data['title'] = "News Articles";
		$this->data['info'] = $result;
		$this->load->view('news/list', $this->data);
	}

	function newArticle()
	{
		if($this->authlib->getSecurityRole() == "Admin")
		{
			$this->data['title'] = "New Article";
			$this->load->view("news/new", $this->data);
		}
		else
		{
			show_error("You do not have permission to do this!");
		}

	}

	function loadComments($id="")
	{

		if($id != "")
			$querySuplement = "WHERE `gameNews_comments`.`NewsID` = '{$id}'";

		$query = $this->db->query("SELECT * FROM `gameNews_comments` LEFT JOIN `user` ON `gameNews_comments`.`uid` = `user`.`id` {$querySuplement}");

		$num = $query->num_rows();

		if($num > 0)
		{
			$result = $query->result_array();

			return array("num" => $num, "c" => $result);
		} else {
			return "0";
		}
	}
		

	function comment($id = "")
	{
		if(is_numeric($this->userID))
		{
			if($_POST["comment"] != "")
			{
				$data = array( "uid" 		=> $this->userID,
								"newsID" 	=> $id,
								"replayToID" => "",
								"content"	=> $_POST["comment"],
								"time"		=> time(),
								"ip"		=> $_SERVER["REMOTE_ADDR"] );

				$this->db->insert("gameNews_comments" , $data);

				redirect("news/read/{$id}/ok");

			} else {
				show_error("You must write something in the comment");
			}
		} else {
			show_error("You must login to submit a comment");
		}
	}

	function delete($id, $completed=false)
	{
		if(!is_numeric($id)) { show_error("ID Must be numeric!"); }

		if($this->authlib->getSecurityRole() == "Admin") {
			if(!$completed == "true")
			{
				show_error("Non-Ajax Call have not been developed yet. <br /> Add /true to the end of the url to bypass this!");
			}
			else
			{
				$this->db->query("DELETE FROM `gameNews` WHERE `id` = '{$id}'");
				$this->layout = "xml";

				$log = array("adminID" => $this->userID, "module" => "news", "action" => "deleted article", "time" => time(), "content" => "Deleted Article (ID: {$id})", "debug" => serialize($_GLOBAL));
				$this->db->insert("log_admin", $log);
			}
		} else {
			show_error("You do not have permission to do this!");
		}
	}
	function listArticle() { $this->index(); } //Hot Fix
	function newArticlePOST()
	{
		if($this->authlib->getSecurityRole() == "Admin")
		{			
			$data = array(	"title" 		=> $_POST['title'],
							"author" 		=> $_POST['author'],
							"author_id" 	=> $_POST['author_id'],
							"publish"		=>	time(),
							"content_short"	=> $_POST['content_short'],
							"content_full"	=> $_POST['textarea_information']);

			$this->db->insert("gameNews", $data);

			$log = array("adminID" => $this->userID, "module" => "news", "action" => "created article", "time" => time(), "content" => "Created Article", "debug" => serialize($_POST));
			$this->db->insert("log_admin", $log);
			echo "OK";
		}
		else
		{
			echo "NOTADMIN";
		}
	}
	function read($id, $comment = "")
	{
		if(!is_numeric($id)) {
			show_error("ID Must be numeric");
		}
		$query = $this->db->query("SELECT * FROM `gameNews` WHERE `id` = '{$id}' LIMIT 1;");

		$num = $query->num_rows();
		if($num !== 1) {
			show_error("Incorrect News ID");
		}
		else
		{

			$result = $query->result_array();

			if($comment == "ok") $this->highlight("You successfully submitted the comment");


			$this->data['news'] = $result[0];
			$this->data['title'] = $result[0]["title"];
			$this->data["comments"] = $this->loadComments( $result[0]["id"] );
			$this->load->view("news/read", $this->data);

		}

	}
	function updateInfo()
	{
		if($this->authlib->getSecurityRole() == "Admin")
		{
			$data = array(	"title" 		=> $_POST['title'],
							"author" 		=> $_POST['author'],
							"author_id" 	=> $_POST['author_id'],
							"content_short"	=> $_POST['content_short'],
							"content_full"	=> $_POST['textarea_information']);

			$this->db->where('id', $_POST['pageID']);
			$this->db->update('gameNews', $data);

					$log = array("adminID" => $this->userID, "module" => "news", "action" => "update article", "time" => time(), "content" => "Updated Article (ID: {$_POST[pageID]})", "debug" => serialize($_POST));
					$this->db->insert("log_admin", $log);

			echo "OK";
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
	function highlight($text)
	{
		$this->data['highlight'] = 1;
		$this->data['highlight_message'] = $text;
		return $this;
	}
}
