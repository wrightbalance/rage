<?php

class MY_Controller extends CI_Controller
{
	public $page;
	public $accountid;
	public $groupid;
	public $authorize;
	public $udt;
	
	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache',array('adapter'=>'file'));
		$this->load->model('accounts_db');
		$this->load->model('char_db');
		
		$this->page 		= "page_".$this->uri->rsegment(2);
		$this->accountid 	= $this->session->userdata('accountid');	
		$this->udt			= $this->accounts_db->getAccount(array('account_id'=>$this->accountid));
		$this->authorize	= false;

		$uri				= $this->uri->ruri_string();
		$sessioned_page		= false;
		$group 				= "user";
		
		
		if(config_item('EnableSite') === false)
		{
			if($this->uri->segment(1) != "maintenance")
				redirect('maintenance');
		}
		
		$p = array(
				'/main/index',
				'/account/auth',
				'/account/post',
				'/account/forgot',
				'/account/forgotpassword',
				'/account/signin',
				'/account/setPassword'
				);
		
		if(!in_array($uri,$p))
		{
			$sessioned_page	= true;
		}
		
		if($this->uri->segment(1) == "ref")
			$sessioned_page = false;
		
		
		if($this->uri->segment(2) == "confirmation" || $this->uri->segment(2) == "newpassword")
			$sessioned_page = false;
		
		$this->groupid = $this->session->userdata('adminlevel');
				
		if($this->groupid >= config_item('AdminLevel'))
		{
			$this->authorize = true;
			$group 			= "admin";
		}
		
		$onlineCount =  $this->char_db->countOnline();
		$charOnline = $this->char_db->getOnline();

		$data['authorize'] 	= $this->authorize;
		$data['user'] 		= $this->udt;
		$data['online'] 	= $onlineCount;
		$data['charOnline'] = $charOnline;
		$data['group']		= $group;
		
		
		$this->load->vars($data);

		if($sessioned_page)
		{
			if(!$this->udt)
			{
				if($this->input->is_ajax_request())
				{
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
					header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
					header("Cache-Control: no-cache, must-revalidate" );
					header("Pragma: no-cache" );
					header("Content-type: text/x-json");
					$this->session->sess_destroy();
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
		
		
	}
}
