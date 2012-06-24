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
                "id" => $row['id'],
                "cell" => array(
                	 "<a href=\"/cms/news/edit/".$row['id']."\" class=\"view\" data-aid=\"".$row['id']."\">".$row['title']."</a>"
                	,date('M d, Y',strtotime($row['created_on']))
                	,$row['author']
                	,"<a href=\"/cms/news/edit/".$row['id']."\" class=\"viewnews\" data-aid=\"".$row['id']."\"><i class=\"icon-pencil\"></i>  Edit</a>"
                	,"<a href=\"#\" class=\"deletenews\" data-aid=\"".$row['id']."\"><i class=\" icon-remove\"></i>  Delete</a>"
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
