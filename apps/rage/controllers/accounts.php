<?php

class Accounts extends CI_Controller
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
				$this->session->set_userdata('groupid',$account2['group_id']);
				
				$data['message'] = "Redirecting...";
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
				/*
				$data['message'] = "";
				$data['message'] .= "<div class=\"alert alert-error\" {$marginright}>";
				$data['message'] .=	"{$button}";
				$data['message'] .=	"Login failed. Please try again.";
				$data['message'] .=	"</div>";
				$data['action'] = "error2";
				*/
				
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message res_alert clearfix\">";
				$data['message'] .= "Your username or password.";
				$data['message'] .= "<button class=\"btn retryform\" style=\"float:right\" type=\"button\">Retry</button>";
				$data['message'] .="</div>";
				
				$data['action'] = "retry";
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
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert\">";
			$data['message'] .= "<ul>".validation_errors()."</ul>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
			$data['action'] = "retry";
			
		}
		else
		{
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
			
			$data['action'] = "forward";
			$data['url'] = site_url();
			$data['message'] = "Redirecting...";
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
	
	function settings($settings=false)
	{
		$this->benchmark->mark('code_start');

		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'settings';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];
		
		$account = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		$data['account'] = $account;
		
		$this->load->model('char_db');
		$online = $this->char_db->getOnline();
		$pvptop = $this->char_db->topPlayer();
		
		$data['onlines'] = $online;
		$data['pvptop'] = $pvptop;
		
		if($settings) $data['settings'] = $settings;

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
		
		$groupid = $this->session->userdata('groupid');
		
		if($groupid < config_item('group_level')) show_404();
		
		$data['cssgroup'] = "loggedin";
		$data['jsgroup'] = "loggedin";
		$data['page'] 	= 'account';
		
		$details = $this->accounts_db->getAccountM(array('_id'=>(int)$this->accountid));
		$data['details'] = $details[0];

		$data['accounts'] = $this->accounts_db->getAccounts();
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->accountid) redirect();
		
			$data['content'] = $this->load->view('account/all_account',$data,true);
			
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
	
	function getList()
	{
		$this->benchmark->mark('code_start');
		
		if($this->accountid)
		{
			$user = $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
			$isAdmin = $user['group_id'] >= 90 ? true : false;
			if($isAdmin === false) exit();
			
			$data 			= $this->accounts_db->getList();
			$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->view('account/table/accounts',$data);
		}
	}
	
	function update()
	{
		
		checkSession();
		if(!$this->input->is_ajax_request()) exit();
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = $this->form_validation->_error_array;
			$this->form_validation->set_error_delimiters('<li>','</li>');
			
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert\">";
			$data['message'] .= "<ul>".validation_errors()."</ul>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
			$data['action'] = "retry";
			
		}
		else
		{
			$action = $this->input->post('action');
			
			switch($action)
			{
				case 'changepass':
					$db['user_pass'] = trim(md5($this->input->post('new_password')));
					$this->accounts_db->save($db,$this->accountid);
					
					$data['message']  = "";
					$data['message'] .= "<div class=\"res_message\">";
					$data['message'] .= "Password successfully updated.";
					$data['message'] .="</div>";
					$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
					break;
				case 'changeemail':
					$db['email'] = trim($this->input->post('new_email'));
					$this->accounts_db->save($db,$this->accountid);
					
					$data['message']  = "";
					$data['message'] .= "<div class=\"res_message\">";
					$data['message'] .= "E-mail Address successfully updated.";
					$data['message'] .="</div>";
					$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
					break;
			}
			$data['action'] = "retry";
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function _check_password($password)
	{
		$user = $this->accounts_db->getAccount(array('user_pass'=>$password,'account_id'=>$this->accountid));
		
		if(count($user) == 0)
		{
			$this->form_validation->set_message('_check_password','The password you have entered is wrong.');
			return false;
		}
		else
		{
			return true;
		}
		
		
	}
	
	function _check_email($email)
	{
		$user = $this->accounts_db->getAccount(array('email'=>$email,'account_id'=>$this->accountid));
		
		if(count($user) == 0)
		{
			$this->form_validation->set_message('_check_email','The email you have entered is wrong.');
			return false;
		}
		else
		{
			return true;
		}	
	}
	function _check_email_exists($email)
	{
		$user = $this->accounts_db->getAccount(array('email'=>$email));
		
		if(count($user) > 0)
		{
			$this->form_validation->set_message('_check_email_exists','%s already taken.');
			return false;
		}
		else
		{
			return true;
		}	
	}
	
}
