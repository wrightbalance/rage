<?php

class Ranking_db extends CI_Model
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
	
	function char($cond,$sortname,$sortorder,$limit = 10)
	{
		if(config_item('server_count') >= 2)
		{
			$server = $this->input->post('server');
			
			if(!$server) $server = 1;
			if($server == 1)
			{
				$this->db1->order_by($sortname,$sortorder);
				$this->db1->limit($limit);
				$this->db1->join('login','login.account_id = char.account_id');
				$this->db1->where('login.level <',1);
				$this->db1->where($cond);
				$query = $this->db1->get('char');
			}
			else
			{
				$this->db2->order_by($sortname,$sortorder);
				$this->db2->limit($limit);
				$this->db2->join('login','login.account_id = char.account_id');
				$this->db2->where('login.level <',1);
				$this->db2->where($cond);
				$query = $this->db2->get('char');
			}
		}
		else
		{
			$this->db->order_by($sortname,$sortorder);
			$this->db->limit($limit);
			$this->db->join('login','login.account_id = char.account_id');
			$this->db->where('login.level <',1);
			$this->db->where($cond);
			$query = $this->db->get('char');
		}
		return $query->result_array();
	}
	
	function pvp($server=false)
	{
		$server = $this->input->post('server');
		
		if(config_item('server_count') >= 2)
		{
			if($server == 1)
			{
				$this->db1->order_by('kills','desc');
				$this->db1->where('kills !=',0);
				$this->db1->join('char','char.char_id = arena_master.char_id');
				$query = $this->db1->get('arena_master');
			}
			else
			{
				$this->db2->order_by('kills','desc');
				$this->db2->where('kills !=',0);
				$this->db2->join('char','char.char_id = arena_master.char_id');
				$query = $this->db2->get('arena_master');
	
			}
		}
		else
		{
			$this->db->order_by('kills','desc');
			$this->db->where('kills !=',0);
			$this->db->join('char','char.char_id = arena_master.char_id');
			$query = $this->db->get('arena_master');
		}
		return $query->result_array();
	}
	
	function guilds($limit=1,$server_id = 1)
	{
		$sql = "SELECT 
					guild_castle.guild_id, 
					COUNT( guild_castle.guild_id ) AS guild_count, 
					guild.name as gname, 
					emblem_id, 
					emblem_data,
					master
				FROM  `guild_castle` 
				JOIN guild ON ( guild.guild_id = guild_castle.guild_id)
				GROUP BY guild_id
				LIMIT {$limit}";
					
		if(config_item('server_count') >= 2)
		{
			if($server_id == 1)
				$query = $this->db1->query($sql);
			else
				$query = $this->db2->query($sql);
		}
		else
		{
			$query = $this->db->query($sql);
		}
		$row = $query->row_array();
		
		return $row;
	}
	
	function getPvp()
	{
		$server = $this->input->post('server');
		
		if(!$server) $server = 1;
		
		if(config_item('server_count') >= 2)
		{
			if($server == 1)
			{
				$this->db1->join('char','char.char_id=arena_master.char_id');
				$this->db1->join('guild','char.guild_id=guild.guild_id','left');
				$this->db1->select('class,guild.name as guild_name,char.name as char_name');
				$this->db1->order_by('kills','desc');
				$query = $this->db1->get('arena_master');
			}
			else
			{
				$this->db1->join('char','char.char_id=arena_master.char_id');
				$this->db1->join('guild','char.guild_id=guild.guild_id','left');
				$this->db1->select('class,guild.name as guild_name,char.name as char_name');
				$this->db2->order_by('kills','desc');
				$query = $this->db2->get('arena_master');
			}
		}
		else
		{
			$this->db->join('char','char.char_id=arena_master.char_id');
			$this->db->join('guild','char.guild_id=guild.guild_id','left');
			$this->db->select('class,guild.name as guild_name,char.name as char_name');
			$this->db->order_by('kills','desc');
			$query = $this->db->get('arena_master');
		}
		
		
		$row = $query->row_array();
		
		return $row;
	}
	
}
