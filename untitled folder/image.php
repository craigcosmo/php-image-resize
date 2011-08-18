<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//this class require autoload cookier helper and url helper
class Image {

	function scale_to_smaller($wished_width, $wished_height, $path, $name, $new_name)
	{
		$info= getimagesize($path.$name);
		$width = $info[0];
		$height = $info[1];
		$type = substr(image_type_to_extension($info[2]),1);
		$scale = $width/$height;
		$wished_scale = $wished_width/$wished_height;
				
		if(($width > $wished_width || $height > $wished_height))
		{	
			// now make the full image
			if($wished_scale > $scale){
				$new_width = $wished_height * $scale;
				$new_height = $wished_height;
			}
			elseif($wished_scale <= $scale){
				$new_width = $wished_width;
				$new_height = $wished_width * $height / $width;
			}


			if($type == 'jpg' || $type == 'jpeg'){$image = imagecreatefromjpeg($path.$name);}
			elseif($type=='gif'){$image = imagecreatefromgif($path.$name);}
			elseif($type=='png'){$image = imagecreatefrompng($path.$name);}
			
			$temp = imagecreatetruecolor($new_width, $new_height);
			
			imagealphablending($temp, false);
			imagesavealpha($temp, true);

			imagecopyresampled($temp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			if($type == 'jpg' || $type == 'jpeg'){imagejpeg($temp, $path.$new_name, 100);}
			elseif($type=='gif'){imagegif($temp, $path.$new_name);}
			elseif($type=='png'){imagepng($temp, $path.$new_name, 0);}

		}
		else
		{
			copy($path.$name, $path.$new_name);	
		}
	}
	function scale_to_bigger($wished_width, $wished_height, $path, $name, $new_name)
	{
		$info= getimagesize($path.$name);
		$width = $info[0];
		$height = $info[1];
		$type = substr(image_type_to_extension($info[2]),1);
		$scale = $width/$height;
		$wished_scale = $wished_width/$wished_height;
				
		if(($width > $wished_width || $height > $wished_height))
		{
			if($wished_scale > $scale){
				$new_width = $wished_width;
				$new_height = $wished_width * $height / $width;
			}
			elseif($wished_scale <= $scale){
				$new_width = $wished_height * $scale;
				$new_height = $wished_height;
			}
			
			if($type == 'jpg' || $type == 'jpeg'){$image = imagecreatefromjpeg($path.$name);}
			elseif($type=='gif'){$image = imagecreatefromgif($path.$name);}
			elseif($type=='png'){$image = imagecreatefrompng($path.$name);}
			
			$temp = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($temp, false);
			imagesavealpha($temp, true);

			imagecopyresampled($temp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			if($type == 'jpg' || $type == 'jpeg'){imagejpeg($temp, $path.$new_name, 100);}
			elseif($type=='gif'){imagegif($temp, $path.$new_name);}
			elseif($type=='png'){imagepng($temp, $path.$new_name, 0);}
		}
		else
		{
			copy($path.$name, $path.$new_name);
		}
	}
	function crop($wished_width, $wished_height, $path, $name, $new_name)
	{
		$info= getimagesize($path.$name);
		$width = $info[0];
		$height = $info[1];
		$type = substr(image_type_to_extension($info[2]),1);

		if($width > $height){
			$x= ($width - $wished_width)/2;
			$y= 0;
		}elseif($width <= $height){
			$x= 0;
			$y= ($height - $wished_height) / 2;
		}
		
		if($type == 'jpg' || $type == 'jpeg'){$image = imagecreatefromjpeg($path.$name);}
		elseif($type=='gif'){$image = imagecreatefromgif($path.$name);}
		elseif($type=='png'){$image = imagecreatefrompng($path.$name);}
		
		$temp = imagecreatetruecolor($wished_width, $wished_height);
		imagealphablending($temp, false);// to preserve the transparent background
		imagesavealpha($temp, true);// to preserve the transparent background

		imagecopy($temp, $image, 0, 0, $x, $y, $width, $height);
		
		
		
		if($type == 'jpg' || $type == 'jpeg'){imagejpeg($temp, $path.$new_name, 100);}
		elseif($type=='gif'){imagegif($temp, $path.$new_name);}
		elseif($type=='png'){imagepng($temp, $path.$new_name, 0);}
	}
	function delete($directory)
	{
		if(file_exists($directory)){
			unlink($directory);
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

?>