<?php

class Vote_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function getCashpoint($account_id)
	{
		$cashpoint = 0;
		
		$cond = array(
			'account_id'	=>	$account_id,
			'str'			=> "#CASHPOINTS"
		);
		
		$cpoint = $this->db->where($cond)->get('global_reg_value');
		$row = $cpoint->row_array();
		
		if($row)
		{
			$cashpoint = $row['value'];
		}
		
		return $cashpoint;
		
	}
	
	function getList()
    {
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$sortname) $sortname = 'id';
		if (!$sortorder) $sortorder = 'DESC';
		
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  
		       
		if($qtype) $this->db->like($qtype,$query);
		$this->db->from('cp_banners');
		$num = $this->db->count_all_results();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
		

		$this->db->limit($rp,$start);
		if($qtype) $this->db->like($qtype,$query);
		$this->db->order_by($sortname,$sortorder);
		$query = $this->db->get('cp_banners');		
		$results = $query->result_array();

			
		$data['db'] = $results;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function save($db,$id="")
	{
		if(empty($id))
		{
			$this->db->insert('cp_banners',$db);
			$id = $this->db->insert_id();
		}
		else
		{
			$db['modified'] = date('Y-m-d H:i:s');
			$this->db->where('id',$id);
			$this->db->update('cp_banners',$db);
		}
	}
	

	function getBanners($cond,$lists=false)
	{
		$query = $this->db->where($cond)->get('cp_banners');
		
		if($lists)
			$results = $query->result_array(); 
		else
			$results = $query->row_array();
			
		return $results;
	}
	
	function getLastVote($cond,$order=false)
	{
		if($order) $this->db->order_by('id','desc');
		$query = $this->db->limit(1)->where($cond)->get('cp_votes');
		$rows = $query->row_array();
		
		return $rows;	
	}
	
	function getVotes($cond,$lists=false)
	{
		$query = $this->db->order_by('id','desc')->where($cond)->get('cp_votes');
		
		if($lists)
		{
			$results = $query->result_array();
		}
		else
		{
			$results = $query->row_array();
		}
		
		return $results;
	}
	
	function save_vote($db)
	{
		$this->db->insert('cp_votes',$db);
		
		// Save Cashpoints
		if(config_item('use_cashpoints'))
		{
			$cashpoint 	= (int)$db['credits'];
			$insert 	= true;
			
			$cond = array(
						'account_id'	=>	$db['account_id'],
						'str'			=>	'#CASHPOINTS'
						);
			
			$cquery = $this->db->where($cond)->get('global_reg_value');
			$cnum 	= $cquery->num_rows();

			if($cnum > 0)
			{
				$crow 		= $cquery->row_array();
				$cashpoint 	= (int)$crow['value'] + (int)$db['credits'];
				$insert 	= false;
			}

			$xdb['type'] 		= 2;
			$xdb['value'] 		= $cashpoint;
			
			if($insert)
			{
				$xdb['str'] 		= "#CASHPOINTS";
				$xdb['account_id'] 	= $db['account_id'];
				$this->db->insert('global_reg_value',$xdb);
			}
			else
			{
				$this->db->where('str','#CASHPOINTS');
				$this->db->where('account_id',$db['account_id']);
				$this->db->update('global_reg_value',$xdb);
			}

		}
	}
	
	function delete($cond)
	{
		$this->db->where($cond);
		$this->db->delete('cp_banners');
	}
}
