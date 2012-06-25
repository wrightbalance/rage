<?
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();
	

	
    foreach ($db as $row)
        {
		$icon = "";
		
		if(file_exists("resources/images/icons/{$row['id']}.gif"))
			$icon = img("resources/images/icons/{$row['id']}.gif",array('alt'=>"",'title'=>$row['description']));
			
        $rows[] = array(
                "id" => $row['id'],
                "cell" => array(
                	 $icon
                	,$row['name_japanese']
                	,itemTypes($row['type']) ? itemTypes($row['type']) : 'Unknown'
                	,$row['price_buy'] ? number_format($row['price_buy']) : 0
                	,$row['price_sell'] ? $row['price_sell'] : 0
                	,$row['weight'] ? number_format($row['weight']) : 0
                	,$row['defence']
                	,$row['range']
                	,$row['slots']
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
