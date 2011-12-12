<?php

class Mail extends MY_Controller
{
	public $layout = 'default';

	public function __construct()
	{
		parent::MY_Controller();
	}

	function index()
	{
		$this->listMails();
	}

	function listMails()
	{
		$query = $this->db->query("SELECT * FROM `mail` WHERE `uid` = '{$this->userID}' AND `read` != '-1' ORDER BY `id` DESC");
		$this->data['mail'] = $query->result_array();


		$this->load->view('mail/list', $this->data);
	}

	function reply($id)
	{
		$query = $this->db->query("SELECT * FROM `mail` WHERE `id` = '{$id}' AND `uid` = '{$this->userID}'");
		$result = $query->result_array();

		$this->data['data']['to'] = "{$result[0][from]}";
		$this->data['data']['title'] = "Re: {$result[0][title]}" ;

		$this->newMail();
	}
	function newMail($sendTo=null)
	{
		$this->loadscript("game/autocomplete");
		$this->loadscript("game/mail");

		if($sendTo !== null) { $this->data["data"]['to'] = $sendTo; }

		$this->load->view("mail/new", $this->data);
	}
	function ajaxUsername()
	{
		$query = $_GET['q'];
		if($query == "") { }
		else { 
			$sql = $this->db->query("SELECT * FROM `user` WHERE `user_name` LIKE '{$query}%'");
			$result = $sql->result_array();
			foreach($result as $r)
			{
				$output .= "{$r[user_name]}\n";
			}
			
			$output = substr($output, 0, -1);
			$output = substr($output, 0);

			$this->layout = "xml";
			$this->data['xml_output'] = $output;
			$this->load->view("xml", $this->data);
		}
	}
	function sendMail()
	{
		if(!$_POST) { show_error("No POST data sent"); }

		// POST DATA
		$title	=	$this->input->post("mail_title");
		$to		=	$this->input->post("mail_to");
		$fromID	=	$this->userID;
		$from	=	$this->authlib->getUserName();
		$text	=	$this->input->post("message");
		$ip		=	$_SERVER['REMOTE_ADDR'];
		$usrA	=	$_SERVER['HTTP_USER_AGENT'];
		$time	=	time();

		$this->data['data'] = array('to' => $to, 'title' => $title, 'message' => $text);

		if(strlen($to) == 0)
		{
			$this->data['error'] = 1;
			$this->data['error_message'][] = "You must write the username to send the mail too";
			$this->data['error_field']['mail_to'] = "border-color: #FF0000; background-color: #FFCCCC";
		}
		if(strlen($text) == 0)
		{
			$this->data['error'] = 1;
			$this->data['error_message'][] = "Your Message can not be empty";
			$this->data['error_field']['message'] = "border-color: #FF0000; background-color: #FFCCCC";
		}
		if(strlen($title) == 0)
		{
			$this->data['error'] = 1;
			$this->data['error_message'][] = "Your title can not be empty";
			$this->data['error_field']['mail_title'] = "border-color: #FF0000; background-color: #FFCCCC";
		}

		if($this->data['error'] == 1)
		{
			$this->load->view("mail/new", $this->data);
		}
		else
		{
			$query = $this->db->query("SELECT id, user_name FROM `user` WHERE `user_name` = '{$to}'");
			$result = $query->result_array();
			
			$result = $result[0];
			$result['num'] = $query->num_rows();
			if($result['num'] == 0)
			{
				$this->data['error'] = 1;
				$this->data['error_field']['mail_to'] = "border-color: #FF0000; background-color: #FFCCCC;";
				$this->data['error_message'][] = "Username does not exist. Please check the spelling!";
				$this->load->view("mail/new", $this->data);
			}
			else
			{
				$this->data['data'] = array();
				$this->db->insert('mail', array(	"uid" => $result['id'],
													"from" => $from,
													'fromUID' => $fromID,
													'content' => $text,
													"title" => $title,
													"ip" => $ip,
													"useragent" => $usrA,
													"time" => $time,
													"read" => "0",
													"priority" => "0",
													"actionButton" => "0" ));
				$this->data['highlight'] = 1;
				$this->data['highlight_message'] = "Your mail have been sent to " . $this->input->post("mail_to");

				$this->listMails();
			}
		}
	}
	function deleteMail($id)
	{
		if(!is_numeric($id)) { show_error("Mail ID must be numeric"); }
		
		$this->data['mailID'] = $id;

		$this->load->view("mail/delete", $this->data);
		
	}
	function deleteEmailOK($id)
	{
		if(!is_numeric($id)) { show_error("Mail ID must be numeric"); }
		$query = $this->db->query("DELETE FROM `mail` WHERE `id` = '{$id}' AND `uid` = '{$this->userID}' LIMIT 1");

		$this->data['highlight'] = 1;
		$this->data['highlight_message'] = "The email have been deleted";
	
		$this->listMails();
	}
	function read($id)
	{
		if(!is_numeric($id)) { show_error("Mail ID must be numeric"); }

		$this->db->query("UPDATE `mail` SET `read` = '1' WHERE `id` = '{$id}' AND `uid` = '{$this->userID}' LIMIT 1");

		$query = $this->db->query("SELECT * FROM `mail` WHERE `uid` = '{$this->userID}' AND `id` = '{$id}'");
		$result = $query->result_array();
		$this->data['mail'] = $result[0];

		$this->load->view("mail/read", $this->data);

	}	
}
