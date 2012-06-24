<?php

class Char_db extends CI_Model
{
	private $db1;
	private $db2;
	
	function __construct()
	{
		parent::__construct();
		
		if(config_item('server_count') >= 2)
		{
			$this->db1 = $this->load->database('server1',TRUE);
			$this->db2 = $this->load->database('server2',TRUE);
		}
		else
		{
			$this->load->database();
		}
	}
	
	function getOnline($limit=999,$join=true)
	{
		$this->db->where('c.online',1);
		if($join) $this->db->join('login l','l.account_id = c.account_id');
		$this->db->limit($limit);
		$query = $this->db->get('char c');
		
		$result = $query->result_array();
		
		return $result;
	}
	
	function getChar($cond,$single=false,$server=false)
	{
		if(config_item('server_count') >= 2)
		{
			if($server == 1)
				$query = $this->db1->where($cond)->get('char');
			else if($server == 2)
				$query = $this->db2->where($cond)->get('char');
			else
				$query = $this->db->where($cond)->get('char');
		}
		else
		{
			$query = $this->db->where($cond)->get('char');
		}
		if($single)
			$result = $query->row_array();
		else
			$result = $query->result_array();
		
		return $result;
	}
	
	function getMyChar($cond,$server_id = false)
	{
		if(config_item('server_count') >= 2)
		{
			if($server_id == 1)
				$query = $this->db1->where($cond)->get('char');
			else if($server_id == 2)
				$query = $this->db2->where($cond)->get('char');
			else
				$query = $this->db->where($cond)->get('char');
		}
		else
		{
			$query = $this->db->where($cond)->get('char');
		}
		$result = $query->row_array();
		
		return $result;
	}
	
	function reset($char_id,$accountid,$action,$server_id=false)
	{
		if(config_item('server_count') >= 2)
		{
			if($server_id == 1)
			{
				$get_map = $this->db1->where('account_id',$accountid)
						->where('char_id',$char_id)
						->get('char');
			}
			else if($server_id == 2)
			{
				$get_map = $this->db2->where('account_id',$accountid)
						->where('char_id',$char_id)
						->get('char');
			}
			else
			{
				$get_map = $this->db->where('account_id',$accountid)
						->where('char_id',$char_id)
						->get('char');
			}
		}
		else
		{
			$get_map = $this->db->where('account_id',$accountid)
						->where('char_id',$char_id)
						->get('char');
		}			
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
		
		
		if(config_item('server_count') >= 2)
		{
			if($server_id == 1)
			{
				$this->db1->where('char_id',$char_id)
					->where('account_id',$accountid)
					->update('char',$set);

			}
			else if($server_id == 2)
			{
				$this->db2->where('char_id',$char_id)
					->where('account_id',$accountid)
					->update('char',$set);	
			}
			else
			{
				$this->db->where('char_id',$char_id)
					->where('account_id',$accountid)
					->update('char',$set);

			}
		}
		else
		{
			$this->db->where('char_id',$char_id)
					->where('account_id',$accountid)
					->update('char',$set);
		}
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
	
	function delete($cond,$server=false)
	{
		if(config_item('server_count') >= 2)
		{
			if($server == 1)
			{
				$this->db1->where($cond)->delete('char');
				$this->db1->where('char_id',$cond['char_id'])->delete('inventory');
				$this->db1->where('char_id',$cond['char_id'])->delete('cart_inventory');
			}
			else if($server == 2)
			{
				$this->db2->where($cond)->delete('char');
				$this->db2->where('char_id',$cond['char_id'])->delete('inventory');
				$this->db2->where('char_id',$cond['char_id'])->delete('cart_inventory');
			}
			else
			{
				$this->db->where($cond)->delete('char');
				$this->db->where('char_id',$cond['char_id'])->delete('inventory');
				$this->db->where('char_id',$cond['char_id'])->delete('cart_inventory');
			}
		}
		else
		{
			$this->db->where($cond)->delete('char');
			$this->db->where('char_id',$cond['char_id'])->delete('inventory');
			$this->db->where('char_id',$cond['char_id'])->delete('cart_inventory');
		}
	}
	
	function getList($authorize=true)
    {
		$account_id = $this->session->userdata('accountid');
		$aid = $this->input->post('account_id');
		
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
		
		if($authorize == false)
			$this->db->where('account_id',$account_id);
		
		if($aid)
			$this->db->where('account_id',$aid);
		
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
		
		if($authorize == false)
			$this->db->where('account_id',$account_id);
			
		if($aid)
			$this->db->where('account_id',$aid);
		$this->db->order_by($sortname,$sortorder);
		$query = $this->db->get('char');		
		$results = $query->result_array();
		
		$db = array();
		
		foreach($results as $result)
		{
			$db[] = array(
				 'account_id'	=>	$result['account_id']
				,'char_id'		=>	$result['char_id']
				,'owner'		=>	$this->getAccount($result['account_id'])
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
	
	function getAccount($accountid)
	{
		$this->db->where('accountid',$accountid);
		$query = $this->db->get('cp_login');
		
		$row = $query->row_array();
		
		if($row) $name = $row['nickname'];
		else $name = "";
		
		return $name;
	}
	
}
