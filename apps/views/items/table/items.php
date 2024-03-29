<?php
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();

    foreach ($db as $row)
        {
		$icon = img("resources/images/items/thumb/12137.gif",array('alt'=>"",'title'=>$row['description']));
		
		if(file_exists('./resources/images/items/thumb/'.$row['id'].'.gif'))
		{
			$icon = img("resources/images/items/thumb/{$row['id']}.gif",array('alt'=>"",'title'=>$row['description']));
		}	
		
		$url = push_url("items/view/{$row['friendly_url']}");
		
		$dt = json_encode(array('id'=>$row['id']));
		
        $rows[] = array(
                "id" => $row['id'],
                "cell" => array(
                	  $icon
                	,"<a href=\"{$url}\" class=\"ps\">{$row['name_japanese']}</a>"
                	,itemTypes($row['type']) ? itemTypes($row['type']) : 'Unknown'
                	,$row['price_buy'] ? number_format($row['price_buy']) : 0
                	,$row['price_sell'] ? $row['price_sell'] : 0
                	,$row['weight'] ? number_format($row['weight']) : 0
                	,$row['defence'] ? $row['defence']  : 'n/a' 
                	,$row['range'] ? $row['range'] : 'n/a'
                	,$row['slots'] ? $row['slots'] : 'n/a'
                	,"<button class=\"btn btn-mini module\" data-mod=\"modify\" data-dt='".$dt."'><i class=\"icon-edit\"></i> Edit</button>"
             
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
