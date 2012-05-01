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
                "id" => $row['_id'],
                "cell" => array(
                	 "<a href=\"/cms/news/edit/".$row['_id']."\" class=\"view\" data-aid=\"".$row['_id']."\">".$row['news_title']."</a>"
                	,date('M d, Y',strtotime($row['created']))
                	,$row['author']
                	,"<a href=\"/cms/news/edit/".$row['_id']."\" class=\"viewnews\" data-aid=\"".$row['_id']."\"><i class=\"icon-pencil\"></i>  Edit</a>"
                	,"<a href=\"#\" class=\"deletenews\" data-aid=\"".$row['_id']."\"><i class=\" icon-remove\"></i>  Delete</a>"
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
