<?php

class Rankings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ranking_db');
	}
	
	function char()
	{
		$kind = $this->input->post('kind');

		$data['db'] = array();
		
		switch($kind)
		{
			case 'pvp':
				$pvps = $this->ranking_db->pvp();
				
				$rank = 1;
				$data['db'] = array();
				
				if($pvps)
				{
					foreach($pvps as $pvp)
					{
						$data['db'][] = array(
							'rank' => $rank ++,
							'name' => $pvp['name'],
							'job' => jobClass($pvp['class']),
							'kills' => $pvp['kills']
						);
					}
				}

				break;
			case 'zeny':
				$zenys = $this->ranking_db->char(array(),'zeny','desc');
				$rank = 1;
				
				foreach($zenys as $zeny)
				{
					$data['db'][] = array(
						'rank' => $rank ++,
						'name' => $zeny['name'],
						'job' => jobClass($zeny['class']),
						'zeny' => number_format($zeny['zeny'])
					);
				}
				
				break;
		}
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
	function getGuild()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$server_id = $this->input->post('server_id');
		
		$data['db'] = $this->ranking_db->guilds(1,$server_id);
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);	
	
	}
	
	function getPVP()
	{
		if(!$this->input->is_ajax_request()) exit();
		
		$server_id = $this->input->post('server_id');
		
		$data['db'] = $this->ranking_db->getPvp();
		$data['db']['class'] = jobClass($data['db']['class']);
		
		$data['json'] = $data;
		$this->load->view('ajax/json',$data);
	}
	
}
