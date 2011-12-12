<?php

class Front extends Controller
{
	public $layout = 'main';
	public $resources;
	public $data	= array();
	public $error	= array();

	public function __construct()
	{
		parent::Controller();
		if($this->authlib->isValidUser() == true)
			redirect("overview"); 
	}

	function index()
	{
		
		$this->data['title'] = "Overview";	

		$query = $this->db->query("SELECT * FROM `gameNews` ORDER BY `publish` DESC LIMIT 5");
		$this->data['latestNews'] = $query->result_array();
		$query = $this->db->query("SELECT * FROM `events` ORDER BY `ID` DESC LIMIT 5");
		$this->data['latestEvents'] = $query->result_array();
		$query = $this->db->query("SELECT * FROM `user` ORDER BY `stockValue` DESC LIMIT 5");
		$this->data['top5'] = $query->result_array();

		$website = $this->config->item("base_url");

		$forum = file_get_contents($website."index.php/skipauth/parseForum");
		$this->data['forum'] = $forum;

		$this->load->view('main_website/index', $this->data);
	}

}
