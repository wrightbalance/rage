<?
    $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    $this->output->set_header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
    $this->output->set_header("Cache-Control: no-cache, must-revalidate" );
    $this->output->set_header("Pragma: no-cache" );
    $this->output->set_header("Content-type: text/x-json");

	$rows = array();
	
    foreach ($db as $row)
        {
		$vote_banner = "";
		
		if(!empty($row['image_url']))
		{
			$vote_banner = "<img src=\"{$row['image_url']}\" alt=\"\"/>";
		}
        $rows[] = array(
                "id" => $row['id'],
                "cell" => array(
					 $vote_banner
					,$row['name']
                	,"<a href=\"{$row['vote_url']}\" target=\"_blank\">{$row['vote_url']}</a>"
                	,$row['credits']
                	,$row['hours']
                	,"<a href=\"/cms/news/edit/".$row['id']."\" class=\"viewvotes\" data-aid=\"".$row['id']."\"><i class=\"icon-pencil\"></i>  Edit</a>"
                	,"<a href=\"#\" class=\"deletevote\" data-aid=\"".$row['id']."\"><i class=\" icon-remove\"></i>  Delete</a>"
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
