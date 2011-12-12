<?php
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * Paypal controller that provides functionality to the creation for PayPal forms, 
 * submissions, success and cancel requests, as well as IPN responses.
 *
 * The class requires the use of the PayPal_Lib library and config files.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

class Paypal extends Controller {

	function Paypal()
	{
		parent::Controller();
		$this->load->library('Paypal_Lib');
	}
	
	function index()
	{
		$this->form();
	}
	
	function form()
	{
		
		$this->paypal_lib->add_field('business', 'arni1348@gmail.com');
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', 'UserID:3 Pills:100 Money:0'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', '100x Pills');
	    $this->paypal_lib->add_field('item_number', '100-1');
	    $this->paypal_lib->add_field('amount', '10');

		// if you want an image button use this:
		$this->paypal_lib->image('button_03.gif');
		
		// otherwise, don't write anything or (if you want to 
		// change the default button text), write this:
		// $this->paypal_lib->button('Click to Pay!');
		
	    $this->data['paypal_form'] = $this->paypal_lib->paypal_form();
	
		$this->load->view('paypal/form', $this->data);
        
	}


	function auto_form($userID, $pills, $money)
	{

		switch($pills)
		{
			default: $amount = 0; break;
			case '0': $amount = 0; break;
			case '250': $amount = 10; break;
			case '750': $amount = 25; break;
			case '1500': $amount = 35; break;
			case '2500': $amount = 50; break;
		}
		switch($money)
		{
			default: $amount = $amount; break;
			case '0': $amount = $amount; break;
			case '1000000': $amount = 10; break;
			case '5000000': $amount = 20; break;
			case '10000000': $amount = 35; break;
			case '25000000': $amount = 50; break;
		}

		if($amount == 0)
			show_error("Amount is Zero. Theres an error somewhere");

		$hash = substr( md5( time() ) , 0 , 16 );

		$custom = array("UserID" => $userID, "Pills" => $pills, "Money" => $money, "Time" => time(), "IP" => $_SERVER['REMOTE_ADDR'], "Hash" => $hash, "TransactionStatus" => "Processing", "PayPalOutput" => "", "PayPalIPN" => "", "PayerStatus" => "");
		$this->db->insert('log_paypal', $custom);


		$this->paypal_lib->add_field('business', 'arni1348@gmail.com');
	    $this->paypal_lib->add_field('return', site_url('premium/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('premium/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', $hash); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Hospital Entrepreneur');
	    $this->paypal_lib->add_field('item_number', '0');
	    $this->paypal_lib->add_field('amount', $amount);

	    $this->paypal_lib->paypal_auto_form();
	}


	function cancel()
	{
		$this->load->view('paypal/cancel', $this->data);
	}
	

	function success()
	{
		// This is where you would probably want to thank the user for their order
		// or what have you.  The order information at this point is in POST 
		// variables.  However, you don't want to "process" the order until you
		// get validation from the IPN.  That's where you would have the code to
		// email an admin, update the database with payment status, activate a
		// membership, etc.
	
		// You could also simply re-direct them to another page, or your own 
		// order status page which presents the user with the status of their
		// order based on a database (which can be modified with the IPN code 
		// below).

		$this->data['pp_info'] = $_POST;
		$this->load->view('paypal/success', $this->data);
	}
	
	function ipn()
	{
		// Payment has been received and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,
		// etc. You can access a slew of information via the ipn_data() array.
 
		// Check the paypal documentation for specifics on what information
		// is available in the IPN POST variables.  Basically, all the POST vars
		// which paypal sends, which we send back for validation, are now stored
		// in the ipn_data() array.
 
		// For this example, we'll just email ourselves ALL the data.
		$to    = 'arni1348@gmail.com';    //  your email
				
		//------------------------------------------------------------



		//------------------------------------------------------------

		if ($this->paypal_lib->validate_ipn()) 
		{
			$body  = 'An instant payment notification was successfully received from ';
			$body .= $this->paypal_lib->ipn_data['payer_email'] . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";

			foreach ($this->paypal_lib->ipn_data as $key=>$value)
				$body .= "\n$key: $value";
	
			// Update the users DB
			$hash = $this->paypal_lib->ipn_data['custom'];
			$query = $this->db->query("SELECT * FROM `log_paypal` WHERE `Hash` = '{$hash}' LIMIT 1");
			$result = $query->result_array();
			$result = $result[0];
			if($result['Money'] > 0)
			{
				$this->db->query("UPDATE `user` SET `money` = `money` + {$result[Money]} WHERE id = '{$result[UserID]}' LIMIT 1;");
				log_message('debug', "{$result[Money]} $ transfered to UserID {$result[UserID]}");
			}
			elseif($result['Pills'] > 0)
			{
				$this->db->query("UPDATE `user` SET `numPills` = `numPills` + {$result[Pills]} WHERE id = '{$result[UserID]}' LIMIT 1;");
				log_message('debug', "{$result[Pills]} P transfered to UserID {$result[UserID]}");
			}
			else
			{
				log_message('error', "Something happened when trying to update the user. Both the pills and the money value where missign");
			}

			$ppIPN = serialize($this->paypal_lib->ipn_data);

			$this->db->query("UPDATE `log_paypal` SET `PayPalIPN` = '$ppIPN',`TransactionStatus` = 'Completed', `PayerStatus` = '{$this->paypal_lib->ipn_data[payer_status]}' WHERE `Hash` = '{$hash}'");


			// Send Mail to Admin
			$adminID = 3; // AdminID

			$mail = array("uid" => $adminID, "fromuid" => 0, "from" => "PayPal IPN", "title" => "An instant payment notification was successfully received from {$this->paypal_lib->ipn_data[payer_email]} on ".date('d/m/Y') . ' at ' . date ('H:i:s')."", "content" => $body, "actionButton" => 0, "time" => time(), "ip" => "255.255.255.255", "useragent" => "PayPal IPN Service", "read" => "0", "priority" => 1);

			$this->db->insert('mail', $mail);

		}
	}
}
?>
