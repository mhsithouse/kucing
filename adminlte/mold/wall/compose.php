<?
$targetClass = (isset($mode)?$mode:"kelaswall");
?>
<form id="composewall<?=$id;?>" role="form" class="form" role="form" method="post" action="<?=_SPPATH;?><?=$webClass;?>/<?=$method;?>?cmd=add&id=<?=$id;?>&klsid=<?=$klsid;?>&typ=<?=$typ;?>" >  
  <div class="form-group">
      <textarea class="form-control" name="wall_msg" rows="3"></textarea>
  </div>
    <button type="submit" class="btn btn-default"><?=Lang::t('Submit');?></button>
</form>
<? Ajax::ModalAjaxForm("composewall".$id);?>
<? if($targetClass == 'kelaswall'){?>
<div class="row">
   <? $fotoweb = new Fotoweb(); $fotoweb->attachment($id,$targetClass);?>  
</div>
<? } ?>
<?php



