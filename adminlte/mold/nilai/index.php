<?
//pr($arr);
?>
<h1><?=Lang::t('Grade');?> <?=$kls->kelas_name;?> <small><?=Lang::t('Subject');?>: <?=$mp->mp_name;?></small></h1>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-3 col-xs-12">
        <? 
        //select on mon
        $urlOnChange = _SPPATH.$webClass."/".$method."?klsid=".$kls->kelas_id;
        Selection::subjectSelector($mp, $urlOnChange);        
        ?>
    </div>
    <div class="col-md-3 col-xs-12">
        <? 
        //select on kelas
        $urlOnChange = _SPPATH.$webClass."/".$method."?mp_id=".$mp->mp_id;
        Selection::kelasSelector($kls,$urlOnChange );    
        $t = time();
        ?>
    </div>
    <div class="col-md-3 col-xs-12" >
        <div class="btn-group">     
        <button class="btn btn-default" data-toggle="modal" data-target="#myModal" id="addnote_<?=$kls->kelas_id;?>_<?=$mp->mp_id;?>" type="button"><?=Lang::t('Add New Nilai Note');?></button>
        <script type="text/javascript">
            $("#addnote_<?=$kls->kelas_id;?>_<?=$mp->mp_id;?>").click(function() {
            $('#myModalLabel').empty().append('<?=Lang::t('Add New Grade Note');?>');
            $('#myModalBody').load('<?=_SPPATH;?>NilaiWeb/addNote?cmd=form&typ=kelas&mp_id=<?=$mp->mp_id;?>&kls_id=<?=$kls->kelas_id;?>');
            });
        </script>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td ><?=Lang::t('Note Name');?></td>
                <td ><?=Lang::t('Graph');?></td>
                <?
                    foreach($arrNote as $note)
                    { ?>
                        <td id="note_<?=$note->name_nilai_id;?>">
                            <span id="noteid_<?=$note->name_nilai_id;?>" style="padding: 4px;"contenteditable="true" onblur="changeNoteName('<?=$note->name_nilai_id;?>');">
                            <?=$note->name_nilai_judul;?>
                        </span>
                        <span class="glyphicon glyphicon-remove" id="icon_<?=$note->name_nilai_id;?>"  onclick="deleteNoteName('<?=$note->name_nilai_id;?>');">
                        </span> 
                            <br>     
                        <span  id="dateNote_<?=$note->name_nilai_id;?>" style="padding: 6px;" contenteditable="true" onblur="changeDateNote('<?=$note->name_nilai_id;?>');">
                         <?=date("m-d-Y",  strtotime($note->name_nilai_date));?>   
                        </span>     

                        </td> 
                   <? 
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?
            foreach($arrOfMurid as $murid){
                ?>
            <tr>
                <td style="width: 20%;"><?=$murid->getName();?></td>
                <td>
                    <span class="glyphicon glyphicon-signal" id="noteid_<?=$note->name_nilai_id;?>"  onclick="showGraph('<?=$murid->murid_id;?>', '<?=$mp->mp_id;?>', '<?=$mp->mp_id;?>', '<?=$note->name_nilai_id;?>');">
                    </span>  
                 </td>
                <?
                
                foreach($arrNote as $note){
                    //set up initial nilai value
                    $selectedNilai = "";
                    foreach($arrNilai as $nilai){
                        if($nilai->nilai_note_id ==  $note->name_nilai_id && $nilai->nilai_murid_id == $murid->murid_id){
                            $selectedNilai = $nilai;
                        }
                    }
                    ?>
                <td >
                    <span style="padding: 6px;" contenteditable="true" onblur="changeNilai('<?=$murid->murid_id;?>','<?=$note->name_nilai_id;?>','<?=$selectedNilai->nilai_id;?>');" id="editnilai_<?=$murid->murid_id;?>_<?=$note->name_nilai_id;?>">
                    <? if($selectedNilai!="")echo $selectedNilai->nilai_value; else echo '0';
                      //pr($selectedNilai);
                    ?>
                    </span>
                  
                </td>
                <?
                } ?>
            </tr>   
                 <?
            }
            ?>
        </tbody>
    </table>
</div>
<script>
function changeNilai(murid_id,note_id,nilai_id){
    var nilaibaru = parseFloat($("#editnilai_"+murid_id+"_"+note_id).html());
    //alert(parseFloat(nilaibaru));
    $.post("<?=_SPPATH;?>NilaiWeb/isiNilai",{murid_id:murid_id,note_id:note_id,nilaibaru:nilaibaru,nilai_id:nilai_id},function(data){
        if(data != "")
        alert(data);
    });
    
}
function changeNoteName(note_id){
    var notebaru = $("#noteid_"+note_id).html();
    $.post("<?=_SPPATH;?>NilaiWeb/editNote",{note_id:note_id,notebaru:notebaru},function(data){
        if(data != "")
        alert(data);
    });
}
function deleteNoteName(note_id){
   if (confirm('<?=Lang::t('Are you sure to delete?');?>')) {
        $.post("<?=_SPPATH;?>NilaiWeb/deleteNote",{note_id:note_id},function(data){
        if(data != "")
         alert(data);
        
    });
   }
 }  
 
function changeDateNote(note_id){
    var dateNoteBaru  = $("#dateNote_"+note_id).html();
    $.post("<?=_SPPATH;?>NilaiWeb/changeDateNote",{note_id:note_id,dateNoteBaru:dateNoteBaru},function(data){
        if(data != "")
        alert(data);
    });    
} 
function showGraph(murid_id, mp_id, note_id){
    openLw("GraphAnak","<?=_SPPATH;?>NilaiWeb/graph?murid_id="+murid_id+"&mp_id="+mp_id+"&note_id="+note_id,"fade");

 }

</script>

