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
	
}


