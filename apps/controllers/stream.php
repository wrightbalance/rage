<?php

class Stream extends MY_Controller
{
	private $account;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('streams_db');

	}
	
	function post()
	{
		$disallowed = config_item('disallowedWords');
		
		$message = trim($this->input->post('message'));
		
		$db['account_id'] = $this->accountid;
		$db['content'] = word_censor($message,$disallowed,'***');
		$db['created'] = date('Y-m-d H:i:s');
		$db['updated'] = date('Y-m-d H:i:s');
		
		$sid = $this->streams_db->save($db);
		
		$db['sid'] = $sid;
		$db['abadge'] = "user";
		
		
		if($this->authorize)
			$db['abadge'] = "admin";
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function comment()
	{
		
		$disallowed = config_item('disallowedWords');
		
		$message = trim($this->input->post('comment'));
		
		$content = word_censor($message,$disallowed,'***');
		
		$db['comment'] = $content;

		$db['sid'] = $this->input->post('sid');
		$db['c_created'] = date('Y-m-d H:i:s');
		$db['account_id'] = $this->accountid;
		
		$csid = $this->streams_db->saveComment($db,'');
		
		$xdb['updated'] = date('Y-m-d H:i:s');
		
		if($db['sid'])
		{
			$this->streams_db->save($xdb,$db['sid']);
		}
		
		$db['csid'] = $csid;
		$db['gender'] = $this->input->post('gender');
		$db['nickname'] = $this->input->post('nickname');
		
		$db['abadge'] = "user";
	
		if($this->authorize)
			$db['abadge'] = "admin";
		
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
	
	function getComments()
	{
		$sid = $this->input->post('sid');
		
		$data['db'] = $this->streams_db->getComments(array('sid'=>$sid));
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	
	
}
