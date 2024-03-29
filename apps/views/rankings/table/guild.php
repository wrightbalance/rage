<?
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();
	$rank = 1;
	
	if($db)
	{
		foreach ($db as $row)
        {
			$emblem = img("guild/emblem/{$row['guild_id']}");
			$rows[] = array(
                "id" => $row['castle_id'],
                "cell" => array(
					 $rank
					,$emblem
					,$row['gname']
					,$row['master']
					,$row['guild_count']
                	)
                
            );
			$rank ++;
        }
    }
        

	if (isset($elapsed)) $data['elapsed'] = $elapsed;
	
    $data['page'] = $page;
    $data['total'] = $total;
    $data['rp'] = $rp;
    $data['rows'] = $rows;
    
    echo json_encode($data);
?>
