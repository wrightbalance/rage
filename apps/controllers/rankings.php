<?php

class Rankings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ranking_db');
	}
	
	function pvp()
	{
		$this->benchmark->mark('code_start');

		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= "rankings";
		$data['mod'] 		= "rankings";

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
	
	function guild()
	{
		$this->benchmark->mark('code_start');

		$data['cssgroup'] 	= "loggedin";
		$data['jsgroup'] 	= "loggedin";
		$data['page'] 		= "rankings";
		$data['mod']	 	= "rankings";

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
	
	function getListPVP()
	{
		$this->benchmark->mark('code_start');
		$data 			= $this->ranking_db->getListPVP();
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view('rankings/table/pvp',$data);
	}
	
	function getListGuild()
	{
		$this->benchmark->mark('code_start');
		$data 			= $this->ranking_db->getListGuild();
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view('rankings/table/guild',$data);
	}
	
}
