<?php

class Streams_db extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('mongo_db');
	}
	
	function save($db)
	{
		$sid = $this->mongo_db->insert('streams',$db);
		
		return $sid;
	}
	
	function saveComment($db,$id)
	{
		$id = $this->mongo_db->mongoID($id);
		
		$this->mongo_db->where(array('_id'=>$id))->push('comments',$db)->update('streams');
	}
	
	function getStream()
	{
		$stream = $this->mongo_db->where(array('status'=>1))->order_by(array('_id'=>'desc'))->get('streams');
		
		return $stream;
	}
	
	function delete($cond,$kind)
	{
		if($kind == "comment")
		{
			$this->mongo_db->pull('comments',$cond)->update('streams');
		}
		else
		{
			$this->mongo_db->where($cond)->set(array('status'=>0))->update('streams');
		}
	}
	
}
