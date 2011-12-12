<?php

class User extends MY_Controller
{
	public $layout = 'default';

  
	public function __construct()
	{
		parent::MY_Controller();


		if($this->data['authLevel'] == "Admin") {
			$this->loadscript("admin/general");
		}

	}
	// Memberslist perhaps?
	public function index()
	{
		$this->profile($this->userID);

	}
	// Show A profile
	public function profile($id="")
	{
		if($id == "") { $id = $this->userID; }
  		if(!is_numeric($id))
		{
			show_error("ID Must be numeric");
		}

		$query = $this->db->query("SELECT *, (SELECT COUNT(*) FROM `employees_hired` WHERE `uid` = '{$id}') as numEmployee FROM `user` WHERE `id` = '{$id}'");
		$this->data['user'] = $query->result_array();
		$query = $this->db->query("SELECT `d`.`id` as `uid`, `d`.`hospitalID`, `d`.`hospitalArea`, `h`.`id` as `hid`, `h`.`title`, `h`.`unlock` FROM `user` as `d`, `hospital` as `h` WHERE `d`.`id` = '{$id}' AND `hospitalID` = `h`.`id`");
		$this->data['hospital'] = $query->result_array();

		if($id == $this->userID) { $this->data['myProfile'] = true; }

		$this->load->view("user/profile", $this->data);
	}

	public function ban($id)
	{
  		if(!is_numeric($id))
		{
			show_error("ID Must be numeric");
		}

		$this->db->query("UPDATE `user` SET `activated` = '0' WHERE `id` = '{$id}' LIMIT 1;");

		$this->data['highlight'] = 1;
		$this->data['highlight_message'] = "User have been banned.";

					$log = array("adminID" => $this->userID, "module" => "user", "action" => "ban", "time" => time(), "content" => "Banned User (ID: {$id})", "debug" => "null");
					$this->db->insert("log_admin", $log);

		$this->profile($id);

	}
	public function unban($id)
	{
  		if(!is_numeric($id))
		{
			show_error("ID Must be numeric");
		}

		$this->db->query("UPDATE `user` SET `activated` = '1' WHERE `id` = '{$id}' LIMIT 1;");

		$this->data['highlight'] = 1;
		$this->data['highlight_message'] = "User have been unbanned.";

					$log = array("adminID" => $this->userID, "module" => "user", "action" => "ban", "time" => time(), "content" => "Unbanned User (ID: {$id})", "debug" => "null");
					$this->db->insert("log_admin", $log);

		$this->profile($id);

	}


	// Edit Profile Settings
	public function edit($id=null)
	{
		if($id == null) { $id = $this->userID; }

		if($id !== null && $this->data['authLevel'] !== "Admin" && $id !== $this->userID)
		{
			show_error("You need Administrator Priviledges to do this");
		}

		if(	$this->data['authLevel'] == "Admin" && $id !== $this->userID || 
			$this->data['authLevel'] == "Admin" && $id !== null)
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$id}'");
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		}

		$result = $query->result_array();

		$this->data['result'] = $result[0];

		$this->load->view("user/edit_default", $this->data);
	}

	public function editPOST()
	{
		
		if(!isset($_POST)) { show_error("Missing POST Variables"); }

		if(	$this->data['authLevel'] == "Admin" && isset($_POST['id']))
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$_POST[id]}'");
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		}

		$result = $query->result_array();
		$result = $result[0];

		if(!isset($_POST["newsletter"])) $_POST["newsletter"] = 0;
		if(!isset($_POST["notifyDisabled"])) $_POST["notifyDisabled"] = 1;

		foreach($_POST as $key => $value)
		{
			if(isset($result[$key]) && $result[$key] == $value)
			{
				//echo "** RESULT[{$key}] == {$value} <br />";
			}
			else
			{
				$output[$key] = $value;
			}
		}


		if(!isset($_POST['id'])) { $_POST['id'] = $this->userID; }
		if( empty($_POST['password']) || empty($_POST['password_repeat']))
		{
			unset($output['password'], $output['password_repeat']);
		}

		if( empty($_POST['avatar_link']) || $_POST['avatar_link'] == "http://")
		{
			unset($output['avatar_link']);
		}

		unset($output['submit']);

		

		if($_POST['password'] !== $_POST['password_repeat'])
		{
			$this->data['error'] = 1;
			$this->data['error_message'] = "Password and Repeat Password did not match. Please try again";
			$this->edit($_POST['id']);
		}
		else
		{
			if(count($output) == 0)
			{
				$this->data['highlight'] = 1;
				$this->data['highlight_message'] = "Nothing have been updated.";
				$this->edit($_POST['id']);
			}
			else
			{

				unset($output['password_repeat']);


				foreach($output as $key => $value)
				{
					if($key == "password") { $value = $this->encrypt->hash($value, "sha1"); }
					$sql .= "`{$key}` = '{$value}', ";
				}

				$sql = substr($sql, 0, -2);



				$query = "UPDATE `user` SET {$sql} WHERE `id` = '{$_POST[id]}' LIMIT 1;";
				$this->db->query($query);
				
				#echo $query . "<br />";
				#echo sha1("123qwe");

				if(	$this->data['authLevel'] == "Admin")
				{
					$log = array("adminID" => $this->userID, "module" => "user", "action" => "editPOST", "time" => time(), "content" => "Updated Profile (ID: {$_POST[id]})", "debug" => serialize($_POST));
					$this->db->insert("log_admin", $log);
				}

				$this->data['highlight'] = 1;
				$this->data['highlight_message'][] = "The Profile have successfully been updated";
				$this->MY_Controller();
				$this->edit($_POST['id']);
			}
		}
	}
} 
