<?
//pr($arr);
$id = time();
?>
<form id="addNote<?=$id;?>" role="form" class="form" role="form" method="post" action="<?=_SPPATH;?>NilaiWeb/insertNoteToDB" >  
  <div class="form-group">
    <label for="exampleInputEmail1"><?=Lang::t('Judul Note');?></label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="name_nilai_judul">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2"><?=Lang::t('Date Note');?></label>
    <input type="date" class="form-control" id="exampleInputEmail2" name="name_nilai_date">
  </div>
    <input type="hidden" name="nilai_note_kelas_id" value="<?=$kls_id;?>">
    <input type="hidden" name="nilai_note_ta" value="<?=$ta;?>">
    <input type="hidden" name="nilai_note_mp_id" value="<?=$mp_id;?>">
    <button type="submit" class="btn btn-default"><?=Lang::t('Submit');?></button>
</form>
<? Ajax::ModalAjaxForm("addNote".$id);?>

