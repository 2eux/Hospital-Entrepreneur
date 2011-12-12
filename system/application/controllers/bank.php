<?php

class Bank extends MY_Controller
{

  
  public function __construct()
  {
    parent::MY_Controller();
	$this->data['title'] = 'Euphemia Bank';



  }

  public function index()
  {



	$this->load->view("bank/index", $this->data);

  }
  
} 

