<?
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();
	
    foreach ($db as $row)
        {
			$reset  = "<a href=\"#map\" class=\"btn btn-mini\">Location</a>";
			$reset .= "<a href=\"#equipment\" class=\"btn btn-mini\">Equipment</a>";
			$reset .= "<a href=\"#hair\" class=\"btn btn-mini\">Equipment</a>";
			$reset .= "<a href=\"#map equiment hair\" class=\"btn btn-mini\">All</a>";
			
			$rows[] = array(
					"id" => $row['char_id'],
					"cell" => array(
						 "<a href=\"#\" class=\"view\" data-aid=\"".$row['account_id']."\">".$row['account_id']."</a>"
						,"<a href=\"#\" class=\"view_char\" data-char_id=\"".$row['char_id']."\">".$row['name']."</a>"
						,$row['class']
						,$row['base_level']
						,$row['job_level']
						,$row['zeny'] !== 0 ? number_format($row['zeny']) : 0,
						,$reset
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
