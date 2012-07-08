<?php

class Accounts_db extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();

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
	
	function set_nickname($db,$id = "")
	{
		if(empty($id))
		{
			$this->db->insert('cp_login',$db);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('accountid',$id);
			$this->db->update('cp_login',$db);
		}
	}
	
	
	function getAccount($cond,$count=false,$join=true)
	{

		if($join) $this->db->join('cp_login','cp_login.accountid = login.account_id','left');
		$this->db->where($cond);
		$query = $this->db->get('login');
		
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
	
	function getList()
    {
		$user = $this->session->userdata('user');
		
        $item = $this->input->post('item');
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		$views = $this->input->post('views');
		if($views == "all")
		{
			$views = "";
		}
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$sortname) $sortname = 'account_id';
		if (!$sortorder) $sortorder = 'DESC';
		
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  
		
		
		if($views == "banned")
		{
			$this->db->where('state',5);
		}
		if($views == "admin")
		{
			if(config_item('UsingGroupID'))
				$this->db->where('group_id >',1);
			else
				$this->db->where('level >',1);
		}
		$this->db->where('account_id > ',1);
		$this->db->like($qtype,$query,'both');
		$this->db->from('login');
		$num = $this->db->count_all_results();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
		
		if($views == "banned")
		{
			$this->db->where('state',5);
		}
		if($views == "admin")
		{
			if(config_item('UsingGroupID'))
				$this->db->where('group_id >',1);
			else
				$this->db->where('level >',1);
		}
		$this->db->limit($rp,$start);
		$this->db->like($qtype,$query,'both');
		$this->db->where('account_id >',1);
		$this->db->order_by($sortname,$sortorder);
		$query = $this->db->get('login');		
		$results = $query->result_array();

			
		$data['db'] = $results;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function getNickname($cond)
	{
		$query = $this->db->where($cond)->get('cp_login');
		
		return $query->row_array();
	}
	
	function saveConfirmation($db,$code = "")
	{
		if(empty($code))
		{
			$this->db->insert('cp_confirmation',$db);
		}
		else
		{
			$this->db->where('confirm_code',$code);
			$this->db->update('cp_confirmation',$db);
		}
	}
	
	function getCode($cond)
	{
		$query = $this->db->get_where('cp_confirmation',$cond);
		
		return $query->row_array();
	}

}
