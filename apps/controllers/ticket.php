<?php 

class Ticket extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ticket_db');
	}
}
