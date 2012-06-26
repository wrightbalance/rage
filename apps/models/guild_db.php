<?php

class Guild_db extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	function getEmblem($guild_id)
	{
		$this->db->where('guild_id',$guild_id);
		$this->db->select('emblem_len,emblem_data');
		$query = $this->db->get('guild');
		
		$row = $query->row_array();
		
		return $row;
	}
	
}
