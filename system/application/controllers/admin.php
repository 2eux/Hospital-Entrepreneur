<?php

class Admin extends MY_Controller
{
	public $layout = 'default';

	public function __construct()
	{
		parent::MY_Controller();
		

		#if($this->data['authLevel'] !== "Admin")
			#show_error("You may not access this page!");


		$this->loadscript("admin/admin_general");
		$this->loadscript("jquery.ingrid");

	}

	function server_status()
	{
		$this->data["title"] = "Admin Panel :: Service Status";


	$this->load->view("admin/server_status", $this->data);

	}
	function index()
	{
		

		$this->data['title'] = "Admin Panel :: Overview";	
		$query = $this->db->query("SELECT l.*, u.id as uid, u.user_alias, u.user_name FROM `log_admin` as l, `user` as `u` WHERE l.adminID = u.id ORDER BY l.id DESC LIMIT 20");
		$result = $query->result_array();
		
		$this->data['log'] = $result;


		$this->load->view("admin/overview", $this->data);

	}

	function log($page=1)
	{
		$this->data['title'] = "Admin Panel :: Log";

		$query = $this->db->query("SELECT * FROM `log_admin`");
		$num = $query->num_rows();


		$pNullValue 	= 0;
		$pPerSideValue 	= 5;
		$pMaxStdValue	= $pPerSideValue;

		$pMaxPages		= ceil($num/$pPerSideValue);

		#if($page < 1) { $page = 1; }
		#if($page > $pMaxPages) { $page = $pMaxPages; }

		$p0 = ($page - 1) * $pPerSideValue;
		$pX = $pPerSideValue;

		$query = $this->db->query("SELECT l.*, u.id as uid, u.user_alias, u.user_name FROM `log_admin` as l, `user` as `u` WHERE l.adminID = u.id ORDER BY l.id DESC LIMIT {$p0}, {$pX}");
		
		$this->data['log'] = $query->result_array();

		$this->data['page']['max'] = $pMaxPages;
		$this->data['page']['current'] = $page;
		$this->data['page']['previous'] = ($page - 1);
		$this->data['page']['next'] = ($page + 1);
		$this->data['page']['first'] = 1;
		$this->data['page']['last'] = $pMaxPages;


		$this->load->view("admin/log", $this->data);

	}

	function ads()
	{


		$query = $this->db->query("SELECT * FROM `adverts` ORDER BY `ExpireyDate`");
		$result = $query->result_array();

		$this->data['result'] = $result;
		$this->load->view("ads/ads", $this->data);

	}

	function ads_add()
	{

			$this->data["submitText"] = "Add Advertisement";
			$this->data["form"] = "ads_add_post";
			$this->load->view("ads/form", $this->data);
	}

	function ads_add_post()
	{
		unset($_POST["submit"]);

			foreach($_POST as $key => $variable)
			{
				$data[$key] = $variable;
			}
			
			$data["AdvertisingSpot"] = "default_top";

			$this->db->insert("adverts", $data);

			$log = array("adminID" => $this->userID, "module" => "advert", "action" => "Add Advert", "time" => time(), "content" => "Added a new advertisement", "debug" => serialize($data));
			$this->db->insert("log_admin", $log);

			$this->data["highlight"] = "1";
			$this->data["highlight_message"] = "You've successfully added an new advertisement.";

			$this->ads();
	}

	function ads_edit_post($id)
	{
			unset($_POST["submit"]);

			$data = array();

			foreach($_POST as $key => $variable)
			{
				$data[$key] = $variable;
			}
			
			$data["AdvertisingSpot"] = "default_top";

			$this->db->query("UPDATE `adverts` SET `ClientName` = '{$data[ClientName]}', `imageSrc` = '{$data[imageSrc]}', `ExpireyDate` = '{$data[ExpireyDate]}' WHERE `id` = '{$id}'");

			$log = array("adminID" => $this->userID, "module" => "advert", "action" => "Update", "time" => time(), "content" => "Updated Advertisement ({$id})", "debug" => serialize($data));
			$this->db->insert("log_admin", $log);

			$this->data["highlight"] = "1";
			$this->data["highlight_message"] = "You've successfully updated the advertisement.";

			$this->ads();
	}

	function ads_edit($id)
	{
		if(!is_numeric($id)) { show_error("ID Must be numeric"); }



			$query = $this->db->query("SELECT * FROM `adverts` WHERE `id` = '{$id}'");
	
			if($query->num_rows() == 0) { show_error("Hmm...That must be deleted or something...Atleast theres no data for it!"); } else {
				$result = $query->result_array();
				$result = $result[0];

				foreach($result as $key => $data)
				{
					$this->data[$key] = $data;
				}

				$this->data["form"] = "ads_edit_post/{$id}";
				$this->data["submitText"] = "Update Advertisement";
				$this->load->view("ads/form", $this->data);

	

		}
	}

	function ads_delete($id)
	{

	}

	function log_html($page=1)
	{
		$this->layout = "xml";

		$query = $this->db->query("SELECT * FROM `log_admin`");
		$num = $query->num_rows();


		$pNullValue 	= 0;
		$pPerSideValue 	= 5;
		$pMaxStdValue	= $pPerSideValue;

		$pMaxPages		= ceil($num/$pPerSideValue);

		#if($page < 1) { $page = 1; }
		#if($page > $pMaxPages) { $page = $pMaxPages; }

		$p0 = ($page - 1) * $pPerSideValue;
		$pX = $pPerSideValue;

		$query = $this->db->query("SELECT * FROM `log_admin` ORDER BY `id` DESC LIMIT {$p0}, {$pX}");
		$this->data['report'] = $query->result_array();

		$this->load->view("admin/log_html", $this->data);
	}

}
