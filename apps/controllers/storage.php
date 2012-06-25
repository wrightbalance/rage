<?php 

class Storage extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('storage_db');
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
	
	
	function getList()
	{
		$this->benchmark->mark('code_start');
		$mod = $this->uri->rsegment(1);
		$page = $this->uri->rsegment(2);

		$data 			= $this->storage_db->getList();
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view("{$mod}/table/{$mod}",$data);
	}
}
