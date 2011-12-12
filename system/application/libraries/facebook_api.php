<?php
/**
 * CodeIgniter Facebook Connect Library (http://www.haughin.com/code/facebook/)
 * 
 * Author: Elliot Haughin (http://www.haughin.com), elliot@haughin.com
 * 
 * VERSION: 1.0 (2009-05-18)
 * LICENSE: GNU GENERAL PUBLIC LICENSE - Version 2, June 1991
 * 
 **/


	include(APPPATH.'libraries/facebook/facebook.php');

	class Facebook_api {

		private $_obj;
		private $_app_key		= NULL;
		private $_secret_key		= NULL;
		
		public $fb;
		
		public $user	=	NULL; // Current User
		//public $userID	=	NULL;

		function Facebook_api()
		{
			$this->_obj =& get_instance();

			$this->_obj->load->config('facebook');
			$this->_obj->load->library('db_session');
			
			$this->_app_key		= $this->_obj->config->item('facebook_app_key'); // This is changed
			$this->_secret_key	= $this->_obj->config->item('facebook_secret_key');

			$this->fb = new Facebook(array('appId' => $this->_app_key, 'secret' => $this->_secret_key, 'cookie' => true));

			

			//$this->client = $this->fb->api_client;
			
			//$this->user_id = $this->fb->get_loggedin_user();

			$this->_manage_session();

			if ( $this->user_id !== NULL )
			{
				
			}
		}

		private function _manage_session()
		{

			$session = $this->fb->getSession();			

			if($session)
			{
				$this->userID 	= $this->fb->getUser();
				$this->user	= $this->fb->api("/me");
			} catch (facebookApiException $e) {
				error_log($e);
			} 
			/*
			$user = $this->_obj->db_session->userdata('facebook_user');

			if ( $user === FALSE && $this->user_id !== NULL )
			{
				$profile_data = array('uid','first_name', 'last_name', 'name', 'locale', 'pic_square', 'profile_url');
				$info = $this->fb->api_client->users_getInfo($this->user_id, $profile_data);

				$user = $info[0];

				$this->_obj->db_session->set_userdata('facebook_user', $user);
			}
			elseif ( $user !== FALSE && $this->user_id === NULL )
			{
				// Need to destroy session
			}

			if ( $user !== FALSE )
			{
				$this->user = $user;
			}
			*/
		}
	}
