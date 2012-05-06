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
	
	function getChar($cond,$single=false)
	{
		$query = $this->db->where($cond)->get('char');
		
		if($single)
			$result = $query->row_array();
		else
			$result = $query->result_array();
		
		return $result;
	}
	
	function getMyChar($cond)
	{
		$query = $this->db->where($cond)->get('char');
		
		$result = $query->row_array();
		
		return $result;
	}
	
	function reset($char_id,$accountid,$action)
	{
		$get_map = $this->db->where('account_id',$accountid)
					->where('char_id',$char_id)
					->get('char');
					
		$row = $get_map->row_array();
					
		switch($action)
		{
			case 1:
				$set = array(
					'last_map' => $row['save_map'],
					'last_x' => $row['save_x'],
					'last_y' => $row['save_y']
				);
				break;
			case 2:
				$set = array(
					'weapon' => 0,
					'shield' => 0,
					'head_top' => 0,
					'head_mid' => 0,
					'head_bottom' => 0,
					'clothes_color' => 0
				);
				break;
			case 3:
				$set = array(
					'hair' => 0,
					'hair_color' => 0,
				);
				break;
			case 4:
				$set = array(
					'weapon' => 0,
					'shield' => 0,
					'head_top' => 0,
					'head_mid' => 0,
					'head_bottom' => 0,
					'clothes_color' => 0,
					'last_map' => $row['save_map'],
					'last_x' => $row['save_x'],
					'last_y' => $row['save_y'],
					'hair' => 0,
					'hair_color' => 0
				);
				break;
		}	
		
		$this->db->where('char_id',$char_id)
				->where('account_id',$accountid)
				->update('char',$set);
	}
	
	
	function topPlayer($limit=5)
	{
		$this->db->order_by('kills','desc');
		$this->db->limit($limit);
		$pvpquery = $this->db->get('pvpm_data');
		
		return $pvpquery->result_array();
	}
	
	function getStorage($accountid=false)
    {
		$user = $this->session->userdata('user');
		
        $item = $this->input->post('item');
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$sortname) $sortname = 'account_id';
		if (!$sortorder) $sortorder = 'DESC';
		
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  
		       
		$this->db->like($qtype,$query,'both');
		if($accountid) $this->db->where('account_id',$accountid);
		$this->db->from('storage');
		$num = $this->db->count_all_results();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
		

		$this->db->limit($rp,$start);
		$this->db->like($qtype,$query,'both');
		$this->db->order_by($sortname,$sortorder);
		if($accountid) $this->db->where('account_id',$accountid);
		$query = $this->db->get('storage');		
		$results = $query->result_array();

			
		$data['db'] = $results;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function delete($cond)
	{
		$this->db->where($cond)->delete('char');
		$this->db->where('char_id',$cond['char_id'])->delete('inventory');
		$this->db->where('char_id',$cond['char_id'])->delete('cart_inventory');
	}
	
	function getList()
    {
		$user = $this->session->userdata('user');
		
        $item = $this->input->post('item');
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$sortname) $sortname = 'char_id';
		if (!$sortorder) $sortorder = 'DESC';
		
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  

		$this->db->like($qtype,$query,'both');
		$this->db->from('char');
		$num = $this->db->count_all_results();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
		

		$this->db->limit($rp,$start);
		$this->db->like($qtype,$query,'both');

		$this->db->order_by($sortname,$sortorder);
		$query = $this->db->get('char');		
		$results = $query->result_array();
		
		$db = array();
		
		foreach($results as $result)
		{
			$db[] = array(
				 'account_id'	=>	$result['account_id']
				,'char_id'		=>	$result['char_id']
				,'owner'		=>	$this->getAccountM($result['account_id'])
				,'name'			=>	$result['name']
				,'class'		=>  jobClass($result['class'])
				,'base_level'	=>  $result['base_level']
				,'job_level'	=>  $result['job_level']
				,'zeny'			=>  $result['zeny']
				);
		}

			
		$data['db'] = $db;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function getAccountM($account_id)
	{
		$query = $this->mongo_db->where(array('account_id'=>$account_id))->get('login');
		
		if(count($query) > 0)
		{
			$name = $query[0]['nickname'];
		}
		else
		{
			$name = "";
		}
		
		return $name;
	}
}
