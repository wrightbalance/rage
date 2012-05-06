<?php

class Notif_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function notifcount()
	{
		$account_id = $this->session->userdata('accountid');
		
		$this->mongo_db->where(array('account_id'=>$account_id,'type'=>2))->count('notif_count');
	}
}
