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
		 
		$sid = $this->streams_db->saveComment($db,$sid);
		
		$sid = (string)$sid;
		
		$data['db'] = $db;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	
}
