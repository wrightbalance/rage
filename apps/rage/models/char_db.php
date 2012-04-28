<?php

class Char_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function getOnline($limit=999)
	{
		$this->db->where('c.online',1);
		$this->db->join('login l','l.account_id = c.account_id');
		$this->db->limit($limit);
		$query = $this->db->get('char c');
		
		$result = $query->result_array();
		
		return $result;
	}
	
	function topPlayer($limit=100)
	{
		$this->db->order_by('kills','desc');
		$this->db->limit($limit);
		$pvpquery = $this->db->get('pvpm_data');
		
		return $pvpquery->result_array();
	}
}
