<?php

class Skipauth extends Controller
{
	public $layout = 'xml';

	public function __construct()
	{
		parent::Controller();
	

	}

	function index()
	{
		
	}
	
	function alpha_numeric($str)
	{
		return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}

	function hospital_name()
	{
		$var = $_GET['hospital_name'];
		
		if($this->alpha_numeric($var))
		{
			$query = $this->db->query("SELECT id, user_name, user_alias FROM `user` WHERE `user_alias` = \"{$_GET[hospital_name]}\"");
		
			if($query->num_rows() > 0) {
				echo "false";
			} else {
				echo "true";
			}
		} else {
			echo "true";
		}
		

	}
	function username()
	{
		$var = $_GET['user_name'];
		
		if($this->alpha_numeric($var))
		{
			$query = $this->db->query("SELECT id, user_name FROM `user` WHERE `user_name` = \"{$_GET[user_name]}\"");
		
			if($query->num_rows() > 0) {
				echo "false";
			} else {
				echo "true";
			}
		} else {
			echo "true";
		}
		

	}
/*
	function parseForum($num=5)
	{

		$dir = dirname(__FILE__);
		$split = explode("/system/", $dir);
		$fullPath = $split[0];

		include("{$fullPath}/forum/SSI.php");

		$array = ssi_recentTopics($num, '', 'array');

		#echo "<pre>";
		#print_r($array);
		#echo "</pre>";
	

		echo "<ul class=\"list_forum list_forum_latest\">";
		foreach($array as $topic)
		{
			echo "<li><span class='topic_header'><img src=\"/template/images/icons/comments.png\" />{$topic[link]}</span><span class='topic_forum'>by {$topic[poster][link]} in {$topic[board][link]}</span></li>";
		}
		echo "</ul>";


		$this->layout = "xml";

	}
*/
	function parseForum()
	{
		$this->layout = "xml";

		$objXML = new DOMDocument();
		$objXML->load( $this->config->item("base_url"). "/forum/ssi.php?a=out&f=1,2,3,4,5&show=10&type=rss");

		$posts = $objXML->getElementsByTagName("item");

		echo "<ul class=\"list_forum list_forum_latest\">";
		foreach($posts as $post)
		{
			// @Data: Last Poster and Forum
			$descs	= $post->getElementsByTagName("description");
			$desc	= $descs->item(0)->nodeValue;

			$explode = explode("<br />", $desc);
			// @Data: Title and Link
			$titles = $post->getElementsByTagName("title");
			$title	= $titles->item(0)->nodeValue; 

			$links = $post->getElementsByTagName("comments");
			$link	= $links->item(0)->nodeValue; 


			$topic["poster"]["link"] = str_replace('Last Poster: ', '', $explode[1]);
			$topic["board"]["link"] = str_replace('Forum: ', '', $explode[0]);
			$topic["link"] = "<a href=\"{$link}\">{$title}</a>";
			echo "<li><span class='topic_header'><img src=\"/template/images/icons/comments.png\" />{$topic[link]}</span><span class='topic_forum'>by {$topic[poster][link]} in {$topic[board][link]}</span></li>";
		}
		echo "</ul>";
	}

	function getLastNewsID()
	{
		$query = $this->db->query("SELECT * FROM `gameNews` ORDER BY `id` DESC LIMIT 1");
		$result = $query->result_array();

		echo $result[0]['id'];
	}

}
