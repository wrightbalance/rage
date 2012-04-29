<?php

class Account extends CI_Controller
{
	private $accountid;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('accounts_db');
		
		$this->accountid = $this->session->userdata('accountid');
	}
	
	function auth()
	{
		if($this->input->is_ajax_request())
		{
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$action = $this->input->post('action');
			$marginright = "";
			
			$account = $this->accounts_db->getAccount(array('userid'=>$username,'user_pass'=>md5($password)),true);
			
			if($account > 0)
			{
				$account2 = $this->accounts_db->getAccount(array('userid'=>$username,'user_pass'=>md5($password)));
				$this->session->set_userdata('accountid',$account2['account_id']);
				
				$data['action'] = "forward";
				$data['url'] = site_url();
			}
			else
			{
				$button = "<a class=\"close\" data-dismiss=\"alert\">×</a>";
				if($action == "quicklogin") 
				{
					$marginright = "style='margin-right: 36px; margin-top: -4px'";
					$button = "<button class=\"btn btn-mini showform\" style=\"float: right\">Retry</button>";
				}
				$data['message'] = "";
				$data['message'] .= "<div class=\"alert alert-error\" {$marginright}>";
				$data['message'] .=	"{$button}";
				$data['message'] .=	"Login failed. Please try again.";
				$data['message'] .=	"</div>";
				$data['action'] = "error2";
			}
			
			$data['json'] = $data;
			$this->load->view('ajax/json',$data);
			
			//exit();
		}
	}
	
	function login()
	{
		$this->benchmark->mark('code_start');
		$data = array();
		$data['form'] = "frm_login";
		$data['formtitle'] = "Login to your Account";
		
		$data['margindown'] = " style='margin-top: 128px'";
		
		$data['content'] = $this->load->view("main/index",$data,true);
		
		$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		
		$this->load->vars($data);
		$this->load->view('default',$data);
        $this->minify->html();
	}
	
	function post()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		
		$this->form_validation->set_rules('nickname','Nick Name','required|callback_checkNickname');
		$this->form_validation->set_rules('username','Username','required|callback_usernameIsExists');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('email','E-mail Address','required|valid_email|callback_emailIsExists');
		$this->form_validation->set_rules('gender','Gender','required');
		$this->form_validation->set_rules('month','Birthdate','required');
		$this->form_validation->set_rules('day','Birthdate','required');
		$this->form_validation->set_rules('year','Birthdate','required');
		
		if($this->form_validation->run() === FALSE)
		{
			$data['action'] = "retry";
			$data['error'] = $this->form_validation->_error_array;
			
		}
		else
		{
			$data['action'] = "forward";
			$data['url'] = site_url();
			
			$db['userid'] 		= trim($this->input->post('username'));
			$db['user_pass'] 	= trim(md5($this->input->post('password')));
			$db['email'] 		= trim($this->input->post('email'));
			$db['sex'] 			= $this->input->post('gender');
			
			$month 				= $this->input->post('month');
			$day 				= $this->input->post('day');
			$year 				= $this->input->post('year');
			
			$db['birthdate'] 	= "{$year}-{$month}-{$day}";
			
			$accountid = $this->accounts_db->save($db);
			
			$db['_id'] = $accountid;
			$db['nickname'] = trim($this->input->post('nickname'));
			$this->accounts_db->saveM($db);
			
			$this->session->set_userdata('accountid',$accountid);
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function emailIsExists($email)
	{
		$account = $this->accounts_db->getAccount(array('email'=>$email),true);
		
		if($account > 0)
		{
			$this->form_validation->set_message('emailIsExists','%s is already taken');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function usernameIsExists($username)
	{
		$account = $this->accounts_db->getAccount(array('userid'=>$username),true);
		
		if($account > 0)
		{
			$this->form_validation->set_message('usernameIsExists','%s is already taken');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function checkNickname($nickname)
	{
		$account = $this->accounts_db->getAccountM(array('nickname'=>$nickname));
		
		if(count($account) > 0)
		{
			$this->form_validation->set_message('checkNickname','%s is already taken');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function settings()
	{
		$this->benchmark->mark('code_start');

		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'settings';
		
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
		
			$data['content'] = $this->load->view('account/settings',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('account/widget/w_settings',$data);
		}
		$this->minify->html();
	}

	function index()
	{
		$this->benchmark->mark('code_start');
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'account';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
		$data['accounts'] = $this->accounts_db->getAccounts();
		
		
		if($this->accountid)
		{
			
			$data['showlogin'] = false;
			$user = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$data['isAdmin'] = $user['group_id'] >= 90 ? true : false;
			if($data['isAdmin'] === false) redirect();
		}
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('account/index',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			
        }
        else
        {
			checkSession();
			
			$this->load->vars($data);
			$this->load->view('account/widget/w_index',$data);
		}
		$this->minify->html();
	}
	
	function signout()
	{
		$this->session->sess_destroy();
		
		redirect();
	}
}
