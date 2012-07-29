<?php

class Uploader extends CI_Controller
{
	function avatar()
	{
		$targetFolder = "/resources/images/avatar";
		$accountid	  = $this->input->post('accountid');
		$this->load->model('accounts_db');
		
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			
			$fileName 	= $_FILES['Filedata']['name'];
			$fileParts 	= pathinfo($fileName);
			
			
			if (in_array($fileParts['extension'],$fileTypes)) 
			{
				if(@move_uploaded_file($tempFile,$targetFile))
				{
					$data['message'] = "Successss";
					$data['filedata'] = $_FILES['Filedata'];
					
					$newFileName = $accountid.'.'.$fileParts['extension'];
					$newFileName50 = $accountid.'_50.'.$fileParts['extension'];
					$newFileName32 = $accountid.'_32.'.$fileParts['extension'];
					
					resizeimage("./{$targetFolder}/{$fileName}", "./{$targetFolder}/{$newFileName}",120,120);
					resizeimage("./{$targetFolder}/{$fileName}", "./{$targetFolder}/{$newFileName50}",50,50);
					resizeimage("./{$targetFolder}/{$fileName}", "./{$targetFolder}/{$newFileName32}",32,32);
					
					$data['newFilename'] = $newFileName;
					$this->accounts_db->set_nickname(array('avatar'=>$newFileName),$accountid);
				}
				else
				{
					$data['message'] = "Upload failed!!!";
				}
			} 
			else 
			{
				$data['message'] = "Invalid file type.";
			}
		}
		else
		{
			$data['message'] = "Upload failed!!!";
		}
		
		$data['accountid'] = $accountid;
		
		header("HTTP/1.0 200 OK");
        header("HTTP/1.1 200 OK");
        header('Last-Modified: '. gmdate("D, d M Y H:i:s") .' GMT');
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Content-type: text/json");
        echo json_encode($data);
        die();
	}
	
	function photo()
	{
		set_time_limit(0);
       
        $user = $this->input->post('id');
        
        //$users = $this->photo_db->save();
        
        $result['success']        = "false";
        $result['message']        = 'No file is attached.';

        if (isset($_FILES['Filedata']) && $_FILES['Filedata']['size'] > 0) { // Has attachment

            $tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
			
			$filename = $_FILES['Filedata']['name'];
    
            if(@move_uploaded_file($tempFile,$targetFile))
            {
				$result['message'] = "File successfully uploaded";
				$result['success']  = "true";
				$result['filename'] = $filename;
				$ext 		= '.'.substr(strrchr(strtolower($filename),'.'),1);
				
				$nfilename = uniqid().$ext;
				
				//rename("./resources/photos/mugshots/{$filename}","./resources/photos/mugshots/{$nfilename}");
				
				resizeimage("./resources/photos/mugshots/{$filename}", "./resources/photos/mugshots/{$nfilename}",170,170);
				
				$result['photo_path'] = resource_url('photos/mugshots/'.$nfilename);
				$result['filename'] = $nfilename;
				
            } 
            else
            {
                $result['message'] = "Can't upload the file. Please contact the site administrator.";
                $result['file'] = $tempFile;
                $result['targetfile'] = $targetFile;
                $result['image'] = "";
            }
            
            //$result['logs'] = $newfile;

        }

        header("HTTP/1.0 200 OK");
        header("HTTP/1.1 200 OK");
        header('Last-Modified: '. gmdate("D, d M Y H:i:s") .' GMT');
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Content-type: text/json");
        echo json_encode($result);
        die();
    }
    
}
