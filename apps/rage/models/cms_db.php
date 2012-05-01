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
}
