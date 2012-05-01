<?php

class Cms extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		checkSession();
		$admin = $this->session->userdata('groupid');
		
		if($admin < 90) show_404;
		
	}
	
	function index()
	{
		
	}
}
