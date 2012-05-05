<?php

class Patcher extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('mongo_db');
		$this->load->model('cms_db');
	}
	
	function index()
	{
		$cond = array(
			'publish' => 1,
			'patcher' => 1
		);
		
		$data['cssgroup'] = "patcher";
		
		$data['news'] = $this->cms_db->getNews($cond);
		$this->load->view('patcher/news',$data);
	}
}
