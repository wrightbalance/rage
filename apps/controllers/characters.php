<?php

class Characters extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		$page = $this->uri->segment(2);

	}
	
	function index()
	{
		$this->benchmark->mark('code_start');
		$this->load->model('char_db');
		
		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= "index";
		$data['mod']		= "characters";
		$data['authorize']	= $this->authorize;
		
		$data['title']		= "Settings | ".config_item('ServerName');

		if(!$this->input->is_ajax_request())
		{
		
			$data['content'] = $this->load->view('layout/content',$data,true);	
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			$this->load->vars($data);
			$this->load->view("{$data['mod']}/{$data['page']}",$data);
		}
		$this->minify->html();
	}

	
	function getChar()
	{

		$server = $this->input->post('server');
		$data['server_id'] = $server;

		$data['characters'] = $this->char_db->getChar(array('account_id'=>$this->accountid),false,$server);
		
		$this->load->vars($data);
		$this->load->view('characters/table/charlists',$data);
		
		$this->minify->html();
	}
	
	function storage()
	{
		$this->benchmark->mark('code_start');
	
		$data['title'] = "Storage | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'storage';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('characters/storage',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
	
			$this->load->vars($data);
			$this->load->view('characters/widget/w_storage',$data);
		}
		$this->minify->html();
	}
	
	function getOnline()
	{
		$kind = $this->input->post('kind');
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline(10,false);
		$chars = array();
		$count = 0;
		
		if($kind == "count")
		{
			$online2 = $this->char_db->getOnline();
			$count = count($online2);
		}
		else if($kind == "lists")
		{
			foreach($online as $chr)
			{
				$chars[] = array(
					'name' => $chr['name'],
					'job' => jobClass($chr['class'])
				);
			}
		}
		
		$data['count'] = $count;
		$data['chars'] = $chars;
		$data['page'] = $this->uri->segment(2);
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function reset()
	{
		if(!$this->input->is_ajax_request()) exit();

		$this->load->model('char_db');
		
		$action = $this->input->post('action');
		$char_id = $this->input->post('char_id');
		$server_id = $this->input->post('server_id');
		
		$getChar = $this->char_db->getMyChar(array('char_id'=>$char_id,'account_id'=>$this->accountid),$server_id);
		
		switch($action)
		{
			case "1": $act = "map"; break;
			case "2": $act = "equipment"; break;
			case "3": $act = "hair"; break;
			case "4": $act = "map equipment hair"; break;
		}
		
		if($getChar['online'] == 1)
		{
			$data['message'] = "<span style='color:red'>".$getChar['name']." is currently online. Please logout your account to reset your character</span>";
		}
		else
		{
			$this->char_db->reset($char_id,$this->accountid,$action,$server_id);
			$data['message'] = $getChar['name']." ".$act." successfully reset";
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
		
	}
	
	function getAccountCharacter()
	{
		if(!$this->input->is_ajax_request()) exit();
		$this->load->model('char_db');
		$this->load->helper('jobclass');

		$data = array();
		
		if($this->accountid)
		{
			$user = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$isAdmin = $user['group_id'] >= 90 ? true : false;
			
			$account_id = $this->input->post('account_id');
			
			if($isAdmin)
			{
				$characters = $this->char_db->getChar(array('account_id'=>$account_id));
				$db = array();
				
				foreach($characters as $char)
				{
					$db[] = array(
							 'char_id'=>$char['char_id']
							,'char_num'=>$char['char_num']
							,'name'	=> $char['name']
							,'job'	=> jobClass($char['class'])
							,'level' => $char['base_level'].'/'.$char['job_level']
							,'zeny'	=> $char['zeny']
							);
				}
				$data['db'] = $db;
			}
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getStorage()
	{
		$this->benchmark->mark('code_start');
		
		if($this->accountid)
		{
			$this->load->model('char_db');
	
			$data 			= $this->char_db->getStorage($this->accountid);
			$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->view('accounts/table/storage',$data);
		}
	}
	
	function view_char()
	{
		$char_id = $this->input->post('char_id');
		$server_id = $this->input->post('server_id');
		
		$groupid = $this->session->userdata('groupid');
		
		if($groupid >= config_item('group_level'))
		{
			$cond = array('char_id'=>$char_id);
		}
		else
		{
			$cond = array('char_id'=>$char_id,'account_id'=>$this->accountid);	
		}
		
		$data['char'] = $this->char_db->getChar($cond,true,$server_id);
		$data['user'] = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		$data['server_id'] = $server_id;
		
		$this->load->view('characters/modal/view_s',$data);
		$this->minify->html();
	}
	
	function delete()
	{
		$password 	= trim(md5($this->input->post('user_pass')));
		$char_id 	= $this->input->post('char_id');
		$server_id 	= $this->input->post('server_id');
		
		$check_password = $this->accounts_db->getAccount(array('account_id'=>$this->accountid,'user_pass'=>$password));
		
		if(!$check_password)
		{
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert clearfix\">";
			$data['message'] .= "Cannot delete character. Password is incorrect.";
			$data['message'] .= "<button class=\"btn retryform\" style=\"float:right\" type=\"button\">Retry</button>";
			$data['message'] .="</div>";
		}
		else
		{
			$check_online = $this->char_db->getChar(array('account_id'=>$this->accountid,'char_id'=>$char_id),true);
			
			if($check_online['online'] > 0)
			{
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message clearfix res_alert\">";
				$data['message'] .= "Can't delete ".$check_online['name']." .Character is currently online. Please logout before doing so.";
				$data['message'] .= "<button class=\"btn retryform\" style=\"float:right\" type=\"button\">Retry</button>";
				$data['message'] .="</div>";
				$data['action'] = "retry";
			} 
			else 
			{
				
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message clearfix\">";
				$data['message'] .= "Your Character has been deleted.";
				$data['message'] .="</div>";
				$data['action'] = "done";
				
				$this->char_db->delete(array('account_id'=>$this->accountid,'char_id'=>$char_id),$server_id);
				
				$data['char_id'] = $char_id;
				
			}  
			
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function view()
	{
		$this->benchmark->mark('code_start');
		
		$mod 				= $this->uri->segment(1);
		$page 				= $this->uri->segment(2);
		
		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= $page;
		$data['mod'] 		= $mod;
		
		$data['title']		= "Characters | ".config_item('ServerName');
		
		if(!$this->input->is_ajax_request())
		{
			$data['content'] = $this->load->view('layout/content',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			$this->load->vars($data);
			$this->load->view("{$data['mod']}/{$data['page']}",$data);
		}
		$this->minify->html();
	}
	
	function getList()
	{
		$this->benchmark->mark('code_start');

		$data 			= $this->char_db->getList($this->authorize);
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$view 			= $this->input->post('view');
		
		if(!$view)
			$this->load->view('characters/table/characters',$data);
		else
			$this->load->view('characters/table/view',$data);

	}
	

}
