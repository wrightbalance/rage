<?php

class Accounts_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('mongo_db');
	}
	
	function save($db,$id = "")
	{
		if(empty($id))
		{
			$this->db->insert('login',$db);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('account_id',$id);
			$this->db->update('login',$db);
		}
		
		return $id;
	}
	
	function saveM($db,$id = "")
	{
		$this->mongo_db->insert('login',$db);
	}
	
	function getAccount($cond,$count=false)
	{
		$query = $this->db->where($cond)->get('login');
		
		if($count)
			$row   = $query->num_rows();
		else
			$row   = $query->row_array();
		
		return $row;
	}
	
	function getAccountM($cond)
	{
		$query = $this->mongo_db->where($cond)->get('login');
		
		return $query;
	}
	
	function getAccounts()
	{
		$this->db->where('account_id > ',1);
		$this->db->order_by('account_id','asc');
		$query = $this->db->get('login');
		
		$result = $query->result_array();
		
		return $result;
	}
	

}
