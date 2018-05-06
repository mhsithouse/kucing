<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Topicmapweb
 *
 * @author User
 */
class Topicmapweb extends WebApps {
    //put your code here
     public function newtopic(){
        echo "in";
        $tm = new Topicmap();
         
        $mpid = addslashes($_GET['mp']);
        $klsid = addslashes($_GET['kls']);
        
        global $db;
        
        $c__Kelas = new Kelas();        
        $c__Dataguru = new Guru();
        $c__Matapelajaran = new Matapelajaran();
        

        $q = "SELECT * FROM {$c__Kelas->table_name} WHERE kelas_id = '$klsid'";
        $kelasku = $db->query($q,1);
        $q = "SELECT * FROM {$c__Matapelajaran->table_name} WHERE mp_id = '$mpid'";
        $mpku = $db->query($q,1);
        $tmid = addslashes($_GET['tmid']);
        
        if($_GET['load']){
            if($tmid == "")die(Lang::t('lang_failed'));
            $q = "SELECT * FROM {$tm->table_name} WHERE topicmap_id = '$tmid'";
            $tm_data = $db->query($q,1);
            
            $q = "SELECT * FROM ry_topicmap__element WHERE tme_tm_id = '$tmid' ORDER BY tme_urutan ASC";
            $tm_els = $db->query($q,2);
            
            $q = "SELECT * FROM ry_topicmap__link WHERE tml_tm_id = '$tmid'";
            $tm_ccs = $db->query($q,2);
            
            $q = "SELECT * FROM ry_topicmap__occ WHERE tmo_tm_id = '$tmid'";
            $tm_occs = $db->query($q,2);
        }
        //pr($tm_els);
        //cari id terbesar
        $dimensions_rect = array(40,60,85,100,120,150,180,200,250,300);
        $dimensions_circle = array(20,30,45,55,60,75,90,100,125,150);

        $terbesar = 0;
        foreach ($tm_els as $num=>$el){
           list($tm,$idgd) = explode("_",$el->tme_raphael_id);
           if($idgd>$terbesar)$terbesar = $idgd;
           
           if($el->tme_shape_type == "rect"){
               foreach($dimensions_rect as $num2=>$r){
                    if($el->tme_width == $r){
                        $dim[$el->tme_raphael_id] = $num2;
                    }
               }
           }
           if($el->tme_shape_type == "circle"){
               foreach($dimensions_circle as $num2=>$r){
                    if($el->tme_radius == $r){
                        $dim[$el->tme_raphael_id] = $num2;
                    }
               }
           }
           
        }
        $terbesar++;
        
        
         ?>

<script type="text/javascript"> 
var el;
var r;
var saved = 0;
window.onload = function () {

    var callback = $('holder').setStyle({height: '100%',width : '100%'});
    var callback2 = $('overlaybox').setStyle({height: screen.height+'px'});
    $('sortable_slide').setStyle({height: (screen.height-40)+'px'});
    $('select-info').setStyle({height: (screen.height-40)+'px'});

    
    $('textareades').setStyle({height: (screen.height-40)+'px',width: (screen.width-290)+'px'});

        
        r = Raphael("holder");
       // var t = r.text(200, 100, "wow1");
        $('cc_stroke_color').value(default_cc_color);
        $('cc_stroke_width').value(default_stroke_width);
        $('tm_bg_color').value(default_fill_color);
        $('dimension_width').value(default_size);
        $('cc_stroke_color').value(default_cc_color);
        $('font_color_input').value(default_fontcolor);
        $('font_size_input').value(default_fontsize);
        
        
        
       // $('change_body_bg').value('<?=_SPPATH;?>images/tmbgwood.jpg');
        
        <?if($_GET['load']){?>
            saved = 1;
            $('cc_stroke_color').value("<?=$tm_data->tm_cc_stroke;?>");
            $('cc_stroke_width').value("<?=$tm_data->tm_cc_stroke_width;?>");
            $('change_body_bg').value("<?=$tm_data->tm_bg_url;?>");
            $('namatm').value("<?=$tm_data->tm_name;?>");
            default_cc_color = "<?=$tm_data->tm_cc_stroke;?>";
            default_stroke_width =<?=$tm_data->tm_cc_stroke_width;?>;
             
          <? if($tm_data->tm_bg_url != ""){?> eventFire(document.querySelector('#change_body_bg_button'),'click'); <? } ?>
            
            //load objects
            <?foreach ($tm_els as $el){ 
                //$el->tme_text = trim(preg_replace('/\s+/', '\n', trim(rtrim($el->tme_text))));
               // $el->tme_text = str_replace("<br />", "\n", $el->tme_text);
               // $el->tme_text = $this->br2nl2($el->tme_text);
              //  $el->tme_text = trim(preg_replace('/\s+/', '\n', trim(rtrim($el->tme_text))));
                $el->tme_text = str_replace("|||","\n",addslashes($el->tme_text));
                $el->tme_text = trim(preg_replace('/\s+/', '\n', trim(rtrim($el->tme_text))));
                $el->tme_text = str_replace("_"," ",trim(rtrim($el->tme_text)));
                if($el->tme_shape_type == "rect"){
                ?>
                tambahrect('<?=$el->tme_raphael_id;?>');        
                //eventFire(document.querySelector('#tambah_rect'),'click');
                latest_el.attr({x:<?=$el->tme_pos_x;?>,y:<?=$el->tme_pos_y;?>,width:<?=$el->tme_width;?>,height:<?=$el->tme_height;?>});
                
                
                <? }
               if($el->tme_shape_type == "circle"){?>
               // eventFire(document.querySelector('#tambah_circle'),'click'); 
               tambahcircle('<?=$el->tme_raphael_id;?>');
                latest_el.attr({cx:<?=$el->tme_pos_x;?>,cy:<?=$el->tme_pos_y;?>,r:<?=$el->tme_radius;?>});
                
            <? } ?>
                latest_el.id = '<?=$el->tme_raphael_id;?>';
                latest_el.attr({fill:'<?=str_replace("kres__", "#", $el->tme_fill_url);?>',stroke:'<?=str_replace("kres__", "#", $el->tme_stroke);?>',"stroke-width":<?=$el->tme_stroke_width;?>});
                latest_el.data("oldstroke","<?=str_replace("kres__", "#", $el->tme_stroke);?>");
                latest_el.data("url","<?=str_replace("kres__", "#", str_replace("url(", "",str_replace(")", "",$el->tme_fill_url)));?>");
                latest_el.data("oldstrokewit", <?=$el->tme_stroke_width;?>);
                latest_el.data("dim", <?=$dim[$el->tme_raphael_id];?>);
                //latest_el.data("desc",addslashes('<? //addslashes($el->tme_des);?>'));
                <? if($el->tme_text!= ""){ ?>
                createTextElement(latest_el,'<?=$el->tme_text;?>',<?=$el->tme_fontsize;?>,'<?=str_replace("kres__", "#", $el->tme_fontcolor);?>');
                //var t = r.text(100,100, 'halo');
                <? }//text ?>
            <?   } ?>    
            <? foreach ($tm_ccs as $num=>$cc){ list($tm1,$tm2) = explode("___",$cc->tml_cons_id);?>
            var con_<?=$num;?> = r.connection(r.getById('<?=$tm1;?>'), r.getById('<?=$tm2;?>'), default_cc_color);
            r_connections.push(con_<?=$num;?>);
            r_connections_a_b.push('<?=$cc->tml_cons_id;?>');
            <? } ?>  
            ralp_register_id_asli.length = 0;
            for (i=0 ; i<ralp_register_id.length ; i++) {
              ralp_register_id_asli.push(ralp_register_id[i].id);
            }
            var objocc;
            <? foreach($tm_occs as $oc){ ?>
                 objocc = {oic:<?=$oc->tmo_oic;?>, id : '<?=$oc->tmo_tme_raphael_id;?>', name :'<?=$oc->tmo_name;?>' ,type :'<?=$oc->tmo_type;?>',url :'<?=$oc->tmo_url;?>',desc :'<?=$oc->tmo_descr;?>'};
                 arr_occ.push(objocc);
                 id_occ++;
            <? } ?>
            jumlahel = <?=$terbesar;?>;
        <? } ?>   
            panZoom = r.panzoom({ minZoom :1, maxZoom:19 ,initialZoom: 10, initialPosition: { x: 0, y: 0} });
            panZoom.enable();
   
    
};
var sortie;
</script>
<style type="text/css" media="screen">
    body
    { 
        width:100%; height:100%;
   // background-image:url('<?=_SPPATH;?>images/tmbgwood.jpg');
   // background-repeat:repeat-xy;
    /*background-attachment:fixed;*/
   // background-position:center; 
    }
    .centercontent{ background-color: #bbbbbb;}
            #holder {
               /* -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border: solid 1px #333;
                
                background-color: #bbbbbb;*/
            }
            p {
                text-align: center;
            }
            div.rui-slider{width:100px;}
            .tmbutton{ float:left; margin-left:4px; margin-right:4px;cursor:pointer; width:32px; line-height:32px; text-align:center; height:32px; }
            
            .tmbuttontext{ float:left; margin-left:4px; margin-right:4px;  width:64px; line-height:32px; text-align:center; height:32px; }
            
            .clear{clear:both;height:1px;}
            .tminput{ height:32px; line-height:32px;float:left;margin-left:4px }
            .pembatas{ float:left; 
            width:40px; height:40px; margin-top:-4px;
            }
            .tminputtext{ margin-left:4px; margin-right:4px;}
            .infocontainer{ clear:both;}
            .buttonimage{ float:left; margin:10px;}
         
.overlay {
    width:100%;
    height:100%;
    position:absolute;
    background-color:#000;
    opacity:0.3;
    z-index:0;
    
}

.nonaktiv{ opacity:0.1; cursor:auto;}
#save_button,#view_button,#tambah_rect,#tambah_circle,.butonaktiv{ opacity:0.6; cursor:pointer;}
#save_button:hover,#view_button:hover,#tambah_rect:hover,#tambah_circle:hover,.butonaktiv:hover{ opacity:1;}
        </style>
 <div id="overlaybox">  </div><!-- end overlay-->      <? //rel="draggable" data-draggable="{revert: false}" ?>
         <div  id="toolbox_umum" style="width:100%; padding-top: 4px; padding-bottom: 4px; top:0px; left:0px; height: 32px; position: fixed; background-color: #dedede;z-index:100;">
             <div id="tambah_rect" class="tmbutton" title="tambah rect"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_square");?>"></div>  
            <div id="tambah_circle" class="tmbutton" title="tambah rect" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_circle");?>"></div> 
            <div id="rem_selected_obj" class="tmbutton nonaktiv" onclick="rem_rel();" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_delete");?>"></div>
            
            <div class="pembatas"><img src="<?=_SPPATH;?><?=Lang::t("topicmap_pembatas");?>"></div>
            <div id="link_selected_obj" class="tmbutton nonaktiv" onclick="rconnect();" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_link");?>"></div> 
             <div id="rem_link_selected_obj" class="tmbutton nonaktiv" onclick="rem_rconnect();" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_linkdel");?>"></div> 
              <div class="tminput">
                  <input type="color" class="tminputtext"  id="cc_stroke_color" value="#ff0000" name="cc_stroke_color" >
             
             <input type="number" value="2" class="tminputtext" style="width:32px;"  id="cc_stroke_width" name="cc_stroke_width" min="1" max="10" >
             <input style="display:none;" type="button" id="change_cc_stroke_button" value="U Stroke" >
            <input style="display:none;" type="button" id="change_cc_strokewitdh_button" value="U Stroke width">
             </div>
             <div class="pembatas"><img src="<?=_SPPATH;?><?=Lang::t("topicmap_pembatas");?>"></div>
             
            
             
             <div class="tminput">
            <div class="tmbuttontext"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_bg_url");?>"></div> 
            <input type="text" class="tminputtext" style="width:50px;" value=""  id="change_body_bg" name="change_bg" >
            <input type="button" style="display:none;" id="change_body_bg_button" value="Change BG">            
            </div>
             
             <div class="pembatas"><img src="<?=_SPPATH;?><?=Lang::t("topicmap_pembatas");?>"></div>
             
              <div class="tmbuttontext"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_name");?>"></div> 
             <div class="tminput">
                 <input class="tminputtext" type="text" id="namatm" style="width:50px;">
             </div>
              <div class="tmbuttontext" id="save_button" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_save");?>"></div> 
              <div class="tmbuttontext" id="view_button" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_view");?>"></div> 
              <div class="tmbuttontext" id="urutan_button" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_view");?>"></div> 
              
              <!--
             <div class="tminput" style="width:120px;">
            <div id="my-element" style="width:80px; margin-left: 10px; margin-top: 5px; "></div>
            <input type="hidden" id="my-input">
            </div>
             -->
             
             <div class="tminput" style="display:none;">
             <div id="posisi"></div>
             <div id="isiarr2"> </div>
             <div id="isiarr"> </div> 
             </div>
         </div>
       
           
        <!--
            <a  onclick="addoralp(event);">+R</a> &nbsp;
        
        
            <div id="tambah_star" >+starR2</div> &nbsp;
            <a onclick="rconnect();">Link Rs</a> &nbsp;
            <a onclick="rem_rconnect();">Del Links</a> &nbsp;
            <a onclick="rem_rel();">Del R</a> &nbsp;
            <div id="zoom_in_rect" >zoom+</div> &nbsp;
            <div id="zoom_out_rect" >zoom-</div> &nbsp;-->
        
        
       
        
            
            
        
        <div id="select-info" style="display: none; padding: 20px; background-color: #efefef; width:200px; right: 0px; top:40px;position: fixed;z-index: 100;" >
            
            <div class="infocontainer">
             <div class="tmbuttontext"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_size");?>"></div> 
             <input type="number" class="tminputtext" id="dimension_width" name="dimension_width" min="0" max="9" >
            <input type="button" style="display:none;" id="dimension_width_button" value="Change Dim">
            </div>
            
            <div class="infocontainer">
             <div class="tmbuttontext"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_bg_color");?>"></div> 
             <input class="tminputtext" type="color"  id="tm_bg_color" name="tm_bg_color" >
             
            </div>
            
            <div class="infocontainer">
             <div class="tmbuttontext"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_outline");?>"></div> 
             <input type="number" class="tminputtext"  id="stroke_width" name="stroke_width" min="1" max="10" >
             <input style="display:none;" type="button" id="change_strokewitdh_button" value="Change Stroke width">
             <input class="tminputtext" type="color"  id="stroke_color" name="stroke_color" >
            <input style="display:none;" type="button" id="change_stroke_button" value="Change Stroke">
            
            </div>
            
            <div class="infocontainer">
             <div id="textdiv" style="display:none; position: absolute; z-index: 1011; margin-left: -230px; width: 200px; background-color: #efefef; padding: 10px;">
                 <textarea style="width:180px;" id="change_text" name="change_text"></textarea>
                  <input type="color" class="tminputtext"  id="font_color_input" value="#ff0000" name="font_color_input" >             
                  <input type="number" value="15" class="tminputtext" style="width:32px;"  id="font_size_input" name="font_size_input" min="5" max="50" >             
                 <input style="display:none;" type="button" id="change_text_button" value="Change TEX">            
             </div>   
                <div class="buttonimage butonaktiv" id="textbutton" onclick="$('textdiv').fade();"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_text");?>"></div>
                
            
             <div class="buttonimage butonaktiv" id="add_occ_descr_new" ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_desc");?>"></div> 
         <!--     <div class="buttonimage butonaktiv"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_linkurl");?>"></div> 
               <div class="buttonimage butonaktiv"  ><img src="<?=_SPPATH;?><?=Lang::t("topicmap_create");?>"></div> -->
            </div>
            
            
            <div id="textareades" style=" padding: 10px; background-color: #efefef; z-index:10000000; width: 500px; height: 500px; position: absolute; right: 230px; top: 0px; display: none;">
                <textarea id="rte_des"  name="editor1">sssss</textarea>                
            </div>
            
            
            <div style="display:none;">
            BG URL : <input type="text" value="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoX4VTR25ACLBrTGZmnh9gQGa1KK-AJfjVxMgARjlRTLa9miOzoy3jYQ"  id="change_bg" name="change_bg" >
            <input type="button" id="change_bg_button" value="Change BG">
           
            
             
            
            
            <hr>
            Occurence
            <div id="add_occ_descr">add description</div>
            <div id="add_occ_link">add Outside Link ( Wiki, Video, Audio, Games )</div>
            <div id="add_quiz">add Quiz / Test / Description / materi</div>
            <div id='occ_holder'>
                
            </div>
             </div>
        </div>
        
<div id="sortable_slide" style=" z-index: 1000; display:none; top:40px;  height: 500px; overflow: auto; position: absolute;  left: 0px; width: 200px; padding: 10px; background-color: #efefef;" ></div>
            
        <div id="holder" style="overflow: auto;position: absolute; top:34px; left: 0;z-index: 1;"></div>
        
<!--<svg>
<rect rel="draggable" data-draggable="{revert: false}" height="100" width="100"
          style="stroke:#006600; fill: #00cc00" />
</svg>-->
        <script type="text/javascript">
           
                        
            $('add_occ_link').onClick(function(){
                var d =new Dialog().title('<?=Lang::t('lang_tambah_occ');?>').load('<?=_SPPATH;?>topicmap/occ_link').show().onOk(function(){
                    var obj = {oic:id_occ, id : selected_el.id, name :$('occ_name').value() ,type :$('occ_type').value(),url :$('occ_url').value(),desc :$('occ_desc').value()};
                    console.log(obj);
                    arr_occ.push(obj);
                    id_occ++;
                    d.hide();
                    $('oktop').fade().fade();
                    updateocc(selected_el.id);
                    
                    //alert($('occ_name').value());
                });
            });
            $('add_occ_descr_new').onClick(function(){
                 var t =  new Date().getTime();
                 var params = [
    'height='+screen.height,
    'width='+screen.width,
    'fullscreen=yes' 
    ].join(',');
                if(saved)window.open("<?=_SPPATH;?>topicmap/occurence?rid="+selected_el.id+"&load=1&tmid=<?=$tmid;?>&aj=1&mp=<?=$mpid;?>&kls=<?=$klsid;?>&t="+t,"_blank","directories=0,titlebar=0,toolbar=0,location=0, scrollbars=yes, resizable=no,"+params);
                else alert('Please Save Your Topic Map First');
                   return false;                               
            });
            $('add_occ_descr').onClick(function(){
                var tex = '';var oldd = '';
                if(selected_el.data('tex') !== undefined) tex = selected_el.data('tex');
                if(selected_el.data('desc') !== undefined) oldd = selected_el.data('desc');
                var d =new Dialog().title(tex+' : <?=Lang::t('lang_desc_occ');?>').html('<textarea style="width:300px;height:200px;" id="el_desc">'+oldd+'</textarea>').show().onLoad(function(){
                    $('el_desc').getRich();
                }).onOk(function(){
                    selected_el.data('desc',$('el_desc').value());
                    d.hide();
                    $('oktop').fade().fade();
                    
                });
            });
            $('change_body_bg_button').onClick(function(){
                
                var slc = $('change_body_bg').value();
                if(slc == "")return false;
                var body = document.getElementsByTagName('body')[0];
                body.style.backgroundImage = 'url('+slc+')';
            });
            $('change_body_bg').onBlur(function(){
                
                var slc = $('change_body_bg').value();
                if(slc == "")return false;
                if(!checkURL(slc)){alert('<?=Lang::t('lang_is_not_image');?>');return false;}
                var body = document.getElementsByTagName('body')[0];
                body.style.backgroundImage = 'url('+slc+')';
            });
            $('dimension_width_button').onClick(function(){
                var slc = $('dimension_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                if(selected_el.data("dim")=== undefined)return false;
                var dim =  selected_el.data("dim");
                if(selected_el.type == "circle"){
                    selected_el.attr({r: dimensions_circle[slc]});                   
                }
                if(selected_el.type == "rect"){
                    selected_el.attr({width: dimensions_rect[slc],height: dimensions_rect[slc]});                   
                }               
                selected_el.data("dim", slc);
            });
            $('dimension_width').onChange(function(){
                var slc = $('dimension_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                if(selected_el.data("dim")=== undefined)return false;
                var dim =  selected_el.data("dim");
                if(selected_el.type == "circle"){
                    selected_el.attr({r: dimensions_circle[slc]});                   
                }
                if(selected_el.type == "rect"){
                    selected_el.attr({width: dimensions_rect[slc],height: dimensions_rect[slc]});                   
                }               
                selected_el.data("dim", slc);
            });
            
            $('change_stroke_button').onClick(function(){
                var slc = $('stroke_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({stroke: slc});
                selected_el.data("oldstroke", slc);
            });
            $('stroke_color').onChange(function(){
                var slc = $('stroke_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({stroke: slc});
                selected_el.data("oldstroke", slc);
            });
            
            $('change_strokewitdh_button').onClick(function(){
                var slc = $('stroke_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({"stroke-width": slc});
                selected_el.data("oldstrokewit", slc);
            });
            $('stroke_width').onChange(function(){
                var slc = $('stroke_width').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({"stroke-width": slc});
                selected_el.data("oldstrokewit", slc);
            });
            
            $('change_cc_stroke_button').onClick(function(){
                var slc = $('cc_stroke_color').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({stroke: slc});
                    //r.connection(r_connections[i]);
                }
                default_cc_color = slc;
            });
            $('cc_stroke_color').onChange(function(){
                var slc = $('cc_stroke_color').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({stroke: slc});
                    //r.connection(r_connections[i]);
                }
                default_cc_color = slc;
            });
            $('cc_stroke_width').onChange(function(){
                var slc = $('cc_stroke_width').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({"stroke-width": slc});
                }
                default_stroke_width = slc;
            });
            $('change_cc_strokewitdh_button').onClick(function(){
                var slc = $('cc_stroke_width').value();
                if(slc == "")return false;
                for (var i = r_connections.length; i--;) {
                    r_connections[i].line.attr({"stroke-width": slc});
                }
                default_stroke_width = slc;
            });
            $('change_bg_button').onClick(function(){
                var slc = $('change_bg').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                selected_el.attr({fill: "url("+slc+")"});
                selected_el.data("url", slc);
            });
            
            $('tm_bg_color').onChange(function(){
                var slc = $('tm_bg_color').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                selected_el.attr({fill: slc});
                selected_el.data("oldbg", slc);
            });
             $('font_color_input').onChange(function(){
                var slc = $('font_color_input').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                 if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){     
                        selected_el.data("texobj").attr({fill: slc});                 
                    }
                }
            });
            $('font_size_input').onChange(function(){
                var slc = $('font_size_input').value();
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                if(selected_el === undefined)return false;
                 if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){     
                        selected_el.data("texobj").attr({"font-size": slc});                 
                    }
                }
            });
            $('change_text').onBlur(function(){
                var slc = $('change_text').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                
                if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){
                        
                    
                        console.log(selected_el.data("texobj"));
                        selected_el.data("texobj").remove();                   
                    }
                }
                
                selected_el.data("tex", slc);
                var bb1 = selected_el.getBBox();
                /*
                var postex_x = selected_el.ox+Math.abs(bb1.width/2);
                var postex_y =  selected_el.oy+bb1.height+20;
                if(selected_el.type == "circle") {
                var postex_x = selected_el.ox;font_size_inputfont_size_inputfont_size_input
                var postex_y =  selected_el.oy+Math.abs(selected_el.attr("r")+15);
                } */
                
                var postex_x = bb1.x + Math.abs(bb1.width/2);
                var postex_y = bb1.y + Math.abs(bb1.height/2);
                
                var t = r.text(postex_x,postex_y, slc);
               
                var sizetext = 20;
                
                t.id = "tex_"+selected_el.id;
              //  t.ox = t.ox-Math.abs(bb2.width/2);
                t.attr({"font-size": sizetext,fill: $('font_color_input').value(),"font-size": $('font_size_input').value()});
                selected_el.data("texobj", t);
                 var bb2 =t.getBBox();
                 if(bb2.width >= (bb1.width-5))
                 while(bb2.width >= (bb1.width-5)){                     
                     sizetext--;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();                     
                 }
                 else 
                     while(bb2.width < (bb1.width-15)){
                         if(sizetext>50)break;
                     sizetext++;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
             $('font_size_input').value(sizetext);
                 t.mouseover(hideText);
                console.log(bb2);
                updateSlide(); 
            });
            $('change_text_button').onClick(function(){
                var slc = $('change_text').value();
                //alert(slc);
               // alert(selected_el.constructor.name);
                if(selected_el.id == "")return false;
                if(slc == "")return false;
                //alert(slc);
                
                if(selected_el.data("tex")!="no"){
                    if(selected_el !== undefined && selected_el.data("tex") !== undefined){
                        
                    
                        console.log(selected_el.data("texobj"));
                        selected_el.data("texobj").remove();                   
                    }
                }
                
                selected_el.data("tex", slc);
                var bb1 = selected_el.getBBox();
                /*
                var postex_x = selected_el.ox+Math.abs(bb1.width/2);
                var postex_y =  selected_el.oy+bb1.height+20;
                if(selected_el.type == "circle") {
                var postex_x = selected_el.ox;
                var postex_y =  selected_el.oy+Math.abs(selected_el.attr("r")+15);
                } */
                
                var postex_x = bb1.x + Math.abs(bb1.width/2);
                var postex_y = bb1.y + Math.abs(bb1.height/2);
                
                var t = r.text(postex_x,postex_y, slc);
               
                var sizetext = 20;
                
                t.id = "tex_"+selected_el.id;
              //  t.ox = t.ox-Math.abs(bb2.width/2);
                t.attr({"font-size": sizetext});
                selected_el.data("texobj", t);
                 var bb2 =t.getBBox();
                 if(bb2.width >= (bb1.width-5))
                 while(bb2.width >= (bb1.width-5)){                     
                     sizetext--;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
                 else 
                     while(bb2.width < (bb1.width-5)){
                         if(sizetext>50)break;
                     sizetext++;
                     t.attr({"font-size": sizetext});
                     bb2 =t.getBBox();
                 }
                 t.mouseover(hideText);
                console.log(bb2);
                
            });
      
           
           

    
            $('tambah_rect').onClick(function(event){
            var c;
           // var x=event.screenX;
	   // var y=event.screenY;
            var mouseX = event.pageX; 
            var mouseY = event.pageY;
            //alert('in'+mouseX);
            mouseX += 100;
            mouseY += 100;
            craphael = r.rect(mouseX, mouseY, dimensions_rect[default_size], dimensions_rect[default_size], 10);
            c = craphael;
            c.attr({fill: default_fill_color, stroke: default_stroke_color,"fill-opacity": 1, "stroke-width": default_stroke_width, cursor: "move"});
            c.id = "tm_"+jumlahel;c.data("tex","no");
            
            c.data("urutan",getUrutan());
            c.data("dim", 2);
            jumlahel++;
            latest_el = c;
            ralp_register_id.push(c);
            ralp_register_id_asli.push(c.id);
            c.drag(r_move,r_dragger,r_up);
            c.dblclick(el_dbl_click);
            c.mouseover(lessOpacity);
            c.mouseout(showText);
            updateSlide(); 
        });
        
        $('tambah_circle').onClick(function(event){
            var c;
           // var x=event.screenX;
	   // var y=event.screenY;
            var mouseX = event.pageX; 
            var mouseY = event.pageY;
            //alert('in'+mouseX);
            mouseX += 100;
            mouseY += 100;
            craphael = r.circle(mouseX, mouseY, dimensions_circle[default_size]);
            c = craphael;
            c.attr({fill: default_fill_color, stroke: default_stroke_color,"fill-opacity": 1, "stroke-width": default_stroke_width, cursor: "move"});
            c.id = "tm_"+jumlahel;c.data("tex","no");
            
            c.data("urutan",getUrutan());
            c.data("dim", 2);
            jumlahel++;
            latest_el = c;
            ralp_register_id.push(c);
            ralp_register_id_asli.push(c.id);
            c.drag(r_move,r_dragger,r_up);
            c.dblclick(el_dbl_click);
            c.mouseover(lessOpacity);
            c.mouseout(showText);
             updateSlide();
        });
        $('urutan_button').onClick(function(){
            $('sortable_slide').slide({direction: 'left'});
        });
       $('view_button').onClick(function(){
         var t =  new Date().getTime();
             var params = [
    'height='+screen.height,
    'width='+screen.width,
    'fullscreen=yes' 
    ].join(',');
       if(saved)window.open("<?=_SPPATH;?>topicmap/present?load=1&tmid=<?=$tmid;?>&aj=1&mp=<?=$mpid;?>&kls=<?=$klsid;?>&t="+t,"_blank","directories=0,titlebar=0,toolbar=0,location=0, scrollbars=yes, resizable=yes,"+params);
       else alert('Please Save Your Topic Map First');
       return false; 
       
        });
        $('save_button').onClick(function(){
            var slc = $('namatm').value();
            if(slc == ""){alert('Please Insert A Topic Map Name'); return 0;}
            if(mau_di_link_id_asli.length>0){ alert('<?=Lang::t('lang_masi_diselect');?>');updatecolor();return 0;}
            /*
            var ralp_register_id = new Array();
            var ralp_register_id_asli = new Array();
            var mau_di_link_id = new Array();
            var mau_di_link_id_asli = new Array();
            var r_connections = new Array();
            var r_connections_a_b = new Array();
            var craphael;
            var jumlahel = 0;
            var selected_el;
            */
           var jsonMetas = [];
           for (i=0 ; i<ralp_register_id.length ; i++) {
            var thisMeta = { };
            var obval = { };
            //var  f = "#f00000"; 
            
            //console.log("id "+i);
            //console.log(ralp_register_id[i].attr("fill"));
            //if(ralp_register_id[i].attr("fill")!== undefined && ralp_register_id[i].attr("fill") != null )
            //f = ralp_register_id[i].attr("fill");
            //var res = f.replace("#","kres__");
            //thisMeta['id'+ralp_register_id[i].id] =  ralp_register_id[i].id;
            //obval.id =  ralp_register_id[i].id;
            var tex = "";var desc = ""; var fontsize = "";var fontcolor = "";
            if(ralp_register_id[i].data("tex")!="no"){
                if(ralp_register_id[i].data("texobj") !== undefined && ralp_register_id[i].data("tex") !== undefined){
                    tex = ralp_register_id[i].data("tex"); 
                    fontsize = ralp_register_id[i].data("texobj").attr("font-size");
                    fontcolor = ralp_register_id[i].data("texobj").attr("fill").replace("#","kres__");
                }                  
            }
            if(ralp_register_id[i].data("desc") !== undefined){
                    desc = ralp_register_id[i].data("desc");                 
                }     
           
            var k= {
              tmid: ralp_register_id[i].id,
              
              fill: ralp_register_id[i].attr("fill").replace("#","kres__"),
              stroke: ralp_register_id[i].attr("stroke").replace("#","kres__"),
              strokewidth: ralp_register_id[i].attr("stroke-width"),
              typr: ralp_register_id[i].type,
              
              data: {
                in_reply_to_screen_name: 'other_user',
                urutan: i,
                text: tex,
                fontsize: fontsize,
                fontcolor: fontcolor,
                description : desc
              }
            };
          
            if(ralp_register_id[i].type == "circle"){
                k.data.x = ralp_register_id[i].attr("cx");
                k.data.y = ralp_register_id[i].attr("cy");
                k.data.radius = ralp_register_id[i].attr("r");
            }
            if(ralp_register_id[i].type == "rect"){
                k.data.x = ralp_register_id[i].attr("x");
                k.data.y = ralp_register_id[i].attr("y");
                k.data.wit = ralp_register_id[i].attr("width");
                k.data.heit = ralp_register_id[i].attr("height");
            }
            //obval.fill = ralp_register_id[i].attr("fill");
           // thisMeta['id'+ralp_register_id[i].id] = new_tweets;
            jsonMetas.push(k);
            }
/*arr_occ
           var ralp_register_id_save = new Array();
            var ro_akandisave = { };
            var obval = { };
            for (var i = ralp_register_id.length; i--;) {
               // var theid = ralp_register_id[i].id;
                
                obval.ralp = { }; 
                obval.ralp.id = ralp_register_id[i].id;
                obval.ralp.fill = ralp_register_id[i].attr("fill");
                ro_akandisave[i] = obval;
                //ralp_register_id_save.push(ro_akandisave);
               //ralp_register_id[i].line.attr({"stroke-width": slc});
            }*/
            var json = JSON.stringify(jsonMetas);
            /*
            var xhr = new Xhr("<?=_SPPATH;?>topicmap/saveTM?tmid=<?=$tmid;?>&klsid=<?=$klsid;?>&mpid=<?=$mpid;?>&name="+slc, {
            params: {myelement: json}
            });

            xhr.send();
            */
        /*for (i=0 ; i<r_connections_a_b.length ; i++) {
                    
        }*/
        var jsonc = JSON.stringify(r_connections_a_b);
        var cc_s = $('cc_stroke_color').value();
        var cc_sw = $('cc_stroke_width').value();
        var bodbg = $('change_body_bg').value();
        var occs = JSON.stringify(arr_occ);
        Xhr.load("<?=_SPPATH;?>topicmap/saveTM?tmid=<?=$tmid;?>&klsid=<?=$klsid;?>&mpid=<?=$mpid;?>&name="+slc,{
        params: {myelement: json, bodybg :bodbg, cc_st : cc_s , cc_stw : cc_sw,cons : jsonc, occ : occs },
        method : 'post',
        onSuccess : function(e){
                   var hasil = e.responseText;
                   alert(hasil);
                   //var hasil = JSON.parse(json);
                   saved = 1;
                }
            });
            
        });
            </script>
            <?
       
        
    }
}
