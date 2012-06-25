<?php

class MY_Controller extends CI_Controller
{
	public $page;
	public $accountid;
	public $groupid;
	public $authorize;
	
	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache',array('adapter'=>'file'));
		$this->load->model('accounts_db');
		
		$this->page 		= "page_".$this->uri->rsegment(2);
		$this->accountid 	= $this->session->userdata('accountid');	
		$this->authorize	= false;

		$uri				= $this->uri->ruri_string();
		$g_user 			= $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		$sessioned_page		= false;
		
		
		// Not sessioned pages
		$p = array('/main/index','/account/auth','/account/post');
		
		if(!in_array($uri,$p))
		{
			$sessioned_page	= true;
		}
		
		if($this->uri->segment(1) == "ref")
		{
			$sessioned_page = false;
		}
		
		$this->groupid = $this->session->userdata('groupid');
				
		if($this->groupid >= config_item('GroupID'))
		{
			$this->authorize = true;
		}

		if($sessioned_page)
		{
			if(!$g_user)
			{
				if($this->input->is_ajax_request())
				{
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
					header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
					header("Cache-Control: no-cache, must-revalidate" );
					header("Pragma: no-cache" );
					header("Content-type: text/x-json");
					echo 'Your session been signed out. <a href="'.site_url('login').'">Click here to sign-in again</a><div style="display:none">'. gmdate( "D, d M Y H:i:s" ) .'</div>';
					exit;
				}
				else
				{
					$this->session->sess_destroy();
					redirect('');
				}
			}
		} 
		
		$data['authorize'] = $this->authorize;
		$data['user'] = $g_user;
		$this->load->vars($data);
	}
}
