<?php

class Stocks extends MY_Controller
{
	public $layout = 'default';

	public $maxStocks = 1000000;

	public function __construct()
	{
		parent::MY_Controller();

		// Your stocks
		$query = $this->db->query("select `s`.*, `u`.`id`, `u`.`user_name`, `u`.`user_alias`, `u`.`stockValue` FROM `stocks` as `s`, `user` as `u` WHERE `s`.`cUID` = '{$this->userID}' AND `u`.`id` = `s`.`pUID`");
		$result = $query->result_array();

		$this->loadscript("user/stocks");
		$this->loadscript("jquery.form");

		foreach($result as $r)
		{
			$this->data['user_stock'][$r['pUID']] = $r;
			$this->totalStocks = $r['amount'] + $this->totalStocks;
		}		

	}
	function index()
	{
		
		$this->data['title'] = "Stock Market :: Overview";	

		// Top 10 stocks
		$query = $this->db->query("SELECT * FROM `user` ORDER BY `stockValue` DESC LIMIT 10");
		$this->data['top10'] = $query->result_array();
		//$this->data['user_stock'] = $query->result_array();
		
		$this->data['totalStocks'] = $this->totalStocks;

		$this->load->view('stocks/index', $this->data);
	}
	function memberslist()
	{
		$this->data['title'] = "Stock Market :: Memberslist";

		$query = $this->db->query("SELECT * FROM `user` ORDER BY `id` ASC");
		$result = $query->result_array();

		$this->data['member'] = $result;
		$this->load->view("stocks/memberlist", $this->data);
	}

	function myStocks()
	{
		$this->data['title'] = "Stocks Market :: My Stocks";

		$this->data['totalStocks'] = $this->totalStocks;
	
		$this->load->view("stocks/list", $this->data);
	}
	function stockholders()
	{
		$this->data['title'] = "Stock Market :: Stockholders";

		$query = $this->db->query("SELECT s.* , u.* FROM stocks as s, user as u WHERE pUID = '{$this->userID}' AND u.id = s.cUID");
		$result = $query->result_array();
		$num = $query->num_rows();

		$this->data['userID'] = $this->userID;
		$this->data['stocks_result'] = $result;
		$this->data['stocks_num'] = $num;

		$this->load->view("stocks/stockholders", $this->data);

	}

	function getStocks($pUID)
	{
		$query = $this->db->query("SELECT s.* , u.* FROM stocks as s, user as u WHERE cUID = '{$this->userID}' AND u.id = s.cUID AND s.pUID = '{$pUID}'");
		$this->layout = "xml";
		$result = $query->result_array();
		$result = $result[0];

		if($result['amount'] == "") { $result['amount'] = 0; }

		echo $result['amount'];
	}
	function getStockValue($pUID)
	{
		$query = $this->db->query("SELECT s.* , u.* FROM stocks as s, user as u WHERE cUID = '{$this->userID}' AND u.id = s.cUID AND s.pUID = '{$pUID}'");
		$this->layout = "xml";
		$result = $query->result_array();
		$result = $result[0];
		echo number_format( $result["amount"] * $result['stockValue'] , 2, ',', ' ');
	}
	function ajax_buy_stocks($pUID)
	{
		$amount = $this->input->post('amount');
		$price = $this->input->post('price');
		$this->layout = "xml";
		if(!is_numeric($amount)) { echo "Amount of stocks must be numeric"; }
		else
		{
			if($pUID == $this->userID)
			{
				echo "You may not buy stocks in your own company!";
			}
			else
			{
				$totalStocks = $this->totalStocks + $amount;

				if($totalStocks > $this->maxStocks)
				{
					echo "You may not purchase more then a total of 1 000 000 stocks";
				}
				else
				{
					$x = $this->data['user_stock'][$pUID]["amount"];
					$x_bar = $x + $amount;
					if($x_bar > 200000)
					{
						echo "You may not purchase more than a total of 200 000 stocks in each company";
					}
					else
					{
						$tPrice = $amount * $price;

						$ttPrice = $tPrice * 0.05;
				// FIXME: Check the users money.
						$xPrice = $ttPrice + $tPrice;

						$query = $this->db->query("SELECT * FROM user WHERE id = '{$this->userID}'");
						$result = $query->result_array();

						$result = $result[0];
		
						$money = $result['money'];

						if($money < $xPrice) {
							echo "Error! Insufficent funds!";
						}
						else
						{

							if($x == null || $x == "" || $x == 0)
							{
											$this->db->insert('stocks', array("pUID" => $pUID,
																			  "cUID" => $this->userID,
																			  "amount" => $amount,
																			  "time" => time()));
							}
							else
							{
								$this->db->query("UPDATE `stocks` SET `amount` = `amount` + {$amount} WHERE `pUID` = '{$pUID}' AND `cUID` = '{$this->userID}'");
							}
								$xPrice = $tPrice + $ttPrice;
								$this->db->query("UPDATE `user` SET `money` = `money` - {$xPrice} WHERE `id` = '{$this->userID}'");

								$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
																				"transactionType" => "Remove",
																				"money" => $tPrice,
																				"contentType" => 7,
																				"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$tPrice} WHERE `id` = '{$this->userID}'; UPDATE `stocks` SET `amount` = `amount` - {$amount} WHERE `pUID` = '{$pUID}' AND `cUID` = '{$this->userID}'",
																				"time" => time(),
																				"ip" => $_SERVER['REMOTE_ADDR']) );
								$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
																				"transactionType" => "Remove",
																				"money" => $ttPrice,
																				"contentType" => 12,
																				"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$ttPrice} WHERE `id` = '{$this->userID}';",
																				"time" => time(),
																				"ip" => $_SERVER['REMOTE_ADDR']) );

								echo "Success! You've successfully purchased <b>{$amount}</b> Stocks";
							}
						}
					}
			} 
		}
	}
	function ajax_sell_stocks($pUID)
	{
		$amount = $this->input->post('amount');
		$price = $this->input->post('price');
		$this->layout = "xml";
		if(!is_numeric($amount)) { echo "Amount of stocks must be numeric"; }
		else
		{
 // 1: Find out how many stocks the user has
				 // 2: Find out how many stocks the user are going to sell
				 // 3: Update the amount of stocks OR delete the row
				 // 4: Give the user the money

				// 1:
				$query = $this->db->query("SELECT s.*, u.id, u.stockValue, u.user_alias FROM `stocks` as s, `user` as u WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}' AND pUID = u.id");

				$result = $query->result_array();
				$result = $result[0];

				// 2:
				if($amount >= $result['amount'])
				{
					$amount = $result['amount'];
				}

				$totalAmount = $result['amount'] - $amount; 

				$incMoney = $amount * $result['stockValue'];

				#show_error("INCMoney Value: {$incMoney} <br />Other Values: " . print_r($result));

				if($totalAmount == 0)
				{
					$this->db->query("DELETE FROM `stocks` WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}'");
					$this->db->query("UPDATE `user` SET `money` = `money` + {$incMoney} WHERE `id` = '{$this->userID}'");

					echo "Success! You have sold <b>{$amount}</b> of stocks. <b>{$incMoney}</b> have been transfered to your account";

					unset($this->data['user_stock']);
				}
				else
				{
					$this->db->query("UPDATE `stocks` SET `amount` = $totalAmount WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}'");
					$this->db->query("UPDATE `user` SET `money` = `money` + {$incMoney} WHERE `id` = '{$this->userID}'");
					echo "Success! You have sold <b>{$amount}</b> of stocks. <b>{$incMoney}</b> have been transfered to your account";
				}

		}
	}
	function buy_stocks($pUID,$ajax="false")
	{
		$amount = $this->input->post('amount');
		$price = $this->input->post('price');
		if(!is_numeric($amount) && $ajax == "false") { show_error("Amount must be a numeric number"); }

		if($pUID == $this->userID)
		{
			$this->data['error'] = 1;
			$this->data['error_message'] = "You may not buy stocks in your own company!";
			

			$this->__construct();						
			$this->myStocks();
		}
		else
			{
	//----------------------------------------- //
	//-- Stocks Modification : Allow Selling -- //
	//----------------------------------------- //
			if($this->input->post('Sell') == 'Sell')
			{
				 // 1: Find out how many stocks the user has
				 // 2: Find out how many stocks the user are going to sell
				 // 3: Update the amount of stocks OR delete the row
				 // 4: Give the user the money

				// 1:
				$query = $this->db->query("SELECT s.*, u.id, u.stockValue, u.user_alias FROM `stocks` as s, `user` as u WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}' AND pUID = u.id");
				$result = $query->result_array();
				$result = $result[0];

				// 2:
				if($amount >= $result['amount'])
				{
					$amount = $result['amount'];
				}

				$totalAmount = $result['amount'] - $amount; 

				$incMoney = $amount * $result['stockValue'];

				if($totalAmount == 0)
				{
					$this->db->query("DELETE FROM `stocks` WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}'");
					$this->db->query("UPDATE `user` SET `money` = `money` + {$incMoney} WHERE `id` = '{$this->userID}'");

					$this->data['highlight'] = 1;
					$this->data['highlight_message'] = "Transaction was successful. You've sold <b>{$amount}</b> stocks. <br /> There have been <b>{$incMoney}$</b> transfered to your account and you are left with <b>zero</b> stocks in <b>{$result[user_alias]}</b>";
					unset($this->data['user_stock']);
				}
				else
				{
					$this->db->query("UPDATE `stocks` SET `amount` = $totalAmount WHERE `cUID` = '{$this->userID}' AND `pUID` = '{$pUID}'");
					$this->db->query("UPDATE `user` SET `money` = `money` + {$incMoney} WHERE `id` = '{$this->userID}'");

					$this->data['highlight'] = 1;
					$this->data['highlight_message'] = "Transaction was successful. You've sold <b>{$amount}</b> stocks. <br /> There have been <b>{$incMoney}$</b> transfered to your account and you are left with <b>{$totalAmount}</b> of stocks in <b>{$result[user_alias]}</b>";
				}


				$query = $this->db->query("select `s`.*, `u`.`id`, `u`.`user_name`, `u`.`user_alias`, `u`.`stockValue` FROM `stocks` as `s`, `user` as `u` WHERE `s`.`cUID` = '{$this->userID}' AND `u`.`id` = `s`.`pUID`");
				$result = $query->result_array();
				foreach($result as $r)
				{
					$this->data['user_stock'][$r['pUID']] = $r;
					$this->totalStocks = $r['amount'] + $this->totalStocks;
				}
				$this->load->view("stocks/list", $this->data);
		
			}
			else
			{
				$totalStocks = $this->totalStocks + $amount;

				if($totalStocks > $this->maxStocks)
				{
					$this->data['error'] = 1;
					$this->data['error_message'] = "You may not purchase more then a total of 1 000 000 stocks";
					$this->__construct();						
					$this->myStocks();
				}
				else
				{
					$x = $this->data['user_stock'][$pUID]["amount"];
					$x_bar = $x + $amount;
					if($x_bar > 200000)
					{
						$this->data['error'] = 1;
						$this->data['error_message'] = "You may not purchase more than a total of 200 000 stocks in each company";
						$this->__construct();						
						$this->myStocks();
					}
					else
					{
						$tPrice = $amount * $price;

						$ttPrice = $tPrice * 0.05;
				// FIXME: Check the users money.
						$xPrice = $ttPrice + $tPrice;

						$query = $this->db->query("SELECT * FROM user WHERE id = '{$this->userID}'");
						$result = $query->result_array();

						$result = $result[0];
		
						$money = $result['money'];

						if($money < $xPrice) {
							$this->data['error'] = 1;
							$this->data['error_message'] = "Insufficient Funds!";
							$this->__construct();						
							$this->myStocks();
						}
						else
						{

							if($x == null || $x == "" || $x == 0)
							{
											$this->db->insert('stocks', array("pUID" => $pUID,
																			  "cUID" => $this->userID,
																			  "amount" => $amount,
																			  "time" => time()));
							}
							else
							{
								$this->db->query("UPDATE `stocks` SET `amount` = `amount` + {$amount} WHERE `pUID` = '{$pUID}' AND `cUID` = '{$this->userID}'");
							}
								$xPrice = $tPrice + $ttPrice;
								$this->db->query("UPDATE `user` SET `money` = `money` - {$xPrice} WHERE `id` = '{$this->userID}'");

								$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
																				"transactionType" => "Remove",
																				"money" => $tPrice,
																				"contentType" => 7,
																				"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$tPrice} WHERE `id` = '{$this->userID}'; UPDATE `stocks` SET `amount` = `amount` - {$amount} WHERE `pUID` = '{$pUID}' AND `cUID` = '{$this->userID}'",
																				"time" => time(),
																				"ip" => $_SERVER['REMOTE_ADDR']) );
								$this->db->insert('log_transactions', array( 	"userid" => $this->userID,
																				"transactionType" => "Remove",
																				"money" => $ttPrice,
																				"contentType" => 12,
																				"reverseSQL" => "UPDATE `user` SET `money` = `money` + {$ttPrice} WHERE `id` = '{$this->userID}';",
																				"time" => time(),
																				"ip" => $_SERVER['REMOTE_ADDR']) );

								$this->data['highlight'] = 1;
								$this->data['highlight_message'] = "Success! You've successfully purchased <b>{$amount}</b> Stocks";
								$this->__construct();						
								$this->myStocks();
							}
						}
				}
			}
		}
	}

}
