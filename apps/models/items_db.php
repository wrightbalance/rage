<?php 

class Items_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getList()
	{
		$page = $this->input->post('page');
		$rp = $this->input->post('rp');
		
		$sortname = $this->input->post('sortname');
		$sortorder = $this->input->post('sortorder');
		
		$query = $this->input->post('query');
		$qtype = $this->input->post('qtype');

		if (!$page) $page = 1;
		if (!$rp) $rp = 10;        
				
		$start = (($page-1) * $rp);  
		
		if($query) $this->db->like($qtype,$query);
		$this->db->from('item_db');
		$num = $this->db->count_all_results();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
		

		$this->db->limit($rp,$start);
		if($query) $this->db->like($qtype,$query);

		$this->db->order_by($sortname,$sortorder);
		$query = $this->db->get('item_db');		
		$results = $query->result_array();

		$data['db'] = $results;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
}
