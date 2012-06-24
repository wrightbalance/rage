<?php

class Stream extends CI_Controller
{
	private $account;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('streams_db');
		$this->load->model('accounts_db');
		
		$this->account = $this->session->userdata('accountid');
	}
	
	function post()
	{
		$db['account_id'] = $this->account;
		$db['content'] = trim($this->input->post('message'));
		$db['created'] = date('Y-m-d H:i:s');
		$db['updated'] = date('Y-m-d H:i:s');
		
		$sid = $this->streams_db->save($db);
		
		$db['sid'] = $sid;
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function comment()
	{
		$db['comment'] = trim($this->input->post('comment'));
		$db['sid'] = $this->input->post('sid');
		$db['c_created'] = date('Y-m-d H:i:s');
		$db['account_id'] = $this->account;
		
		$csid = $this->streams_db->saveComment($db,'');
		
		$xdb['updated'] = date('Y-m-d H:i:s');
		
		if($db['sid'])
		{
			$this->streams_db->save($xdb,$db['sid']);
		}
		
		$db['csid'] = $csid;
		$db['gender'] = $this->input->post('gender');
		$db['nickname'] = $this->input->post('nickname');
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
	
	function delete()
	{
		$comment_id 	= $this->input->post('comment_id');
		$stream_id 		= $this->input->post('id');
		$kind 			= $this->input->post('kind');
		
		switch($kind)
		{
			case 'comment':
				$db['c_status'] = 0;
				$this->streams_db->saveComment($db,$comment_id);
				break;
			case 'stream':
				$db['s_status'] = 0;
				$this->streams_db->save($db,$stream_id);
				break;
		}
		
		$data['kind'] = $kind;

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	
}
