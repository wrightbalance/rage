<?php

class Streams_db extends CI_Model
{
	private $nosql;
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		if(config_item('nosql'))
		{
			$this->load->library('mongo_db');
		}
		
		$this->nosql = config_item('nosql');
		
	}
	
	function getStream()
	{
		$this->db->where('s_status',1);
		$this->db->join('cp_login','cp_login.accountid = cp_stream.account_id');
		$this->db->join('login','login.account_id = cp_stream.account_id');
		$this->db->select('sid,content,nickname,cp_stream.created as screated,sex');
		$this->db->order_by('updated','desc');
		$squery = $this->db->get('cp_stream');
		
		$sresults = $squery->result_array();
		$stream = array();
		
		
		foreach($sresults as $result)
		{
			$stream[] = array(
				'sid' => $result['sid'],
				'content' => $result['content'],
				'nickname' => $result['nickname'],
				'created' => ago($result['screated']),
				'sex' => $result['sex'],
				'comments'=> $this->_comments($result['sid'])
			);
		}
		
		return $stream;
	}
	
	function _comments($sid)
	{
		$this->db->where('sid',$sid);
		$this->db->where('c_status',1);
		$this->db->join('cp_login','cp_login.accountid = cp_stream_comment.account_id');
		$this->db->join('login','login.account_id = cp_stream_comment.account_id');
		$this->db->select('csid,sex,nickname,comment,c_created');
		$this->db->order_by('sid','asc');
		$query = $this->db->get('cp_stream_comment');
		$comments = array();
		
		$results = $query->result_array();
		
		foreach($results as $row)
		{
			$comments[] = array(
				'csid' => $row['csid'],
				'nickname' => $row['nickname'],
				'sex' => $row['sex'],
				'comment' => $row['comment'],
				'created' => ago($row['c_created'])
			);
		}
		
		return $comments;
	}
	
	
	function save($db,$sid=false)
	{
		if(!$sid)
		{
			$this->db->insert('cp_stream',$db);
			$sid = $this->db->insert_id();
		}
		else
		{
			$this->db->where('sid',$sid);
			$this->db->update('cp_stream',$db);
		}	
		return $sid;
	}
	
	function saveComment($db,$csid)
	{
		if(empty($csid))
		{
			$this->db->insert('cp_stream_comment',$db);
			$csid = $this->db->insert_id();
		}
		else
		{
			$this->db->where('csid',$csid);
			$this->db->update('cp_stream_comment',$db);
		}
		
		return $csid;
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
