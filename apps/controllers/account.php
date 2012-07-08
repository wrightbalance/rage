<?php

class Account extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('accounts_db');
		$this->load->model('char_db');
	}

	function auth()
	{
		if($this->input->is_ajax_request())
		{

			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$action = $this->input->post('action');
		
			if(config_item('UsingMD5'))
			{
				$password = md5($password);
			}

			$authorize = $this->accounts_db->getAccount(array('userid'=>$username,'user_pass'=>$password),true,false);

			if($authorize > 0)
			{
				$account = $this->accounts_db->getAccount(array('userid'=>$username,'user_pass'=>$password),false,true);
				
				if($account['state'] == 5)
				{ 
					$login = false;
				}
				else
				{
					$this->session->set_userdata('accountid',$account['account_id']);
					$this->session->set_userdata('demo',$username);
					
					if(config_item('UsingGroupID')) 
						$adminLevel = $account['group_id'];
					else
						$adminLevel = $account['level'];
						
					$this->session->set_userdata('adminlevel',$adminLevel);

					$data['message'] = "Redirecting...";
					$data['action'] = "forward";
					$data['url'] = site_url();
					$login = true;
				}
				
			}
			
			
			if($login == false)
			{
				$button = "<a class=\"close\" data-dismiss=\"alert\">×</a>";
				$margin = "";
				if($action == "quicklogin") 
				{
					$marginright = "style='margin-right: 30px; margin-top: -4px'";
					$button = "<button class=\"btn btn-mini showform\" style=\"float: right\">Retry</button>";
					$margin = "style='margin-top: 5px'";
				}
	
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message res_alert clearfix\">";
				$data['message'] .= "Login failed!";
				$data['message'] .= "<button class=\"btn retryform\" style=\"float:right\" type=\"button\">Retry</button>";
				$data['message'] .="</div>";

				$data['action'] = "retry";
			}

			$data['json'] = $data;
			$this->load->view('ajax/json',$data);


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
		
		if(config_item('Birthday'))
		{
			$this->form_validation->set_rules('month','Birthdate','required');
			$this->form_validation->set_rules('day','Birthdate','required');
			$this->form_validation->set_rules('year','Birthdate','required');
		}

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
			$forward			= true;
			$db['userid'] 		= trim($this->input->post('username'));
			$db['user_pass'] 	= trim($this->input->post('password'));				
			$db['email'] 		= trim($this->input->post('email'));
			$db['sex'] 			= $this->input->post('gender');
			
			if(config_item('Birthday'))
			{
				$month 				= $this->input->post('month');
				$day 				= $this->input->post('day');
				$year 				= $this->input->post('year');
				$db['birthdate'] 	= "{$year}-{$month}-{$day}";
			}
			if(config_item('UsingMD5'))
				$db['user_pass'] 	= trim(md5($this->input->post('password')));
			
			if(config_item('EmailConfirmation'))
			{
				$db['state'] = 5;
			}
			
			$accountid = $this->accounts_db->save($db);
			
			if(config_item('EmailConfirmation'))
			{
				$this->load->library('email');
				
				$code = md5(rand());
				$forward = false;
				
				// If expires is blank default to 24 hours
				if(!$expire = config_item('ConfirmationExpire'))
				{
					$expire = 24; 
				}
				
				$tdb['confirm_code'] 	= $code;
				$tdb['confirmed'] 		= 0;
				$tdb['confirm_created'] = date('Y-m-d H:i:s');
				$tdb['confirm_expire'] 	= date('Y-m-d H:i:s', time() + (60 * 60 * $expire));
				$tdb['account_id']		= $accountid;
				
				$this->accounts_db->saveConfirmation($tdb);
			
				if(config_item('UseSMTP'))
				{
					$config['protocol']  	= 'smtp';
					$config['smtp_host'] 	= config_item('MailerHost');
					$config['smtp_port'] 	= config_item('MailerPort');
					$config['smtp_timeout'] = '30';
					$config['smtp_user'] 	= config_item('MailerSMTPUsername');
					$config['smtp_pass'] 	= config_item('MailerSMTPPassword');	
					
				}
				else
				{
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';	
				}
				
				$config['charset']  	= 'utf-8';
				$config['newline']  	= "\r\n"; 
				$config['mailtype']  	= 'html'; 
				$config['wordwrap'] 	= TRUE;
				$this->email->initialize($config);
		
				$data['url'] = site_url('account/confirmation/'.$code);
				
				$data['content'] = $this->load->view('account/email/confirm',$data,true);
				$message 		 = $this->load->view('layout/email',$data,true);
				
				$this->email->from(config_item('MailerFrom'), 'Email Confirmation');
				$this->email->to($db['email']); 
				$this->email->subject(config_item('ServerName'));
				$this->email->message($message);	

				$this->email->send();

				//echo $this->email->print_debugger();
				
			}
			
			$ndb['nickname'] = trim($this->input->post('nickname'));
			$ndb['created'] = date('Y-m-d H:i:s');
			$ndb['accountid'] = $accountid;
			$this->accounts_db->set_nickname($ndb);
	
			if($forward)
			{		
				$this->session->set_userdata('accountid',$accountid);
				$data['action'] = "forward";
				$data['url'] = site_url();
				$data['message'] = "Redirecting...";
			}
			else
			{
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message\">";
				$data['message'] .= "<p>An e-mail has been sent containing account activation details, please check your e-mail and activate your account to log-in.</p>";
				$data['message'] .="</div>";
				$data['action'] = "retry";
			}
		}

		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function set_nickname()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('nickname','Nick Name','required|callback_checkNickname');

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
			$db['nickname'] = trim($this->input->post('nickname'));
			$db['created'] = date('Y-m-d H:i:s');
			$db['accountid'] = $this->accountid;
			
			$this->accounts_db->set_nickname($db);
			
			$data['action'] = "reload";

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
		$account = $this->accounts_db->getNickname(array('nickname'=>$nickname));
		$old_nickname = $this->input->post('old_nickname');

		if($old_nickname != $nickname)
		{
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
	}

	function settings($settings=false)
	{
		$this->benchmark->mark('code_start');

		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= "settings";
		$data['mod'] 		= "account";
		$data['title']		= "Settings | ".config_item('ServerName');

		if(!$this->input->is_ajax_request())
		{
			$data['content'] = $this->load->view('account/settings',$data,true);

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
	
	function create()
	{
		$this->benchmark->mark('code_start');
		$data = array();
	
		if(!$this->input->is_ajax_request())
		{
		
			$data['content'] = $this->load->view('account/create',$data,true);

			$data['elapse'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->vars($data);
			$this->load->view('default',$data);

        }
        else
        {

			$this->load->vars($data);
			$this->load->view('account/widget/w_create',$data);
		}
		$this->minify->html();
	}

	function index()
	{
		$this->benchmark->mark('code_start');
		
		$mod 				= $this->uri->rsegment(1);
		$page 				= $this->uri->rsegment(2);

		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= $page;
		$data['mod'] 		= $mod;
		
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
			if($this->authorize == false) exit();

			$data 			= $this->accounts_db->getList();
			$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->load->view('account/table/accounts',$data);
		}
	}

	function update()
	{

		if(!$this->input->is_ajax_request()) exit();
		$action = $this->input->post('action');
		
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
			
			if($action == "update_account")
			{
				$data['action'] = "retry2";
			}

		}
		else
		{
			
			$data['dt'] = $this->udt['userid'];
			
			if($this->udt['userid'] == "demo")
			{
				$data['message']  = "";
				$data['message'] .= "<div class=\"res_message res_alert\">";
				$data['message'] .= "Demo user does not allowed to modify accounts.";
				$data['message'] .="</div>";
				$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay Fine</button>";
				$data['action'] = "retry2";	
			}
			else
			{
				switch($action)
				{
					case 'changepass':
						if(config_item('UsingMD5'))
							$db['user_pass'] = trim(md5($this->input->post('new_password')));
						else
							$db['user_pass'] = trim($this->input->post('new_password'));
							
						$this->accounts_db->save($db,$this->accountid);

						$data['message']  = "";
						$data['message'] .= "<div class=\"res_message\">";
						$data['message'] .= "Password successfully updated.";
						$data['message'] .="</div>";
						$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
						$data['action'] = "retry2";
						break;
					case 'changeemail':
						$db['email'] = trim($this->input->post('new_email'));
						$this->accounts_db->save($db,$this->accountid);

						$data['message']  = "";
						$data['message'] .= "<div class=\"res_message\">";
						$data['message'] .= "E-mail Address successfully updated.";
						$data['message'] .="</div>";
						$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
						$data['action'] = "retry2";
						break;
					case 'update_account':
						$account_id = $this->input->post('account_id');
						$banned = $this->input->post('banned');
						
						$db['email'] 	= trim($this->input->post('email'));
						$db['userid'] 	= trim($this->input->post('userid'));
						
						if(config_item('UsingGroupID'))
							$db['group_id'] = trim($this->input->post('group_id'));
						else
							$db['level'] = trim($this->input->post('group_id'));
						
						if($banned) $db['state'] = 5;
						
						$this->accounts_db->save($db,$account_id);

						$ndb['nickname'] = trim($this->input->post('nickname'));
						
						$this->accounts_db->set_nickname($ndb,$account_id);
						
						$data['message']  = "";
						$data['message'] .= "<div class=\"res_message\">";
						$data['message'] .= "Account successfully updated.";
						$data['message'] .="</div>";
						$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
						$data['action'] = "retry2";
						break;
				}
			
			}
		}
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}

	function _check_password($password)
	{
		if(config_item('UsingMD5'))
		{
			$password = md5($password);
		}
		else
		{
			$password = $password;
		}
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
		$user 		= $this->accounts_db->getAccount(array('email'=>$email,'account_id'=>$this->accountid));
		
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
		
		$old_email 	= $this->input->post('old_email');
		
		if($old_email != $email)
		{
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
	
	function _check_email_exists2($email)
	{
		$user = $this->accounts_db->getAccount(array('email'=>$email));

		if(count($user) > 0)
		{
			
			return true;
		}
		else
		{
			$this->form_validation->set_message('_check_email_exists2','%s does not exists.');
			return false;
		}	
	}
	
	function ban()
	{
		// Admin Function
		
		checkSession();
		if(!$this->input->is_ajax_request()) exit();
		
		$admin = $this->session->userdata('groupid');
		if($admin < config_item('group_level')) exit(); // If not authorize just exit
		
		$db['account_id']  	= $this->input->post('account_id');
		$db['banned_by']	= $this->accountid;	
		$db['ban_type']		= $this->input->post('ban_type');
		$db['ban_until']	= "";
		$db['ban_date']		= date('Y-m-d H:i:s');
		$db['ban_reason']	= $this->input->post('reason');
		
		$data['message']  = "";
		$data['message'] .= "<div class=\"res_message\">";
		$data['message'] .= "Account has been banned";
		$data['message'] .="</div>";
		$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Close</button>";
		$data['action'] = "retry";
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	}
	
	function getAccount()
	{
		// Admin Function
		checkSession();
		if(!$this->input->is_ajax_request()) exit();
		
		$admin = $this->session->userdata('groupid');
		if($admin < config_item('group_level')) exit(); // If not authorize just exit
		
		$account_id = $this->input->post('account_id');
		
		$data['account'] = $this->accounts_db->getAccount(array('account_id'=>$account_id),false,true);
		$characters = $this->char_db->getChar(array('account_id'=>$account_id));
		$chars = array();
		
		foreach($characters as $char)
		{
			$chars[] = array(
					 'char_id'=>$char['char_id']
					,'char_num'=>$char['char_num']
					,'name'	=> $char['name']
					,'job'	=> jobClass($char['class'])
					,'level' => $char['base_level'].'/'.$char['job_level']
					,'zeny'	=> $char['zeny']
					);
		}
		
		$data['chars'] = $chars;
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	
	

	
	function forgot()
	{
		$this->benchmark->mark('code_start');

		$data['page'] 		= "forgot";
		$data['mod']		= "account";

		if(!$this->input->is_ajax_request())
		{
			$data['page_content'] = $this->load->view("{$data['mod']}/{$data['page']}",$data,true);
			$data['content'] = $this->load->view("account/forgot",$data,true);
			
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
	
	function signin()
	{
		$this->benchmark->mark('code_start');

		$data['page'] 		= "signin";
		$data['mod']		= "account";

		if(!$this->input->is_ajax_request())
		{
			$data['page_content'] = $this->load->view("{$data['mod']}/{$data['page']}",$data,true);
			$data['content'] = $this->load->view("account/signin",$data,true);
			
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
	
	function forgotpassword()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('email','E-mail Address','required|valid_email|callback__check_email_exists2');
		
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = $this->form_validation->_error_array;
			$this->form_validation->set_error_delimiters('<li>','</li>');

			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message res_alert\">";
			$data['message'] .= "<ul>".validation_errors()."</ul>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Okay</button>";
			$data['action'] = "retry";

		}
		else
		{
			$this->load->library('email');
			$code = md5(rand());
			
			$email = trim($this->input->post('email'));
			
			$account = $this->accounts_db->getAccount(array('email'=>$email));
			
			if(!$expire = config_item('ConfirmationExpire'))
			{
				$expire = 24; 
			}
			
			$tdb['confirm_code'] 	= $code;
			$tdb['confirmed'] 		= 0;
			$tdb['confirm_created'] = date('Y-m-d H:i:s');
			$tdb['confirm_expire'] 	= date('Y-m-d H:i:s', time() + (60 * 60 * $expire));
			$tdb['account_id']		= $account['account_id'];
			
			$this->accounts_db->saveConfirmation($tdb);
			
			if(config_item('UseSMTP'))
			{
				$config['protocol']  	= 'smtp';
				$config['smtp_host'] 	= config_item('MailerHost');
				$config['smtp_port'] 	= config_item('MailerPort');
				$config['smtp_timeout'] = '30';
				$config['smtp_user'] 	= config_item('MailerSMTPUsername');
				$config['smtp_pass'] 	= config_item('MailerSMTPPassword');	
				
			}
			else
			{
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';	
			}
			
			$config['charset']  	= 'utf-8';
			$config['newline']  	= "\r\n"; 
			$config['mailtype']  	= 'html'; 
			$config['wordwrap'] 	= TRUE;
			$this->email->initialize($config);
	
			$data['url'] = site_url('account/newpassword/'.$code);
			
			$data['content'] = $this->load->view('account/email/forgot',$data,true);
			$message 		 = $this->load->view('layout/email',$data,true);
			
			$this->email->from(config_item('MailerFrom'), 'Forgot Password');
			$this->email->to($email); 
			$this->email->subject(config_item('ServerName'));
			$this->email->message($message);	

			$this->email->send();
			
			
			$data['message']  = "";
			$data['message'] .= "<div class=\"res_message\">";
			$data['message'] .= "<p>An e-mail has been sent containing reset password instruction, please check your e-mail and change your password.</p>";
			$data['message'] .="</div>";
			$data['message'] .= "<button class=\"btn retryform\" type=\"button\">Retry</button>";
			$data['action'] = "retry";

		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
		
	
	}
	
	function confirmation($code)
	{
		$confirm_code = $this->accounts_db->getCode(array('confirm_code'=>$code,'confirmed'=>0));
		
		//print_r($confirm_code); exit();
		
		if(!$code) show_404();
		if(!$confirm_code) show_404();
		
		$db['confirmed'] = 1;
		$db['confirmed_on'] = date('Y-m-d H:i:s');
		$this->accounts_db->saveConfirmation($db,$code);
		
		
		if(isset($confirm_code['account_id']) && $confirm_code['account_id'])
		{
			$adb['state'] = 0;
			$this->accounts_db->save($adb,$confirm_code['account_id']);
		}
		

		$this->session->set_userdata('accountid',$confirm_code['account_id']);
		$this->session->set_userdata('adminlevel',0);
		
		redirect();
	}
	
	
	function newpassword($code)
	{
		$confirm_code = $this->accounts_db->getCode(array('confirm_code'=>$code,'confirmed'=>0));
		
		if(!$code) show_404();
		if(!$confirm_code) show_404();
		
		$this->benchmark->mark('code_start');

		$data['page'] 		= "forgot";
		$data['mod']		= "account";
		
		$data['details'] = $this->accounts_db->getAccount(array('account_id'=>$confirm_code['account_id']));
		$data['code'] = $code;
		
		if(!$this->input->is_ajax_request())
		{
			$data['page_content'] = $this->load->view("{$data['mod']}/{$data['page']}",$data,true);
			$data['content'] = $this->load->view("account/newpassword",$data,true);
			
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
	
	function setPassword()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$this->form_validation->set_rules('new_password','New Password','required');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]');
		
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
			$code 			= trim($this->input->post('code'));
			$newpassword 	= trim($this->input->post('new_password'));
			$accountid 		= $this->input->post('account_id');
			
			if(config_item('UsingMD5'))
				$newpassword = md5($newpassword);
			
			$db['confirmed'] = 1;
			$db['confirmed_on'] = date('Y-m-d H:i:s');
			$this->accounts_db->saveConfirmation($db,$code);
			
			$adb['user_pass'] = $newpassword;
			if($accountid)
				$this->accounts_db->save($adb,$accountid);
			
			$data['url'] = site_url('account/signin');
			$data['action'] = "forward";
			$data['message'] = "Redirecting...";
			
		}
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}

}
