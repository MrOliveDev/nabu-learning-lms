<?php
include( dirname( __FILE__ ) . '/../config/config.php' );
if(isset($_POST['file']))
{
    if($_POST['type'] == 'img'){ // Image Converter using PHP GD Library
    	$path = $_POST['file'];
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($path);
            if($exif && isset($exif['Orientation'])) {
              $orientation = $exif['Orientation'];
              if($orientation != 1){
                $img = imagecreatefromjpeg($path);
                $deg = 0;
                switch ($orientation) {
                  case 3:
                    $deg = 180;
                    break;
                  case 6:
                    $deg = 270;
                    break;
                  case 8:
                    $deg = 90;
                    break;
                }
                if ($deg) {
                  $img = imagerotate($img, $deg, 0);        
                }
                // then rewrite the rotated image back to the disk as $filename 
                imagejpeg($img, $path, 95);
              } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists 

    	$mime = getimagesize($path);
    	if($mime['mime']=='image/png') { 
	        $src_img = imagecreatefrompng($path);
	    }
	    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
	        $src_img = imagecreatefromjpeg($path);
	    }   
	    $old_x = imageSX($src_img);
    	$old_y = imageSY($src_img);
    	$convFlag = false;
    	if($old_x > 1280) 
	    {
	        $new_width = 1280;
	        $new_height = $old_y*(1280/$old_x);
	        $convFlag = true;
	    }
    	else if($old_y > 800) 
	    {
	        $new_width = $old_x*(800/$old_y);
	        $new_height = 800;
	        $convFlag = true;
	    }
	    if($convFlag){
	    	$dst_img = ImageCreateTrueColor($new_width, $new_height);
            ImageAlphaBlending( $dst_img, false );
            ImageSaveAlpha( $dst_img, true );
		    imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_width,$new_height,$old_x,$old_y);
		    if($mime['mime']=='image/png') {
		        $result = imagepng($dst_img, $path, 8);
		    }
		    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
		        $result = imagejpeg($dst_img, $path, 80);
		    }

		    imagedestroy($dst_img); 	
	    }
	    
	    imagedestroy($src_img);
	    echo json_encode(array('width' => $old_x, 'height' => $old_y, 'newwidth' => $new_width, 'newheight' => $new_height));
    }
    else{ // Video Converter Using AVCONV / FFMPEG Service
        if(VIDEO_CONVERTER_TYPE == "ffmpeg"){
            $rotate = " -metadata:s:v:0 rotate=0 ";

            // get rotation of the video
            ob_start();
            passthru("mediainfo " . $_POST['file'] . " | grep Rotation 2>&1");
            $duration_output = ob_get_contents();
            ob_end_clean();

            // rotate?
            if (preg_match('/Rotation *: (.*?)\n/', $duration_output, $matches))
            {
                $rotation = $matches[1];
                if (strpos($rotation, "90") !== false)
                    $rotate .= '-vf "transpose=1" ';
                else if (strpos($rotation, "180") !== false)
                    $rotate .= '-vf "transpose=1,transpose=1" ';
                else if (strpos($rotation, "270") !== false)
                    $rotate .= '-vf "transpose=2" ';
            }

            require_once('getid3/getid3.php');
            $getID3 = new getID3;
            $file = $getID3->analyze($_POST['file']);

            $dimension = "";
            $convFlag = false;
            if($file != null && !empty($file['video'])){
                if($file['video']['resolution_x'] > 1280){
                    $new_width = 1280;
                    $new_height = intval($file['video']['resolution_y'] * (1280 / $file['video']['resolution_x']));
                    if($new_height % 2 != 0)
                        $new_height ++;
                    $convFlag = true;
                } else if($file['video']['resolution_y'] > 800){
                    $new_height = 800;
                    $new_width = intval($file['video']['resolution_x'] * (800 / $file['video']['resolution_y']));
                    if($new_width % 2 != 0)
                        $new_width ++;
                    $convFlag = true;
                }
                if($convFlag)
                    $dimension = $new_width . "x" . $new_height;
            }

            $info = pathinfo($_POST['file']);
            if(strtolower($info['extension']) == 'mp4' && $_POST['type'] == 'mp4'){
                $src = $info['dirname'].'/'.$info['filename'].'_original.'.$info['extension'];
                rename($_POST['file'], $src);
            } else
                $src = $_POST['file'];

            $dst = '"'.$info['dirname'].'/'.$info['filename'].'.'.$_POST['type'].'"';

            $command = 'ffmpeg -y -i "'.$src.'"' . $rotate . '-vcodec libx264 -acodec copy -ar 44100 ' . ($dimension != "" ? "-s ".$dimension : "") . ' ' . ($_POST['type'] == 'flv' ? '-crf 28 ' : '') . $dst.' 1> '.dirname(__FILE__) .'/block.txt'.' 2>&1';
            exec($command);
            unlink($src);

            $thumbnailCommand = 'ffmpeg -i "' . $dst . '" -ss 00:00:01.000 -vframes 1 "' . $info['dirname'].'/'.$info['filename'].'_thumbnail.jpg' . '"';
            exec($thumbnailCommand);
            
            echo json_encode($command);
        } else {
            $rotate = "";

            // get rotation of the video
            ob_start();
            passthru("mediainfo " . $_POST['file'] . " | grep Rotation 2>&1");
            $duration_output = ob_get_contents();
            ob_end_clean();

            // rotate?
            if (preg_match('/Rotation *: (.*?)\n/', $duration_output, $matches))
            {
                $rotation = $matches[1];
                if (strpos($rotation, "90") !== false)
                    $rotate .= ' --rotate=4';
                else if (strpos($rotation, "180") !== false)
                    $rotate .= ' --rotate=3';
                else if (strpos($rotation, "270") !== false)
                    $rotate .= ' --rotate=7';
            }

            require_once('getid3/getid3.php');
            $getID3 = new getID3;
            $file = $getID3->analyze($_POST['file']);

            // $dimension = false;
            $convFlag = false;
            if($file != null && !empty($file['video'])){
                if($file['video']['resolution_x'] > 1280){
                    $new_width = 1280;
                    $new_height = intval($file['video']['resolution_y'] * (1280 / $file['video']['resolution_x']));
                    if($new_height % 2 != 0)
                        $new_height ++;
                    $convFlag = true;
                } else if($file['video']['resolution_y'] > 800){
                    $new_height = 800;
                    $new_width = intval($file['video']['resolution_x'] * (800 / $file['video']['resolution_y']));
                    if($new_width % 2 != 0)
                        $new_width ++;
                    $convFlag = true;
                }
            }

            $info = pathinfo($_POST['file']);
            if(strtolower($info['extension']) == 'mp4' && $_POST['type'] == 'mp4'){
                $src = $info['dirname'].'/'.$info['filename'].'_original.'.$info['extension'];
                rename($_POST['file'], $src);
            } else
                $src = $_POST['file'];

            $dst = '"'.$info['dirname'].'/'.$info['filename'].'.'.$_POST['type'].'"';

            $command = 'HandBrakeCLI -i "'.$src.'" -e x264 -R44.1 ' . ($convFlag ? "--width ".$new_width . " --height " . $new_height : "") . ' -o ' . $dst.$rotate.' 1> '.dirname(__FILE__) .'/block.txt'.' 2>&1';
            exec($command);
            unlink($src);

            $thumbnailCommand = 'ffmpeg -i "' . $dst . '" -ss 00:00:01.000 -vframes 1 "' . $info['dirname'].'/'.$info['filename'].'_thumbnail.jpg' . '"';
            exec($thumbnailCommand);

            echo json_encode($command . '/' . $thumbnailCommand);
        }
    }
}
else if(isset($_POST['progress'])) // Progress API for Video Converter
{
    $content = @file_get_contents('block.txt');

    if($content){
        if(VIDEO_CONVERTER_TYPE == "ffmpeg"){
            //get duration of source
            preg_match("/Duration: (.*?), start:/", $content, $matches);
            if(count($matches) <= 1)
            {
                $result['result'] = 'failed';
                $result['progress'] = 0;
                echo json_encode($result);
            }
            else
            {
                $rawDuration = $matches[1];

                //rawDuration is in 00:00:00.00 format. This converts it to seconds.
                $ar = array_reverse(explode(":", $rawDuration));
                $duration = floatval($ar[0]);
                if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
                if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

                //get the time in the file that is already encoded
                preg_match_all("/time=(.*?) bitrate/", $content, $matches);
                if(count($matches) <= 1)
                {
                    $result['result'] = 'failed';
                    $result['progress'] = 0;
                    echo json_encode($result);
                }
                else
                {
                    $rawTime = array_pop($matches);

                    //this is needed if there is more than one match
                    if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

                    //rawTime is in 00:00:00.00 format. This converts it to seconds.
                    $ar = array_reverse(explode(":", $rawTime));
                    $time = floatval($ar[0]);
                    if (!empty($ar[1])) $time += intval($ar[1]) * 60;
                    if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

                    //calculate the progress
                    $progress = round(($time/$duration) * 100);

                    $result = array();
                    $result['result'] = 'success';
                    $result['progress'] = $progress;

                    echo json_encode($result);
                }
            }       
        } else {
            //get duration of source
            preg_match_all("/task 1 of 1, (.*?) %/", $content, $matches);
            if(count($matches) <= 1)
            {
                $result['result'] = 'failed';
                $result['progress'] = 0;
                echo json_encode($result);
            }
            else
            {
                $progress = array_pop($matches);
                $result = array();
                $result['result'] = 'success';
                $result['progress'] = floatval($progress);

                echo json_encode($result);
            }
        }
    }
    else
    {
        $result['result'] = 'fail';
        $result['progress'] = 0;
        echo json_encode($result);
    }
}
else
{
    $result['result'] = 'fail';
    $result['progress'] = 0;
    echo json_encode($result);
}
?>