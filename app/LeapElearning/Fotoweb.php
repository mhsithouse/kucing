<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fotoweb
 *
 * @author User
 */
class Fotoweb extends WebService{
    public $target;
    function createTarget($id,$classname){
        $this->target = $classname."___".$id;
        return $this->target;
    }
    function attachment($id,$classname){

        $target = $this->createTarget($id, $classname);

        ?>

<style type="text/css">

    #insfoto {

				

		width:100%;

		padding: 10px;

                

	}

    #insfoto div.photos {

			margin-right: -19px;

			overflow: hidden;

		}

			#insfoto div.photos > div {

				border-radius: 3px;

				float: left;

				height: 85px;

				margin: 19px 19px 0 0;

				width: 85px;

			}

			#insfoto div.photos > div.uploading {

				border: 1px #ccc solid;

			}

			#insfoto div.photos > div.uploaded {

				background-repeat: no-repeat;

				background-position: center;

				background-size: cover;

			}

				#insfoto div.photos > div.uploading span.progress {

					background: white;

					border-radius: 2px;

					display: block;

					height: 10px;

					margin: 40px 5px;

					overflow: hidden;

				}

					#insfoto div.photos > div.uploading span.progress span {

						background: #999;

						display: block;

						height: 100%;

					}

</style>

<style type="text/css">

    .hasilpic{ padding: 10px; background-color: #dedede; width: 100%;}

    .pic_fotojax{ width: 85px; height: 85px; overflow: hidden;  }

    .container_fotoajax{float: left;margin: 5px; height: 175px; background-color: #efefef;  width: 85px;}

    .action_fotoajax{ height: 30px; line-height: 30px; text-align: center; overflow: hidden;}

    //.pic_fotojax img{ width: 85px;}

</style>    

<div id="insfoto">

    <input type="file" multiple id="fotoajaxfile" />

<div id="mypics" class="photos" style="display:none;">

</div>

</div>

    





<script type="text/javascript">

// Once files have been selected

document.querySelector('#insfoto input[type=file]').addEventListener('change', function(event){



	// Read files

	var files = event.target.files;



	// Iterate through files

	for (var i = 0; i < files.length; i++) {

                $('#loadingfotoajax').fadeIn();

		// Ensure it's an image

		if (files[i].type.match(/image.*/)) {



			// Load image

			var reader = new FileReader();

			reader.onload = function (readerEvent) {

				var image = new Image();

				image.onload = function (imageEvent) {



					// Add elemnt to page

					var imageElement = document.createElement('div');

					imageElement.classList.add('uploading');

					imageElement.innerHTML = '<span class="progress"><span></span></span>';

					var progressElement = imageElement.querySelector('span.progress span');

					progressElement.style.width = 0;

					document.querySelector('#insfoto div.photos').appendChild(imageElement);



					// Resize image

					var canvas = document.createElement('canvas'),

						max_size = 500,

						width = image.width,

						height = image.height;

					if (width > height) {

						if (width > max_size) {

							height *= max_size / width;

							width = max_size;

						}

					} else {

						if (height > max_size) {

							width *= max_size / height;

							height = max_size;

						}

					}

					canvas.width = width;

					canvas.height = height;

					canvas.getContext('2d').drawImage(image, 0, 0, width, height);



					// Upload image

					var xhr = new XMLHttpRequest();

					if (xhr.upload) {



						// Update progress

						xhr.upload.addEventListener('progress', function(event) {

							var percent = parseInt(event.loaded / event.total * 100);

							progressElement.style.width = percent+'%';

						}, false);



						// File uploaded / failed

						xhr.onreadystatechange = function(event) {

							if (xhr.readyState == 4) {

								if (xhr.status == 200) {



									imageElement.classList.remove('uploading');

									imageElement.classList.add('uploaded');

									imageElement.style.backgroundImage = 'url(<?=_PHOTOURL;?>'+xhr.responseText+')';

                                                                        $('#notif_pics').val($('#notif_pics').val()+','+xhr.responseText);

                                                                        $('#picsisi').empty().append(xhr.responseText);

									console.log('Image uploaded: '+xhr.responseText);

                                                                        savePics();



								} else {

									imageElement.parentNode.removeChild(imageElement);

								}

							}

						}



						// Start upload

						xhr.open('post', '<?=_SPPATH;?>fotoweb/uploadres', true);

						xhr.send(canvas.toDataURL('image/jpeg'));



					}



				}



				image.src = readerEvent.target.result;



			}

			reader.readAsDataURL(files[i]);

		}

            $('#loadingfotoajax').fadeOut();

	}

        //$('mypics').fade('in');

	// Clear files

	event.target.value = '';

        

        

       //alert($('picsisi').html());



});



function savePics(){
    $.post('<?=_SPPATH;?>fotoweb/savePics?target=<?=$target;?>',{pics: $('#picsisi').html()}, function( data ) {
          console.log("Succesful", data);
          if(parseInt(data) == 1){
              $('#picsisi').empty();
              $('#hasilpic').load('<?=_SPPATH;?>fotoweb/getPics?ajfoto=1&target=<?=$target;?>');
          }
          else alert('Failed');
    });       
}



function deleteFotoAjax(pid){
    $.post('<?=_SPPATH;?>fotoweb/delPics',{pics: pid}, function( data ) {
          console.log("Succesful", data);
          if(parseInt(data) == 1){
              alert('Deleted');
              $('#picsisi').empty();
              $('#hasilpic').load('<?=_SPPATH;?>fotoweb/getPics?ajfoto=1&target=<?=$target;?>');
          }
          else alert('Failed');
    });
}



function updateTitleFotoAjax(pid,isi){
    $.post('<?=_SPPATH;?>fotoweb/updateTitlePics',{pics: pid , isi : isi}, function( data ) {
          console.log("Succesful", data);
          if(parseInt(data) == 1){
              alert('Updated');
              $('#picsisi').empty();
              $('#hasilpic').load('<?=_SPPATH;?>fotoweb/getPics?ajfoto=1&target=<?=$target;?>');
          }
          else alert('Failed');
    });    
}

</script>

<div id="loadingfotoajax" style="display:none; background-color: red; color: white; padding: 10px; position: absolute;">Loading..</div>

<div id="hasilpic"><? $_GET['target']=$target; $this->getPics(); ?></div>

<div style="clear:both;"></div>

<div id="picsisi" style="display:none;"><?=$obj->tme_pics;?></div>

    <input type="hidden" id="notif_pics" name="notif_pics" value="<?=$obj->tme_pics;?>">

</div>    

        <?        
    }
    
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



// Clean up memory

unset($data);

unset($image);



// Return file URL

//echo _BPATH.'uploadfotoajax/'.$filename;
echo $filename;


exit();

    }

    
     var $access_savePics = "murid";

    function savePics(){

        global $db;

        $isi = addslashes($_POST['pics']);

        $target = addslashes($_GET['target']);

        $q = "INSERT INTO sp_fotoajax SET 

photo_target_id	= '$target',

photo_date = now(),

photo_comment_count = 0,

photo_filename = '$isi'    

";

        echo $db->query($q,0);

        //pr($_GET);pr($_POST);

       // echo "hoho";

        exit();

    }

     var $access_getPics = "murid";

    function getPics(){

        global $db;

        $isi = (isset($_POST['pics'])?addslashes($_POST['pics']):'');

        $target = addslashes($_GET['target']);

        $q = "SELECT * FROM sp_fotoajax WHERE photo_target_id= '$target'";

       // echo $q;

        $arr = $db->query($q,2);

        //pr($arr);

        foreach ($arr as $p){

            if($p->photo_description =="")$p->photo_description ="Untitled";

        ?>

<div class="container_fotoajax">

<div class="pic_fotojax">

    <a href="<?=_PHOTOURL;?><?=$p->photo_filename;?>" rel="lightbox" title="<?=$p->photo_description;?>"><img id='pid<?=$p->photo_id;?>' src="<?=_PHOTOURL;?><?=$p->photo_filename;?>" onload="OnImageLoad(event,85);"></a>    

</div>

    <div class="action_fotoajax"><input type="text" value="<?=_PHOTOURL;?><?=$p->photo_filename;?>"></div>

    <div class="action_fotoajax" contenteditable="true" id='spid<?=$p->photo_id;?>'><?=$p->photo_description;?></div>

    <div class="action_fotoajax" onclick="if(confirm('<?=Lang::t('lang_are_you_sure');?>')){deleteFotoAjax('<?=$p->photo_id;?>');}">del</div>

</div>

<script type="text/javascript">

    $('#spid<?=$p->photo_id;?>').blur(function(){

        updateTitleFotoAjax('<?=$p->photo_id;?>',$('#spid<?=$p->photo_id;?>').html());

    });

    </script>

            <?

        }

        //pr($_GET);pr($_POST);

       // echo "hoho";
        
        //Xif($_GET['ajfoto']) exit();

    }

    var $access_getPicsReadOnly = "murid";

    function getPicsReadOnly($target){

        global $db;
        
        $q = "SELECT * FROM sp_fotoajax WHERE photo_target_id= '$target'";

        $arr = $db->query($q,2);
        //echo $q;
        //pr($arr);
        if(count($arr)==0)echo Lang::t('no photos yet');
        foreach ($arr as $p){

            if($p->photo_description =="")$p->photo_description ="Untitled";

        ?>


<div class="foto85">
    <a target="_blank" href="<?=_PHOTOURL;?><?=$p->photo_filename;?>" title="<?=$p->photo_description;?>"><img id='pid<?=$p->photo_id;?>' src="<?=_PHOTOURL;?><?=$p->photo_filename;?>" onload="OnImageLoad(event,85);"></a>    
</div> 

            <?

        }
        ?>
    <div style="clear:both;"></div>
        <?

    }



      var $access_delPics = "murid";

    function delPics(){

        global $db;

        $pid = addslashes($_POST['pics']);

       // $target = addslashes($_GET['target']);

        $q = "DELETE FROM sp_fotoajax WHERE photo_id = '$pid'";

        echo $db->query($q,0);

        //pr($_GET);pr($_POST);

       // echo "hoho";

        exit();

    }

     var $access_updateTitlePics = "murid";

    function updateTitlePics(){

        global $db;

        $pid = addslashes($_POST['pics']);

        $isi = addslashes($_POST['isi']);

       // $target = addslashes($_GET['target']);

        $q = "UPDATE sp_fotoajax SET photo_description = '$isi' WHERE photo_id = '$pid'";

        echo $db->query($q,0);

        //pr($_GET);pr($_POST);

       // echo "hoho";

        exit();

    }


}
