<?
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();
	
    foreach ($db as $row)
        {
		
        $rows[] = array(
                "id" => $row['account_id'],
                "cell" => array(
                	 "<a href=\"#\" class=\"view\" data-aid=\"".$row['account_id']."\">".$row['account_id']."</a>"
                	,$row['userid']
                	,$row['email']
                	,$row['group_id']
                	,$row['last_ip']
                	,$row['lastlogin'] != "0000-00-00 00:00:00" ? date('M d, Y',strtotime($row['lastlogin'])) : 'Never'
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
