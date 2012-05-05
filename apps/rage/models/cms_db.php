<?php

class Cms_db extends CI_Model
{
	var $sql;
	
	function __construct()
	{
		parent::__construct();
		
		$this->sql = "nosql";
	}
	
	function save($db,$nid = false)
	{
		if($nid)
		{
			if($this->sql == "nosql")
			{
				$this->mongo_db->where(array('_id'=>$this->mongo_db->mongoID($nid)))->set($db)->update('gcp_news');
			}
			elseif ($this->sql == "mysql")
			{
				$this->db->where('news_id',$nid)->update('gcp_news',$db);
			}
		}
		else
		{
			if($this->sql == "nosql")
			{
				$this->mongo_db->insert('gcp_news',$db);
			}
			elseif ($this->sql == "mysql")
			{
				$this->db->insert('gcp_news',$db);
			}
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
		       
		$num = $this->mongo_db->count('gcp_news');
		
		if ($start>$num) 	
			{
			$start = 0; 
			$page = 1;
			}    
			
		$this->mongo_db->order_by(array($sortname=>$sortorder));		
		$results = $this->mongo_db->get('gcp_news');

			
		$data['db'] = $results;    
		$data['page'] = $page;
		$data['total'] = $num;
		$data['rp'] = $rp;
		return $data;
	}
	
	function getNews($cond)
	{
		$news = $this->mongo_db->where($cond)->get('gcp_news');
		
		if(count($news) > 0)
		{
			return $news;
		}
		else
		{
			return array();
		}
	}
	
	function getPatcher($cond)
	{
		$news = $this->mongo_db->where($cond)->get('gcp_news');
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
	
}
