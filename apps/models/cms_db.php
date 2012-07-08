<?php

class Cms_db extends CI_Model
{
	private $nosql;
	
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->database();

	}
	
	function save($db,$nid="")
	{
		if($nid)
		{
			$this->db->where('id',$nid);
			$this->db->update('cp_news',$db);
		}
		else
		{
			$this->db->insert('cp_news',$db);
		}
	}
	
	function save_page($db,$pid="")
	{
		if($pid)
		{
			$this->db->where('id',$pid);
			$this->db->update('cp_pages',$db);
		}
		else
		{
			$this->db->insert('cp_pages',$db);
		}
	}
	
	function getListNews()
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
		       
		$q = $this->db->get('cp_news');
		
		$num = $q->num_rows();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
			
		$this->db->order_by($sortname,$sortorder);		
		$results = $this->db->get('cp_news');

			
		$data['db'] = $results->result_array();    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function getListPages()
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
		       
		$q = $this->db->get('cp_pages');
		$num = $q->num_rows();
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
			
		$this->db->order_by($sortname,$sortorder);		
		$results = $this->db->get('cp_pages');
		
		$res = $results->result_array();
			
		$data['db'] = $res;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function getNews($cond,$list=false)
	{
		$news = $this->db->where($cond)->get('cp_news');
		
		if($list) $results = $news->result_array();
		else $results = $news->row_array();
		
		return $results;
	}
	
	function getPage($cond)
	{
		$page = $this->db->where($cond)->get('cp_pages');
		
		if(count($page) > 0)
		{
			return $page->row_array();
		}
		else
		{
			return array();
		}
	}
	
	function getPages()
	{
		$this->db->where('status',1);
		$page = $this->db->get('cp_pages');
		
		$row = $page->result_array();
		
		if($row)
		{
			return $row;
		}
		else
		{
			return array();
		}
	}
	
	function getNewsList($cond)
	{
		$news = $this->db->where($cond)->get('cp_news');
		
		if(count($news) > 0)
		{
			return $news->result_array();
		}
		else
		{
			return array();
		}
	}
	
	function getPatcher($cond)
	{
		$news = $this->mongo_db->where($cond)->order_by(array('_id'=>'desc'))->get('gcp_news');
		$n = array();
		
		foreach($news as $new)
		{
			$n[] = array(
				'news_title' 	=> $new['news_title'],
				'created'		=> $new['created'],
				'news_body' 	=> $new['news_body'],
				'author'		=> $this->author($new['author'])
				);
		}
		
		return $n;
	}
	
	function author($accountid)
	{
		$author = $this->mongo_db->where(array('_id'=>(int)$accountid))->get('login');
		$author = $author[0];
		
		return $author['nickname'];
	}
	
	function deleteNews($cond)
	{
		$this->mongo_db->where($cond)->delete('gcp_news');
	}
	
	function deleteItem($id,$source)
	{
		$this->db->where('id',$id)->delete('cp_'.$source);
	}
	
	
	
}
