<?php

class Stream extends CI_Controller
{
	private $account;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('streams_db');
		
		$this->account = $this->session->userdata('accountid');
	}
	
	function post()
	{
		$db['message'] = trim($this->input->post('message'));
		$db['account_id'] = $this->input->post('account_id');
		$db['nickname'] = $this->input->post('nickname');
		$db['gender'] = $this->input->post('gender');
		$db['created'] = date('Y-m-d H:i:s');
		$db['updated'] = date('Y-m-d H:i:s');
		$db['status']	= 1;
		$db['comments'] = array();
		
		$sid = $this->streams_db->save($db);
		
		$db['sid'] = (string)$sid;
		$db['message'] = nl2br($db['message']);
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function comment()
	{
		$sid = $this->input->post('sid');
		
		$db['comment'] 		= trim($this->input->post('comment'));
		$db['account_id'] 	= $this->input->post('account_id');
		$db['nickname'] 	= $this->input->post('nickname');
		$db['gender']		= $this->input->post('gender');
		$db['c_created'] 	= date('Y-m-d H:i:s');
		$db['comment_id']	= time().rand(6666,9999);
		 
		$cid = $this->streams_db->saveComment($db,$sid);
		
		$cid = (string)$cid;
		
		$this->streams_db->save('',$sid);
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		exit();
	}
	
	function delete()
	{
		$comment_id 	= $this->input->post('comment_id');
		$stream_id 		= $this->input->post('id');
		$kind 			= $this->input->post('kind');
		
		if($kind == "comment")
			$cond = array('comment_id'=>(string)$comment_id);
		else if($kind == "stream")
			$cond = array('_id'=>$this->mongo_db->mongoID($stream_id));
			
		$this->streams_db->delete($cond,$kind);
		
		$data['kind'] = $kind;
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	
}
