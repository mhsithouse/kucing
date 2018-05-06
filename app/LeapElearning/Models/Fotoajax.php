<?php

/*
 * Foto, das im Wall eingepostet ist, wird in dieser Funktions aufgerufen!
 * 
 * 
 */

/**
 * Description of Fotoajax
 *
 * @author User
 */
class Fotoajax extends Model{
    public $table_name = "sp_fotoajax";
    public $main_id = "photo_id";
    
    public $default_read_coloms = "photo_id,photo_target_id,photo_filename";
    
    public $photo_id;
    public $gallery_id;
    public $photo_description;
    public $photo_target_id;
    public $photo_date;
    public $photo_comment_count;
    public $photo_filename;
    public $photo_left;
    public $photo_right;
    
    /*
     * printfoto
     */
    public function printFoto(){
        $p = $this;
        $url = $p->photo_filename;
        $t = time()*rand(1,50);
        ?>
        <!--<div id="pic<?=$t;?>" class='col-lg-2 col-md-3 col-sm-6 col-xs-12'>
            <div class="hehe">
                <a target="_blank" href="<?=_PHOTOURL;?><?= $url; ?>" class="thumbnail"   <? if ($p->photo_description != "untitled") { ?> title="<?= $p->photo_description; ?>" <? } ?>>
                <img src='<?=_PHOTOURL;?><?= $url; ?>' class="img-rounded img-responsive">
                </a>
            </div>    
            <div class="pdesc" style="margin-top: -20px; width: 100%; text-align: center;">
                <?=$p->photo_description;?>
            </div>
        </div>
        -->
		
		
            <div class="hehe">
                <a target="_blank" href="<?=_PHOTOURL;?><?= $url; ?>"   <? if ($p->photo_description != "untitled") { ?> title="<?= $p->photo_description; ?>" <? } ?>>
                <img src='<?=_PHOTOURL;?><?= $url; ?>' >
                </a>
            </div>    
           
        <?
    }
    
}
