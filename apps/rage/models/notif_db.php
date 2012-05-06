<?php

class Notif_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('mongo_db');
	}
	
	function notifcount()
	{
		$account_id = $this->session->userdata('accountid');
		
		$this->mongo_db->where(array('account_id'=>$account_id,'type'=>2))->count('notif_count');
	}
	
	function saveNotif($db)
	{
		$notifExists = $this->mongo_db->where(array('kind'=>$db['kind'],'source_id'=>$db['source_id']))->count('notifications');
		
		if($notifExists === 0)
		{
			$this->mongo_db->insert('notifications',$db);
		}
		
		$count = $this->newsCount(array('category'=>$db['kind']));
		
		return $count;
	}
	
	function newsCount($cond)
	{
		$accountid = $this->session->userdata('accountid');
		$newscount = $this->mongo_db->where($cond)->count('gcp_news');
		
		$mynews = $this->mongo_db->where(array('kind'=>$cond['category']))->count('notifications');
		
		$total_news = $newscount - $mynews;
		
		return $total_news;
	}
}
