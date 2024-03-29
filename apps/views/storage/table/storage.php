<?php
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();

    foreach ($db as $row)
        {
		$icon = img("resources/images/icons/12137.gif",array('alt'=>"",'title'=>$row['description']));
		
		if(file_exists('./resources/images/items/thumb/'.$row['id'].'.gif'))
		{
			$icon = img("resources/images/items/thumb/{$row['id']}.gif",array('alt'=>"",'title'=>$row['description']));
		}	
		
        $rows[] = array(
                "id" => $row['id'],
                "cell" => array(
                	 $icon
                	,anchor("items/view/{$row['friendly_url']}",$row['name_japanese'])
                	,$row['amount']
				)
            );

        }

	if (isset($elapsed)) $data['elapsed'] = $elapsed;
	
    $data['page'] = $page;
    $data['total'] = $total;
    $data['rp'] = $rp;
    $data['rows'] = $rows;
    
    echo json_encode($data);
?>
