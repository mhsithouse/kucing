<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Efindi
 *
 * @author User
 */
class Efindi extends WebService{
    
    public function printest(){
        
       $ta = TahunAjaran::ta();
      
       $admin_username = (isset($_GET['admin_username'])?addslashes($_GET['admin_username']):die('admin_username empty'));
       $admin_password = (isset($_GET['admin_password'])?addslashes($_GET['admin_password']):die('admin_password empty'));
       $admin_nama_depan = (isset($_GET['admin_nama_depan'])?addslashes($_GET['admin_nama_depan']):die('admin_nama_depan empty'));
 
       $return['admin_username'] = $admin_username;
       $return['admin_password'] = $admin_password;
       $return['admin_nama_depan'] = $admin_nama_depan;
       $return['ta'] = $ta;
        Mold::both("print/print",$return);
    }
    //public $access_nilaiku = "murid";
    public function nilaiku(){
        //header('Content-type: application/pdf');
        //die();
        //$json = array("nama"=>"efindi","id"=>10);
        
        //echo json_encode($json);
        //echo "nilai";
        //exit();
        
        //echo "<xml><pohon><daun>nilai</daun></pohon></xml>";
        
        ?>
<b onclick='$("#editnilaiku").load("<?=_SPPATH;?>Efindi/edit_nilaiku");'>edit nilai</b>    
<br>
<b onclick='$.get("<?=_SPPATH;?>Efindi/edit_nilaiku",
            function(abuii){
                var obj = jQuery.parseJSON( abuii );
                $( "#editnilaiku" ).html( obj.form );
                $( "#abuikeren" ).html( obj.murid.nama_depan );
                 $( "#namadepan" ).html( obj.murid.nama_depan );
                  $( "#namabelakang" ).html( obj.murid.alamat );
                   $( "#foto" ).html( obj.murid.foto );
                  
            });'>get edit nilai</b>   <br>
<b onclick='$.post("<?=_SPPATH;?>Efindi/edit_nilaiku");'>post edit nilai</b> 
<div id="editnilaiku">
    
</div>       
<div id='abuikeren' style="position: absolute; right: 0; width: 100px; height: 100px; top:0; background-color: red;">
    
</div>

<span id='namadepan'></span>
<span id='namabelakang'></span>
<span id='foto'></span>
        <?
    }
    public function edit_nilaiku(){
        
       $murid = new Murid();
       $murid->getByID(700);
       
       
        
      $form = '
<form>
    <input type="text" placeholder="nilai">
</form>    ';
      
      $name = "Efindi";
      $id = 10;
      
      $jsonArray = array("form"=>$form,"name"=>$name,"id"=>$id,"murid"=>$murid);
      echo json_encode($jsonArray);
            
        
    }
}
