<?php

class Characters extends CI_Controller
{
	private $accountid;
	
	function __construct()
	{
		parent::__construct();
		
		$this->accountid = $this->session->userdata('accountid');
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		checkSession();
	}
	
	function index()
	{
		$this->benchmark->mark('code_start');
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] = "";

		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];

		$data['accounts'] = $this->accounts_db->getAccounts();
		
		$groupid = $this->session->userdata('groupid');
		if($groupid < config_item('group_level')) show_404();
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('characters/all_char',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('characters/widget/w_index',$data);
		}
		$this->minify->html();
	}
	
	function signout()
	{
		$this->session->sess_destroy();
		
		redirect();
	}
	
	
	function charlist()
	{
		$this->benchmark->mark('code_start');
		$this->load->helper('array');
		$this->load->helper('jobclass');
	
		$data['title'] = "Characters | ".config_item('site_title');
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'characters';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
		$data['characters'] = $this->char_db->getChar(array('account_id'=>$this->accountid));

		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('characters/index',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('characters/widget/w_character',$data);
		}
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
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('characters/widget/w_storage',$data);
		}
		$this->minify->html();
	}
	
	function getOnline()
	{
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$data['db'] = $online;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);

	}
	
	function reset()
	{
		if(!$this->input->is_ajax_request()) exit();
		checkSession();
		
		$this->load->model('char_db');
		
		$action = $this->input->post('action');
		$char_id = $this->input->post('char_id');
		
		$getChar = $this->char_db->getMyChar(array('char_id'=>$char_id,'account_id'=>$this->accountid));
		
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
			$this->char_db->reset($char_id,$this->accountid,$action);
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
		
		checkSession();
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
		
		$data['char'] = $this->char_db->getChar(array('char_id'=>$char_id,'account_id'=>$this->accountid),true);
		
		$data['user'] = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		
		$this->load->view('characters/modal/view_s',$data);
		$this->minify->html();
	}
	
	function delete()
	{
		$password = trim(md5($this->input->post('user_pass')));
		$char_id = $this->input->post('char_id');
		
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
				
				$this->char_db->delete(array('account_id'=>$this->accountid,'char_id'=>$char_id));
				
				$data['char_id'] = $char_id;
				
			}  
			
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getList()
	{
		$this->benchmark->mark('code_start');
		
		if($this->accountid)
		{
			$groupid = $this->session->userdata('groupid');
			if($groupid >= config_item('group_level'))
			{
				$data 			= $this->char_db->getList();
				$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
				$this->load->view('characters/table/characters',$data);
			}
		}
	}
}
