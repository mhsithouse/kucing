<style type="text/css">
    .fotoresponsive{
    	height:168px;     
        overflow:hidden;
        //padding: 10px;
        //background-color: white;
    }
</style>
<div class="col-md-<?=$nrRow;?> col-lg-<?=$nrRow;?> col-sm-4 col-xs-6" onclick="openProfile('<?=$murid->admin_id;?>');">
    
    <? Account::makeFotoIterator($murid->admin_foto, "responsive");?>
    <div style="text-align: center; margin-bottom: 15px; margin-top: 5px; font-weight: bold;">
    <?=getNamaPendek($murid->getName());?>
    </div>
</div>
<?php



