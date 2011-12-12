<?php
/**
 * Auth Controller Class
 *
 * Security controller that provides functionality to handle logins and logout
 * requests.  It also can verify the logged in status of a user and permissions.
 *
 * The class requires the use of the NativeSession and Sentry libraries.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Security
 * @author      Jaapio
 * @copyright   Copyright (c) 2006, fphpcode.nl
 *
 */
class Auth extends Controller
{
	// ** MOD: Enable Layout **
	public $layout = 'auth';
	public $data = array();
	// ** EOM **
    function Auth()
    {
        parent::Controller();
        $this->obj =& get_instance(); 
        $this->lang->load('sentry');
        $this->load->model('Usermodel');
        $this->load->library('validation');
		$this->validation->set_error_delimiters($this->config->item('auth_error_delimiter_open'), $this->config->item('auth_error_delimiter_close'));
		
		$fields[$this->config->item('auth_user_name_field')] = $this->lang->line('auth_user_name_label');
        $fields[$this->config->item('auth_user_password_field')] = $this->lang->line('auth_user_password_label');
        $fields[$this->config->item('auth_user_password_confirm_field')] = $this->lang->line('auth_user_password_confirm_label');
        $fields[$this->config->item('auth_user_email_field')] = $this->lang->line('auth_user_email_label');
        $fields[$this->config->item('auth_user_autologin_field')] = $this->lang->line('auth_user_autologin_label');
        $fields[$this->config->item('auth_user_security_code_field')] = $this->lang->line('auth_user_security_code_label');
        
        if ($this->config->item('auth_use_country'))
            $fields[$this->config->item('auth_user_country_field')] = $this->lang->line('auth_user_country_label');
        
        //additionalFields($fields);
        
        $this->validation->set_fields($fields);
    }

	//
	// Creates a temporarily user account
	//
	function temp()
	{
		$chr = substr( md5( time() + rand(2,200) / 1 ) ,0 , 6);

		$this->load->library("encrypt");

		// Check that no account currently exists. If it does then login to that instead.
		$query = $this->db->query("SELECT * FROM `user` WHERE `refeer` = '{$_SERVER[REMOTE_ADDR]}' AND `trial` = '1' ORDER BY `id` DESC");
		$num = $query->num_rows();
		if($num > 1) {
			$result = $query->result_array();
			$usr = $result[0];

			$data["user_name"] = $usr["user_name"];
			$pwd = explode("_", $usr["user_name"]);

			$data["password"] = $pwd[1];

			if(count($pwd) != 2) { $this->data["error"] = "You've already created an trial account and upgraded it. Have you <a href='/index.php/auth/forgotten_password'>Forgot the password?</a>"; }

			$this->data["reg"] = $data;
		} else {
			// Default character data
			$data["user_name"] = "tmp_{$chr}";
			$data["user_alias"] = $data["user_name"] . "s Hospital";
			$data["password"] = $this->encrypt->hash($chr, "md5");
			$data["email"] = "tmp_{$chr}@hospital-entrepreneur.com";
			$data["country_id"] = "0";
			$data["security_role_id"] = 2;
			$data["money"] = 500000;
			$data["hospitalID"] = 1;
			$data["hospitalArea"] = "500";
			$data["stocksRemaining"] = "1000000";
			$data["salaryPayment"] = "100";
			$data["ptsCuredMultiplier"] = 1;
			$data["stkValueMultiplier"] = 1;
			$data["tutorialStage"] = 1;
			$data["premiumPackage"] = 0;
			$data["createdReal"] = date("Y-m-d H:i:s", time());
	
			// Trial account data
			$data["refeer"] = $_SERVER["REMOTE_ADDR"];
			$data["trial"] = 1;
			$data["trialExpire"] = time() + (60*60*24); // 24h
			$data["activated"] = 1;
	
			$query = $this->db->insert("user", $data);
	
			$data["chr"] = $chr;

			$this->data["reg"] = $data;
		}

		$this->layout = "xml";

		$this->load->view("auth/temp", $this->data);
		

	}
	//
	// Turning a temp account into a full account
	//
	function temp_full()
	{
		if(!isset($_POST)) {
			$uid = $this->authlib->getUserId();
			$query = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$uid}'");
			$data = $query->result_array(); $data=$data[0];

			$this->load->view("auth/temp_full", $this->data);
		} else {
			//print_r($_POST);

			$num = count($_POST);
			if($num == 6) { // everything is correct.
				
				if($_POST["password"] == $_POST["password_confirm"]) { // goodie
					$this->load->library("encrypt");

					$_POST["password"] = $this->encrypt->hash($_POST["password"], "md5");
					unset($_POST["password_confirm"], $_POST["register"]);

					$_POST["trial"] = 0;
					$_POST["trialExpire"] = "";
					$_POST["newsletter"] = 1;

					$this->db->where("id", $this->authlib->getUserId() )->update("user", $_POST);

					redirect("overview/trialok");
				} else {
					echo "Email no match";
				}
			} else {
				echo "Please fill in all the fields";
				$this->load->view("auth/temp_full", $this->data);
			}


		}
	}

	function temp_full_ok()
	{
		$this->load->view("auth/temp_ok", $this->data);
	}

    //
    // Handles the user activation.
    //
    function activation()
    {
        if ($this->authlib->activation($this->uri->segment(3, 0), $this->uri->segment(4, '')))
            $this->load->view($this->config->item('auth_register_activation_success_view'));
        else
            $this->load->view($this->config->item('auth_register_activation_failed_view'));
    }
    
    //
    // Handles the post from the forgotten password form.
    //
    function forgotten_password()
    {
        $rules[$this->config->item('auth_user_email_field')] = "trim|required|valid_email|xss_clean";
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->forgotten_password())
            $this->load->view($this->config->item('auth_forgotten_password_success_view'));
        else
        {
            $this->obj->db_session->flashdata_mark();
            $this->load->view($this->config->item('auth_forgotten_password_view'));
        }
    }
    
    //
    // Displays the forgotten password reset.
    //
    function forgotten_password_reset()
    {
        if ($this->authlib->forgotten_password_reset($this->uri->segment(3, 0), $this->uri->segment(4, '')))
            $this->load->view($this->config->item('auth_forgotten_password_reset_success_view'));
        else
            $this->load->view($this->config->item('auth_forgotten_password_reset_failed_view'));
    }

    //
    // Displays the login form.
    //
    function index()
    {
        $this->load->view($this->config->item('auth_login_view'));
    }
    
    //
    // Handles the post from the login form.
    //
    function login()
    {
		if(isset($_POST['register'])) { redirect("/auth/register"); }

		//print_r($_POST);

        $rules[$this->config->item('auth_user_name_field')] = $this->config->item('auth_user_name_field_validation_login');
        $rules[$this->config->item('auth_user_password_field')] = $this->config->item('auth_user_password_field_validation_login');
        
        //additionalLoginRules($rules);
        
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->login()) {
            redirect($this->config->item('auth_login_success_action'), 'location');
		}
        else
        {
           # print_r($this->db_session->flashData);
			
			#$this->data['error_message'] = $this->db_session->flashData["AUTH_STATUS"];
			#$this->data['error'] = 1;
			$this->db_session->sess_gc();

            $this->index();
        }
    }

    //
    // Handles the logout action.
    //
    function logout()
    {
        $this->authlib->logout();
    }
    
    //
    // Handles the post from the registration form.
    //
    function register()
    {
        $rules[$this->config->item('auth_user_name_field')] = $this->config->item('auth_user_name_field_validation_register');
        $rules[$this->config->item('auth_user_password_confirm_field')] = $this->config->item('auth_password_required_confirm_validation')."|matches[".$this->config->item('auth_user_password_field')."]";
        $rules[$this->config->item('auth_user_password_field')] = $this->config->item('auth_user_password_field_validation_register');
        $rules[$this->config->item('auth_user_email_field')] = $this->config->item('auth_user_email_field_validation_register');
        
        if ($this->config->item('auth_use_country'))
            $rules[$this->config->item('auth_user_country_field')] = $this->config->item('auth_user_country_field_validation_register');
        
        //additionalRegistrationRules($rules);
         
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->register())
        {
            $this->load->view($this->config->item('auth_register_success_view'));
        }
        else
        {
            $this->db_session->flashdata_mark();
            $this->register_index();
        }
    }
    
    //
    // Displays the registration form.
    //
    function register_index()
    {


	$data['jQuery'][] = "<script type=\"text/javascript\" language=\"javascript\" src=\"/template/js/jquery.uniform.js\"></script>";
	$data['jQuery'][] = "<script type=\"text/javascript\" language=\"javascript\" src=\"/template/js/jquery.validator.js\"></script>";
	$data['jQuery'][] = "<link type='text/css' href='/template/css/form.css' rel='stylesheet'></link>";

        $countries = null;            
        if ($this->config->item('auth_use_country'))
            $countries = $this->Usermodel->getCountries();
        
        if ($this->config->item('auth_use_security_code'))
            $this->authlib->register_init();
                    $data['countries'] = $this->Usermodel->getCountries();
        $this->load->vars($data);      
        $this->load->view($this->config->item('auth_register_view'));
    }
    
    //
	// RULES HELPER FUNCTION
	//
	// Password validation callback
	//
	function password_check($value)
	{
	    return $this->_is_valid_text('password_check', $value, $this->obj->config->item('auth_user_password_min'), $this->obj->config->item('auth_user_password_max'));
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// Security code validation callback.
    //
    function securitycode_check($value)
	{
	    if ($this->obj->config->item('auth_use_security_code'))
	    {
    	    $securityCode = $this->obj->session->userdata('auth_security_code');
    	    if (strcmp($value, $securityCode) != 0)
    	    {
    	        $this->validation->set_message('securitycode_check', $this->obj->lang->line('auth_in_use_validation_message'));
    		    return false;
    		}
    	}
		
		return true;
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// User name validation callback.
    //
    function username_check($value)
	{
	    return $this->_is_valid_text('username_check', $value, $this->obj->config->item('auth_user_name_min'), $this->obj->config->item('auth_user_name_max'));
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// User name duplicate validation callback.
    //
    function username_duplicate_check($value)
	{
	    //Use the input username and password and check against 'users' table
        $this->obj->db->where($this->obj->config->item('auth_user_name_field'), $value);
        $query = $this->obj->db->get($this->obj->config->item('auth_user_table_name'));

        if (($query != null) && ($query->num_rows() > 0))
	    {
	        $this->validation->set_message('username_check', $this->obj->lang->line('auth_in_use_validation_message'));
		    return false;
		}
		
		return true;
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// Determines if a input text has valid characters and meets min/max length requirements.
    //
    function _is_valid_text($callback, $value, $min = 4, $max = 16, $invalid_message = null, $expression = '/^([a-z0-9])([a-z0-9_\-])*$/ix')
	{
	    $message = '';
	    if ((strlen($value) < $min) ||
	        (strlen($value) > $max))
	        $message .= sprintf($this->obj->lang->line('auth_allowed_characters_validation_message'), $min, $max);
	        
	    if (!preg_match($expression, $value))
	        $message .= $this->obj->lang->line('auth_allowed_characters_validation_message');
		
		if ($message != '')
		{
		    if (!isset($invalid_message))
		        $invalid_message = $this->obj->lang->line('auth_invalid_validation_message');
		    $this->validation->set_message($callback, $invalid_message.$message);
	        return false;
		}
		
		return true;
	}
}
?>
