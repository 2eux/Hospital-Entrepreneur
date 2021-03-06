<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
class resourceHandler
{
	// Make sure we only register a resource ONCE
	var $resourcesRegistered	=	array();
	
	public function __construct()
	{
	$this->ci =& get_instance();
	}
	public function parse()
	{
		$userID =  $this->ci->authlib->getUserId();
		
		$query		=	$this->ci->db->query("SELECT id,created,user_name,email,money,resource1Diff,resource2Diff,resource3Diff FROM `user` where `id` = '{$userID}'");
		$result		=	$query->result_array();
		$result		=	$result[0];
		
		$time		= 	time();
		$created	=	$this->convert_datetime($result['created']);
		
		$timeDiff	=	$time - $created;

		// Calculate the amount of resources.
			// Buildings generating resources:
				// 1 - Resource1
				// 2 - Resource2
				// 3 - Resource3
			
		// Get the number of resources each resource building generates.
		$nmQuery	=	$this->ci->db->query("SELECT action_production, id FROM `buildings` WHERE `id` <= '3' ORDER BY `id` ASC");
		$nmResult	=	$nmQuery->result_array();
				
		// Put the production data into nice variables.
		$x = 1;	$z = 0;
		foreach($nmResult as $row)
		{
			$prRes[$x]	=	explode(';',$nmResult[$z]['action_production']);
			$prRes[$x]	=	$prRes[$x][$z];
			
			$x++; $z++;
		}
		
		// Check if the buildings are already built.
		$query		=	$this->ci->db->query("SELECT * FROM `buildings_built` WHERE `uid` = '{$userID}' and `end_time` < '".time()."' ORDER BY `level` DESC");
		$rsResult	=	$query->result_array();
		foreach($rsResult as $row)
		{
			switch($row['bid'])
			{
				case "1":
					$this->_resourceHandler($row['bid'], $timeDiff, $result['resource1Diff'], $row['level'], $prRes[1]);
				break;
				case "2":
					$this->_resourceHandler($row['bid'], $timeDiff, $result['resource1Diff'], $row['level'], $prRes[2]);
				break;
				case "3":
					$this->_resourceHandler($row['bid'], $timeDiff, $result['resource1Diff'], $row['level'], $prRes[3]);
				break;
				default:
				// Do nothin
				break;
			}
		}
		
		$postTemplate = array(	'resource1' =>	$this->resourcesRegistered[1],
								'resource2'	=>	$this->resourcesRegistered[2],
								'resource3'	=>	$this->resourcesRegistered[3],
								'money'		=>	$result['money']
							 );
		// Throw info: $this->ci->load->vars( ARRAY );
		$this->resources = $postTemplate;
		$this->ci->load->vars($postTemplate);
	}
	private function _resourceHandler($resourceId, $timeDifference, $userDifference, $level, $actionProduction)
	{
		// Turn time difference from seconds to hours.
		$timeDifference = $timeDifference / 60 / 60;
		
		
		// Check if we havn't already added that resource building.
		if(!array_key_exists($resourceId, $this->resourcesRegistered))
		{
			$math 									= ( $timeDifference * $level * $actionProduction ) + $userDifference;
			$this->resourcesRegistered[$resourceId] = round($math);
		}
	}
	private function convert_datetime($str) 
	{
	
		list($date, $time) = explode(' ', $str);
		list($year, $month, $day) = explode('-', $date);
		list($hour, $minute, $second) = explode(':', $time);
		
		$timestamp = @mktime($hour, $minute, $second, $month, $day, $year);
		
		return $timestamp;
	}
}
*/
?>
