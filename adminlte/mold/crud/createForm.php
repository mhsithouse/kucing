<?
//pr($arr);
$c = $classname;
$obj = $id;
$t = time();
?>
<div id="resultme"></div>
<form role="form" method="<?=$method;?>" action="<?=$action;?>" id="<?=$formID;?>">
 <?
 foreach($formColoms as $inputID=>$input){ 
     if($input instanceof \Leap\View\InputText)
     if($input->type == "hidden"){ $input->p(); continue;}
     ?>   
    <div id="formgroup_<?=$input->id;?>" class="form-group">
        <label for="<?=$inputID;?>" class="col-sm-2 control-label"><?=Lang::t($inputID);?></label>
        <div class="col-sm-10">
        <?=$input->p();?>
            <span class="help-block" id="warning_<?=$input->id;?>"></span>    
        </div>
    </div>
    <? } ?>    
    <div class="form-group">
        <div class="col-sm-10">
        <?      
            if($arr[id]->print == '1'){
            ?>
            <button id = "print_<?=$t;?>" type="button" class="btn btn-default glyphicon glyphicon-print" onClick="window.print()"></button>
               <? 
            }
        ?> 
            
        <button type="submit" class="btn btn-default"><?=Lang::t('submit');?></button>
        
        <? if($load){?>
        <button type="button" id="delete_button_<?=$formID;?>" class="btn btn-default"><?=Lang::t('delete');?></button>
        <? 
        $ajax->delete("delete_button_".$formID);
        }?>
        </div>
    </div>
</form>
<div class="clearfix visible-xs-block"></div>
<script>
    $('#print_<?=$t;?>').click(function(){
      openLw('printuser_<?=$t;?>','<?=_SPPATH;?>Efindi/printest?admin_username=<?=$arr[id]->admin_username;?>&admin_password=<?=$arr[id]->admin_password;?>&admin_nama_depan=<?=$arr[id]->admin_nama_depan;?>','fade');
});
</script>
<?php
$ajax->submit();



//Ajax::submit($arr);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

