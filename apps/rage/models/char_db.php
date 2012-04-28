<?php

class Char_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getOnline()
	{
		$this->db->where('c.online',1);
		$this->db->join('login l','l.account_id = c.account_id');
		$query = $this->db->get('char c');
		
		$result = $query->result_array();
		
		return $result;
	}
}
