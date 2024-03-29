<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

function theme()
{
    $ci =& get_instance();
    
    $currentTheme = $ci->config->item('ThemeName');
    
    return 'themes/'.$currentTheme.'/';
    
}

if ( ! function_exists('resource_url'))
{
    function resource_url($uri = '',$folder = '')
    {
        $CI =& get_instance();

        $url = config_item('css_url');

        if (!$url) $url = base_url();
		
		if(!$folder) $folder = 'resource_folder';
		
        return $url.config_item($folder).$uri;
    }
}

function phpStat_inet_aton($ip)
{
$chunks = explode('.', $ip);
return $chunks[0]*pow(256,3) + $chunks[1]*pow(256,2) + $chunks[2]*256 + $chunks[3];
}

if ( ! function_exists('url_friendly'))
{
	function url_friendly($url)
		{
			$url = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $url), '-'));
			return $url;
		}
}



if ( ! function_exists('resizeimage')) 
{ 
    function resizeimage($oldfile, $newfile, $max_w, $max_h, $crop = true) {
        // Get Image Info
        list($org_w, $org_h, $org_t) = getimagesize($oldfile);
        switch($org_t) {
            case IMAGETYPE_GIF:
                $image    = imagecreatefromgif($oldfile);
                break;
            case IMAGETYPE_JPEG:
                $image    = imagecreatefromjpeg($oldfile);
                break;
            case IMAGETYPE_PNG:
                $image    = imagecreatefrompng($oldfile);
                break;
            default:
                $image    = imagecreatefromjpeg($oldfile);
        }

        // Resize Image
        $oldw    = $org_w;
        $oldh    = $org_h;
        $neww    = $max_w;
        $newh    = $max_h;
        
        if ($oldw > $neww || $oldh > $newh) {
            $ratio = ($neww / $newh);

            if ($crop) {
                if ($oldw > ($oldh * $ratio)) {
                    $curw    = $oldh * $ratio;
                    $curh    = $oldh;
                } else {
                    $curw    = $oldw;
                    $curh    = $oldw / $ratio;
                }
        
                $curx    = ($oldw - $curw) / 4;
                $cury    = ($oldh - $curh) / 3;

                $resize    = imagecreatetruecolor($neww, $newh);
                imagecopyresampled($resize, $image, 0, 0, $curx, $cury, $neww, $newh, $curw, $curh);
            } else {
                if ($oldw > ($oldh * $ratio)) {
                    $curw    = $neww;
                    $curh    = $neww * $oldh / $oldw;
                } else {
                    $curw    = $newh * $oldw / $oldh;
                    $curh    = $newh;
                }

                $resize    = imagecreatetruecolor($curw, $curh);
                imagecopyresampled($resize, $image, 0, 0, 0, 0, $curw, $curh, $oldw, $oldh);
            }
        } else {
            $resize        = $image;
        }
        imagejpeg($resize, $newfile, 100);
    }
}

if(!function_exists('imageblob_thumb'))
{
    function imageblob_thumb($fileblob,$file_type,$width = 90, $height = 90, $quality = 100, $border_radius = 5, $background_color = 'FFFFFF')
    {
        $thumb = createThumbnailFromBLOB($file_type, $width, $height, $fileblob, $quality, $border_radius, $background_color);

        return $thumb;
    }
}
if(!function_exists('createThumbnailFromBLOB'))
{
    function createThumbnailFromBLOB($file_type, $max_width, $max_height, $blob, $quality = 100, $border_radius = 0, $background_color = 'FFFFFF')
    {
            $thumb = cropResizeImage($file_type, $max_width, $max_height, $blob, $quality);
            //if ($border_radius > 0)
                //$thumb = $this->_imageRoundBorder($thumb, $max_width, $max_height, $border_radius, $background_color);

            ob_start();
            header("Content-type: {$file_type}");
            $expires = 60*60*24*365;
            header("Last-Modified: " . gmdate("M d Y H:i:s", time()) . " GMT");
            header("Pragma: public");
            header("Cache-Control: public, maxage=".$expires);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
            imagejpeg($thumb, null, $quality);
            ob_flush();
            die();
    }
}

function cropResizeImage($file_type, $max_width, $max_height, $blob, $quality) {
            $crop_height=$max_height;
            $crop_width=$max_width;
            // get originalsize of image
            $im             = imagecreatefromstring($blob);
            $original_width     = imagesx($im);
            $original_height     = imagesy($im);
            $original_image_gd    = $im;

            $cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
            ImageFill($cropped_image_gd, 1, 1, ImageColorAllocate($cropped_image_gd, 255, 255, 255));

            $wm = $original_width /$crop_width;
            $hm = $original_height /$crop_height;
            $h_height = $crop_height/2;
            $w_height = $crop_width/2;

            if($original_width > $original_height ) {
                $adjusted_width =$original_width / $hm;
                $half_width = $adjusted_width / 2;
                $int_width = $half_width - $w_height;
                imagecopyresampled($cropped_image_gd ,$original_image_gd ,-$int_width,0,0,0, $adjusted_width, $crop_height, $original_width , $original_height );
            }
            elseif(($original_width < $original_height ) || ($original_width == $original_height )) {
                $adjusted_height = $original_height / $wm;
                $half_height = $adjusted_height / 2;
                $int_height = $half_height - $h_height;
                imagecopyresampled($cropped_image_gd , $original_image_gd ,0,-$int_height,0,0, $crop_width, $adjusted_height, $original_width , $original_height );
            }
            else {
                imagecopyresampled($cropped_image_gd , $original_image_gd ,0,0,0,0, $crop_width, $crop_height, $original_width , $original_height );
            }

            return $cropped_image_gd;
    }
	
	function months()
	{
		$months = array(
					1 => 'Jan',
					2 => 'Feb',
					3 => 'Mar',
					4 => 'Apr',
					5 => 'May',
					6 => 'Jun',
					7 => 'Jul',
					8 => 'Aug',
					9 => 'Sep',
					10 => 'Oct',
					11 => 'Nov',
					12 => 'Dec',
					);
		
		return $months;
	}
	
	function month($m)
	{
		$months = array(
					1 => 'Jan',
					2 => 'Feb',
					3 => 'Mar',
					4 => 'Apr',
					5 => 'May',
					6 => 'Jun',
					7 => 'Jul',
					8 => 'Aug',
					9 => 'Sep',
					10 => 'Oct',
					11 => 'Nov',
					12 => 'Dec',
					);
		
		$month = element($m,$months);
		
		return $month;
	}
	
	function religion($r)
	{
			$religion = array(
						1 => 'Christianity - Catholic',
						2 => 'Christianity - Others',
						3 => 'Islam',
						4 => 'Other',
						);
			
			$religion = element($r,$religion);
			
			return $religion;
		}
		
	function ago($timestamp)
	{
		date_default_timezone_set('Asia/Manila');
		
		$difference = time() - strtotime($timestamp);
		$periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		for($j = 0; $difference >= $lengths[$j]; $j++)
		$difference /= $lengths[$j];
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
		$text = "$difference $periods[$j] ago";
			
		return $text;//date('Y-m-d H:i:s',strtotime($timestamp));
	}
		
	function resizeimage($oldfile, $newfile, $max_w = 50, $max_h = 50, $crop = true) {
		// Get Image Info
		list($org_w, $org_h, $org_t) = getimagesize($oldfile);
		switch($org_t) {
			case IMAGETYPE_GIF:
				$image	= imagecreatefromgif($oldfile);
				break;
			case IMAGETYPE_JPEG:
				$image	= imagecreatefromjpeg($oldfile);
				break;
			case IMAGETYPE_PNG:
				$image	= imagecreatefrompng($oldfile);
				break;
			default:
				$image	= imagecreatefromjpeg($oldfile);
		}

		// Resize Image
		$oldw	= $org_w;
		$oldh	= $org_h;
		$neww	= $max_w;
		$newh	= $max_h;
		
		if ($oldw > $neww || $oldh > $newh) {
			$ratio = ($neww / $newh);

			if ($crop) {
				if ($oldw > ($oldh * $ratio)) {
					$curw	= $oldh * $ratio;
					$curh	= $oldh;
				} else {
					$curw	= $oldw;
					$curh	= $oldw / $ratio;
				}
		
				$curx	= ($oldw - $curw) / 2;
				$cury	= ($oldh - $curh) / 2;

				$resize	= imagecreatetruecolor($neww, $newh);
				imagecopyresampled($resize, $image, 0, 0, $curx, $cury, $neww, $newh, $curw, $curh);
			} else {
				if ($oldw > ($oldh * $ratio)) {
					$curw	= $neww;
					$curh	= $neww * $oldh / $oldw;
				} else {
					$curw	= $newh * $oldw / $oldh;
					$curh	= $newh;
				}

				$resize	= imagecreatetruecolor($curw, $curh);
				imagecopyresampled($resize, $image, 0, 0, 0, 0, $curw, $curh, $oldw, $oldh);
			}
		} else {
			$resize		= $image;
		}
		imagejpeg($resize, $newfile, 100);
	}
	
	
	function json_exit($json)
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
		header("Cache-Control: no-cache, must-revalidate" ); 
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if (isset($json)) echo json_encode($json);
		exit;		
	}
	
	function checkSession()
	{
		$CI =& get_instance();
		
		$CI->load->library('session');
		
		$user = $CI->session->userdata('accountid');
		
		if($CI->input->is_ajax_request())
		{
			if(!$user)
			{
				$data['session'] = "false";
				$json = $data;
				
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
				header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
				header("Cache-Control: no-cache, must-revalidate" ); 
				header("Pragma: no-cache" );
				header("Content-type: text/x-json");
				if (isset($json)) echo json_encode($json);
				exit;
			}
		}
		else
		{
			if(!$user) redirect();
		}
	}
	
	
	if ( ! function_exists('url_friendly'))
	{
		function url_friendly($url)
			{
				$url = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $url), '-'));
				return $url;
			}
	}
	
	function mongoID($id)
	{
		$ci =& get_instance();
		
		$ci->load->library('mongo_db');
		
		$mongoid = $ci->mongo_db->mongoID($id);
		
		return $mongoid;
	}
	
	function parseurl($string)
	{
		$url = preg_replace("/http:\/\/([^\/]+)[^\s]*/", "<a href='$0' target='_blank'>$0</a>", $string);
		 
		return $url;
	}

	
	function push_url($url="")
	{
		$ci =& get_instance();
		
		$base_uri = config_item('BaseURI');
		
		if($base_uri == "")
			$base_uri = "";
		else
			$base_uri = "/".$base_uri;
		
		$uri = $base_uri."/".$url;
		
		if(empty($url)) $uri = "/".config_item('BaseURI');
		
		return $uri;
	}
	
	function isAdmin($account_id)
	{
		$ci =& get_instance();
	}
	
	
	function itemTypes($type)
	{
		$types = config_item('itemTypes');
		
		$text = element($type,$types);
		
		return $text;
	}
	
	function imagecreatefrombmpstring($im) 
	{
		$header = unpack("vtype/Vsize/v2reserved/Voffset", substr($im, 0, 14));
		$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", substr($im, 14, 40));
		extract($info);
		extract($header);
		if($type != 0x4D42)
			return false;
		$palette_size = $offset - 54;
		$ncolor = $palette_size / 4;
		$imres=imagecreatetruecolor($width, $height);
		imagealphablending($imres, false);
		imagesavealpha($imres, true);
		$pal=array();
		if($palette_size) {
			$palette = substr($im, 54, $palette_size);
			$gd_palette = "";
			$j = 0; $n = 0;
			while($j < $palette_size) {
				$b = ord($palette{$j++});
				$g = ord($palette{$j++});
				$r = ord($palette{$j++});
				$a = ord($palette{$j++});
				if ( ($r & 0xf8 == 0xf8) && ($g == 0) && ($b & 0xf8 == 0xf8))
					$a = 127; // alpha = 255 on 0xFF00FF
				$pal[$n++] = imagecolorallocatealpha($imres, $r, $g, $b, $a);
			}
		}
		$scan_line_size = (($bits * $width) + 7) >> 3;
		$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03): 0;
		for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
			$scan_line = substr($im, $offset + (($scan_line_size + $scan_line_align) * $l), $scan_line_size);
			if($bits == 24) {
				$j = 0; $n = 0;
				while($j < $scan_line_size) {
					$b = ord($scan_line{$j++});
					$g = ord($scan_line{$j++});
					$r = ord($scan_line{$j++});
					$a = 0;
					if ( ($r & 0xf8 == 0xf8) && ($g == 0) && ($b & 0xf8 == 0xf8))
						$a = 127; // alpha = 255 on 0xFF00FF
					$col=imagecolorallocatealpha($imres, $r, $g, $b, $a);
					imagesetpixel($imres, $n++, $i, $col);
				}
			}
			else if($bits == 8) {
				$j = 0;
				while($j < $scan_line_size) {
					$col = $pal[ord($scan_line{$j++})];
					imagesetpixel($imres, $j-1, $i, $col);
				}
			}
			else if($bits == 4) {
				$j = 0; $n = 0;
				while($j < $scan_line_size) {
					$byte = ord($scan_line{$j++});
					$p1 = $byte >> 4;
					$p2 = $byte & 0x0F;
					imagesetpixel($imres, $n++, $i, $pal[$p1]);
					imagesetpixel($imres, $n++, $i, $pal[$p2]);
				}
			}
			else if($bits == 1) {
				$j = 0; $n = 0;
				while($j < $scan_line_size) {
					$byte = ord($scan_line{$j++});
					$p1 = (int) (($byte & 0x80) != 0);
					$p2 = (int) (($byte & 0x40) != 0);
					$p3 = (int) (($byte & 0x20) != 0);
					$p4 = (int) (($byte & 0x10) != 0);
					$p5 = (int) (($byte & 0x08) != 0);
					$p6 = (int) (($byte & 0x04) != 0);
					$p7 = (int) (($byte & 0x02) != 0);
					$p8 = (int) (($byte & 0x01) != 0);
					imagesetpixel($imres, $n++, $i, $pal[$p1]);
					imagesetpixel($imres, $n++, $i, $pal[$p2]);
					imagesetpixel($imres, $n++, $i, $pal[$p3]);
					imagesetpixel($imres, $n++, $i, $pal[$p4]);
					imagesetpixel($imres, $n++, $i, $pal[$p5]);
					imagesetpixel($imres, $n++, $i, $pal[$p6]);
					imagesetpixel($imres, $n++, $i, $pal[$p7]);
					imagesetpixel($imres, $n++, $i, $pal[$p8]);
				}
			}
		}
		return $imres;
	}

