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
	
	function getStream($limit = NULL)
	{
		if($limit) $this->db->limit($limit);
		
		$this->db->where('s_status',1);
		
		$this->db->join('cp_login','cp_login.accountid = cp_stream.account_id');
		$this->db->join('login','login.account_id = cp_stream.account_id');
		
		if(config_item('UsingGroupID'))
			$this->db->select('sid,content,nickname,cp_stream.created as screated,sex,group_id,login.account_id');
		else
			$this->db->select('sid,content,nickname,cp_stream.created as screated,sex,level,login.account_id');
			
		$this->db->order_by('updated','desc');
		$squery = $this->db->get('cp_stream');
		
		$sresults = $squery->result_array();
		$stream = array();
		
		
		foreach($sresults as $result)
		{
			if(config_item('UsingGroupID'))
				$abadge = $result['group_id'] >= config_item('GroupID')  ? 'admin' : '';
			else
				$abadge = $result['level'] >= config_item('GroupID')  ? 'admin' : '';
			
			$comments_count = $this->comment_count($result['sid']);
			
			$stream[] = array(
				'account_id' 		=> $result['account_id'],
				'sid' 				=> $result['sid'],
				'content' 			=> $result['content'],
				'nickname' 			=> $result['nickname'],
				'created' 			=> ago($result['screated']),
				'sex' 				=> $result['sex'],
				'comments'			=> $this->_comments($result['sid']),
				'abadge' 			=> $abadge,
				'comment_count'		=> $comments_count
			);
		}
	
		
		return $stream;
	}
	
	function comment_count($sid)
	{
		$this->db->where('sid',$sid);
		$this->db->from('cp_stream_comment');
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	
	function _comments($sid)
	{
		$this->db->limit(3);
		$this->db->where('sid',$sid);
		$this->db->where('c_status',1);
		$this->db->join('cp_login','cp_login.accountid = cp_stream_comment.account_id');
		$this->db->join('login','login.account_id = cp_stream_comment.account_id');
		
		if(config_item('UsingGroupID'))
			$this->db->select('csid,sex,nickname,comment,c_created,group_id,cp_stream_comment.account_id as aid');
		else
			$this->db->select('csid,sex,nickname,comment,c_created,level,cp_stream_comment.account_id as aid');
		
		$this->db->order_by('csid','desc');
		$query = $this->db->get('cp_stream_comment');
		$comments = array();
		
		$results = $query->result_array();
		
		foreach($results as $row)
		{
			$abadge = "user";
			
			
			if(config_item('UsingGroupID'))
			{
				if($row['group_id'] >= config_item('GroupID'))
				{
					$abadge = "admin";
				}
			}
			else
			{
				if($row['level'] >= config_item('GroupID'))
				{
					$abadge = "admin";
				}
	
			}
			
			
			$comments[] = array(
				'csid' 		=> $row['csid'],
				'nickname' 	=> $row['nickname'],
				'sex' 		=> $row['sex'],
				'comment' 	=> $row['comment'],
				'created' 	=> ago($row['c_created']),
				'abadge' 	=> $abadge,
				'account_id' => $row['aid']
			);
		}
		
		if($comments) $comments = array_reverse($comments);
		
		return $comments;
	}
	
	function getComments($cond)
	{
		$this->db->where($cond);
		$this->db->join('cp_login','cp_login.accountid = cp_stream_comment.account_id');
		$this->db->join('login','login.account_id = cp_stream_comment.account_id');
		if(config_item('UsingGroupID'))
			$this->db->select('csid,sex,nickname,comment,c_created,group_id');
		else
			$this->db->select('csid,sex,nickname,comment,c_created,level');
		
		$query = $this->db->get('cp_stream_comment');
		$results = $query->result_array();
		
		$comments = array();
		
		foreach($results as $row)
		{
			$abadge = "user";
			
			
			if(config_item('UsingGroupID'))
			{
				if($row['group_id'] >= config_item('GroupID'))
				{
					$abadge = "admin";
				}
			}
			else
			{
				if($row['level'] >= config_item('GroupID'))
				{
					$abadge = "admin";
				}
	
			}
			
			$photopath = resource_url('images/photo_'.strtolower($row['sex']).'.jpg');
			
			$comments[] = array(
				'csid' 		=> $row['csid'],
				'nickname' 	=> $row['nickname'],
				'sex' 		=> $row['sex'],
				'comment' 	=> $row['comment'],
				'created' 	=> ago($row['c_created']),
				'abadge' 	=> $abadge,
				'photopath' 	=> $photopath
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
			$this->mongo_db->pull('cp_stream_comment',$cond)->update('streams');
		}
		else
		{
			$this->mongo_db->where($cond)->set(array('status'=>0))->update('cp_stream_comment');
		}
	}
	
	function lastPost($cond)
	{
		$this->db->where($cond);
		$this->db->limit(1);
		$this->db->select('created');
		$this->db->order_by('sid','desc');
		$query = $this->db->get('cp_stream');
		
		$row = $query->row_array();
		
		return $row;
	}
	
}
