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
		$stream = $this->mongo_db->order_by(array('_id'=>'desc'))->get('streams');
		
		return $stream;
	}
	
}
