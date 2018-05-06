
<h1><?=Lang::t('Grade');?> <?=$kls->kelas_name;?> <small><?=Lang::t('Subject');?>: <?=$mp->mp_name;?></small></h1>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-3 col-xs-12">
        <? 
        $urlOnChange = _SPPATH.$webClass."/".$method."?mp_id=".$mp->mp_id;
//        echo $urlOnChange;
        Selection::subjectSelector($mp, $urlOnChange);  
        $t = time();       
        ?>
    </div>
</div>    

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <?
                    foreach($arrNilai as $notevalue)
                    { ?>
                        <td ><?=$notevalue->name_nilai_judul;?></td>
                    <?}
                ?>
            </tr>
        </thead> 
        <tbody>
            <tr>
                <?
                 foreach($arrNilai as $notevalue)
                 {?>
                     <td ><?=$notevalue->nilai_value;?></td>
                <? }
                ?>
            </tr>
        </tbody>
    </table>
</div>

    <?
    if(count($arrNilai) != 0)
        Mold::both("nilai/graph", $arrNilai);
//    pr($arrNilai);

