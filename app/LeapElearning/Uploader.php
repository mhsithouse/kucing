<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploader
 *
 * @author User
 */
class Uploader extends WebService {
    function uploadres(){
			
            // Generate filename
            $filename = md5(mt_rand()).'.jpg';

            // Read RAW data
            $data = file_get_contents('php://input');

            // Read string as an image file
            $image = file_get_contents('data://'.substr($data, 5));

            // Save to disk
            if ( ! file_put_contents(_PHOTOPATH.$filename, $image)) {
                    header('HTTP/1.1 503 Service Unavailable');
                    exit();
            }

           // $src = 'uploadclass2/'.$filename;
           // $dest = 'uploadclass2/'."tn__".$filename;
           // make_thumb($src, $dest, 200);

            // Clean up memory
            unset($data);
            unset($image);

            // Return file URL
            echo $filename;
            //exit();
					
	}
}
