<?php

class Research extends MY_Controller
{
	  public $layout = 'xml';

  public function __construct()
  {
    parent::MY_Controller();
				
	$this->data['title'] = 'Research facility';
 
  }

  public function index()
  {
	
	/* Load necessary scripts. FIXME: make it possible to load an array of scripts */
	$this->loadscript('treelib/jquery.tree');
	$this->loadscript('game/research');

	$this->data['research_menu'] = $this->menu_generate();

	/* Print template */
    $this->load->view('constructions/research', $this->data);
  }

  public function xml($type,$id)
  {
    $this->layout = 'xml';
    // If the xml we are going to load is research info
	if($type == 'research')
	{
        // check that it is numeric
		if(!is_numeric($id))
        {
           // if not, try to convert it to one
           $id = explode(',',$id);
           $id = $id[1];
        }
        // if that doesn't work, then throw out a error
        if(!is_numeric($id))
        {
           show_error('Please do not attempt to use non numeric values as ID');
        }
        // Now get the item information ; )
        $query = $this->db->query("SELECT * FROM `research` WHERE `id` = '{$id}'");
        if($query->num_rows() > 0)
        {
			$research = $query->result_array();
			
			$sql = $this->db->query("SELECT * FROM `research_completed` WHERE `rid` = '{$id}' AND `uid` = '{$this->userID}'");
			$res = $sql->result_array();
			if($sql->num_rows() > 0)
			{
				$research[0]['completed'] = '1'; 
			}
			else
			{
				$research[0]['completed'] = '0';
			}
			
			$res = $this->db->query("SELECT end_time, uid FROM `research_completed` WHERE `end_time` > '".time()."' AND `uid` = '{$this->userID}' LIMIT 1;");
			if($res->num_rows() > 0)
			{
				$result = $res->result_array();
				$this->data['researching']			= "true";
				$this->data['researchingEndTime']	= secondtoword($result[0]['end_time'] - time());
			}

            $this->data['research'] = $research;
			$this->load->view('constructions/research_information' , $this->data);

        }
        else
        {
             show_error("ID {$id} does not exist in the database");
        }

	}
  }

  public function menu_generate()
  {

	$output = "<ul>";
    // Find research already completed.
    $done = $this->db->query("SELECT id, rid, uid, end_time FROM `research_completed` WHERE `uid` = '{$this->userID}'");
    $done = $done->result_array();
	$researchingArray = array();
    foreach($done as $row)
    {
		// Check that the research is completed			
		if($row['end_time'] < time())
		{
			// If it is. Set this value to true
        	$search[$row['rid']] = "TRUE";
		}
		else
		{
			// If not add a new category. In that category we have research that is being worked @
			$researching = true;
			$result = $this->db->query("SELECT name,id FROM `research` WHERE `id` = '{$row[rid]}'");
			$result = $result->result_array();
			$result = $result[0];
			$researchingArray = array('id' => $row['rid'], 'name' => $result['name']);
		}
    }

	if($researching == true)
	{
		$output .= "<li id=\"cat_0\" rel=\"investigating\"><a href=\"#\"><ins>&nbsp;</ins>Currently researching:</a>\n<ul>\n";
		$output .= "<li id=\"item_{$researchingArray[id]}\" rel=\"item_investigating\"><a href=\"#\"><ins>&nbsp;</ins>{$researchingArray[name]}</a></li>\n";
		$output .= "</ul>";
	}

	// First order by category THEN list the sub items.
	$query = $this->db->query("SELECT * FROM `research_category` ORDER BY `name`");
	$query = $query->result_array();
	foreach($query as $result)
	{
		$output .= "<li id=\"cat_{$result[id]}\" rel=\"category\"><a href=\"#\"><ins>&nbsp;</ins>{$result[name]}</a>\n<ul>\n";
		$query_sub = $this->db->query("SELECT * FROM `research` WHERE `cid` = '{$result[id]}' ORDER BY `name`");
		$query_sub = $query_sub->result_array();
		foreach($query_sub as $row)
		{
			if($search[$row['id']] == "TRUE") { $item = "item_done"; } elseif($researchingArray['id'] == $row['id']) { $item = "item_investigating"; } else { $item = "item"; }
			$output .= "<li id=\"item_{$row[id]}\" rel=\"{$item}\"><a href=\"#\"><ins>&nbsp;</ins>{$row[name]}</a></li>\n";
		}
		$output .="</ul>\n";
	}
	$output .= "</ul>";

	return $output;

  }
} 
