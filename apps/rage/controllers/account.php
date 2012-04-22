<?php

class Account extends CI_Controller
{
	private $account;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('accounts_db');
		
		$this->account = $this->session->userdata('accountid');
	}
	
	function auth()
	{
		if($this->input->is_ajax_request())
		{
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			
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
				$data['message'] = "";
				$data['message'] .= "<div class=\"alert alert-error\">";
				$data['message'] .=	"<a class=\"close\" data-dismiss=\"alert\">×</a>";
				$data['message'] .=	"<strong>Oh snap!</strong> login failed. Please try again.";
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
		
		if(!$this->input->is_ajax_request())
		{
			if(!$this->account) redirect();
		
			$data['content'] = $this->load->view('account/settings',$data,true);
			
			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);
			$this->minify->html();
        }
        else
        {
			checkSession();
			
			$data = array();
			$this->load->view('account/widget/w_settings',$data);
		}
	}
	
	function signout()
	{
		$this->session->sess_destroy();
		
		redirect();
	}
}
