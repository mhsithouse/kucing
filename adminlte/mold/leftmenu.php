<?

$leap = new Leap();
$arrTabs =$leap->loadedDomains4Role[Account::getMyRole()];
$arrDomain = $leap->domains;

?>


<ul class="sidebar-menu" style="cursor: pointer;">
    
    <li>
        <a onclick="openLw('Home','<?=_SPPATH;?>homeLoad','fade');">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <? foreach($arrTabs as $tabs){?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span><?=Lang::t($tabs);?></span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <? $tt = $arrDomain[$tabs]; foreach($tt as $id=>$tabclick){?>
            <li id="TabInside_<?=$id;?>"><a ><i class="fa fa-angle-double-right"></i>  <?=Lang::t($id);?></a></li>
            <script type="text/javascript">
            $("#TabInside_<?=$id;?>").click(function(){
                openLw('<?=$id;?>','<?=_SPPATH;?><?=$tabclick;?>','fade');
            });
            </script>
            <? } ?>           
        </ul>
    </li>
    <? } ?>  
    
        
   
</ul>

<div class="row" style="margin-top:10px;">
    
<div class="col-md-12 col-md-offset-0">
    <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">A.Y</div>
      <? Selection::tahunAjaranSelector(TahunAjaran::ta());?>
    </div>
    <div class="input-group">
      <div class="input-group-addon">L</div>
      <? Selection::languageSelector(Lang::getLang());?>
    </div>
  </div> 
</div>    
</div> 
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

