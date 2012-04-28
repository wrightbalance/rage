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
	
	function getChar($cond)
	{
		$query = $this->db->where($cond)->get('char');
		
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
}
