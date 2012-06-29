<?php

class Guild extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('guild_db');
	}

	
	function index()
	{
		$query = $this->db->get('guild');
		
		$result = $query->row_array();

		$emblemData  = @gzuncompress(pack('H*', $result['emblem_data']));
		$emblemImage = imagecreatefrombmpstring($emblemData);
		
		ob_start();
		imagepng($emblemImage);
		header("Content-Type: image/png");
		exit();
	}
	
	function emblem($guild_id = "")
	{
		if(!empty($guild_id))
		{
			$emblem = $this->guild_db->getEmblem($guild_id);
			
			if($emblem)
			{
				if($emblem['emblem_len'] > 0)
				{
					$emblemData  = @gzuncompress(pack('H*', $emblem['emblem_data']));
					$emblemImage = imagecreatefrombmpstring($emblemData);
					
					ob_start();
					imagepng($emblemImage);
					header("Content-Type: image/png");
				}
			}
		}
		exit();
	}
	
	function getList()
	{
		$this->benchmark->mark('code_start');
		$mod = $this->uri->rsegment(1);
		$page = $this->uri->rsegment(2);

		$data 			= $this->guild_db->getList();
		$data['elapsed'] = $this->benchmark->elapsed_time('code_start', 'code_end');
		$this->load->view("{$mod}/table/{$mod}",$data);
	}
	
}


