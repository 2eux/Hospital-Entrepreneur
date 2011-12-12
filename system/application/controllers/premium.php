<?php

class Premium extends MY_Controller
{
	
	private $numPills = 0;
	private $minPill;

	public function __construct()
	{

		parent::MY_Controller();

		$query = $this->db->query("SELECT numPills as pills, id FROM user WHERE id = '{$this->userID}'");
		$result = $query->result_array();

		$this->numPills = $result[0]['pills'];
		$this->data['numPills'] = $this->numPills;

	}

	function index()
	{
		$this->buy();
	}
	function cancel()
	{
		$this->load->view('premium/cancel', $this->data);
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

		$unSerialized = serialize($_POST);
		$this->db->query("UPDATE `log_paypal` SET `PayPalOutput` = '{$unSerialized}' WHERE `Hash` = '{$_POST[custom]}'");

		$this->data['pp_info'] = $_POST;
		$this->load->view('premium/success', $this->data);
	}
	function log()
	{
		$query = $this->db->query("SELECT * FROM `log_paypal` WHERE `UserID` = '{$this->userID}' ORDER BY `time` DESC");
		$result = $query->result_array();

		$this->data['transactions'] = $result;
		$this->load->view("premium/log", $this->data);
	}
	function spend()
	{
		$this->load->view("premium/spend", $this->data);
	}
	// This is the configuration for the different premium features
	private function premiumLookup($type,$pills, $currentMoney)
	{
		
		$expire = time() + (60 * 60 * 24 * 60);
		$this->date = date("Y-m-d", $expire);


		switch($type)
		{
			case "bronze_package":
				$this->minPill = 500;
				$this->name = "Bronze Package";
				$this->statementTrue = array(	"salaryPayment" => "95",
							"ptsCuredMultiplier" => "1.5",
							"stkValueMultiplier" => "1.5",
							"premiumPackage" => "2",
							"premiumExpire" => $this->date,
							"money" => ($currentMoney + 500000),
							"numPills" => ($pills - 500)
							);
				$this->money = 500000;
			break;
			case "silver_package":
				$this->minPill = 1500;
				$this->name = "Silver Package";
				$this->statementTrue = array(	"salaryPayment" => "90",
							"ptsCuredMultiplier" => "2",
							"stkValueMultiplier" => "2.5",
							"premiumPackage" => "3",
							"premiumExpire" => $this->date,
							"money" => ($currentMoney + 1500000),
							"numPills" => ($pills - 1500)
							);
				$this->money = 1500000;
			break;
			case "gold_package":
				$this->minPill = 2500;
				$this->name = "Gold Package";
				$this->statementTrue = array(	"salaryPayment" => "82.5",
							"ptsCuredMultiplier" => "2.5",
							"stkValueMultiplier" => "4.5",
							"premiumPackage" => "4",
							"premiumExpire" => $this->date,
							"money" => ($currentMoney + 2500000),
							"numPills" => ($pills - 2500)
							);
				$this->money = 2500000;
			break;
			default:
				$this->data["error"] = 1;
				$this->data["error_message"] = "Error. No Package selected";
				$this->spend();
			break;
		}

		if($pills >= $this->minPill && !isset($this->data["error"])) {


			#$this->db->set("user", $this->statementTrue)->where('id', $this->userID);
	
			$this->db->query("UPDATE `user` SET `numPills` = `numPills` - {$this->minPill}, `money` = '{$this->statementTrue[money]}', `premiumExpire` = '{$this->date}', `premiumPackage` = '{$this->statementTrue[premiumPackage]}', `ptsCuredMultiplier` = '{$this->statementTrue[ptsCuredMultiplier]}', `stkValueMultiplier` = '{$this->statementTrue[stkValueMultiplier]}', `salaryPayment` = '{$this->statementTrue[salaryPayment]}' WHERE `id` = '{$this->userID}'");


			$this->data["upgrade"] = $this->statementTrue;
			$this->data["package_name"] = $this->name;
			$this->data["money"] = $this->money;


			return true;		
		}
		else {
			return false;
		}
	}
	function spend_submit($pack)
	{
		$pills = $this->db->query("SELECT * FROM `user` WHERE `id` = '{$this->userID}'");
		$result = $pills->result_array();
		$result = $result[0];

		$pill = $result["numPills"];
		$money = $result["money"];

		$x = $this->premiumLookup($pack, $pill, $money);

		if($x)
		{
			$this->data['premium'] = "true";
		}
		else
		{
			$this->data["premium"] = "false";
		}

		$this->MY_Controller();
		$this->load->view("premium/success_premium.php", $this->data);

	}
	function buy()
	{

		$this->data['userID'] = $this->userID;

		$this->load->view("premium/buy", $this->data);
	}

}
