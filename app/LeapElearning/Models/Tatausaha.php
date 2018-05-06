<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of Tatausaha
 * tata usaha adalah object tatausaha
 * @author User
 */
class Tatausaha extends ModelAccount {
    var $table_name = "ry_tatausaha__data";
    var $main_id = "tu_id";
    var $default_read_coloms = "tu_id,nama_depan,foto,tu_aktiv";
    
    
    var $tu_id;
    var $account_id;
    var $tu_aktiv;
    
   //allowed colom in database
    var $coloumlist = "nama_depan,foto,tu_aktiv";
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            $return['nama_belakang'] = new Leap\View\InputText("hidden", "nama_belakang", "nama_belakang", $this->nama_belakang);            
            $return['account_id'] = new Leap\View\InputText("hidden", "account_id", "account_id", $this->account_id);            
            $return['tu_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"tu_aktiv", "tu_aktiv",$this->tu_aktiv);
            $return['foto'] = new \Leap\View\InputFoto("foto", "foto", $this->foto);
            //$return['guru_color'] = new Leap\View\InputText("color", "guru_color", "guru_color", $this->guru_color); 
            return $return;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(isset($obj->foto)){
                $obj->foto = \Leap\View\InputFoto::getAndMakeFoto($obj->foto, "foto_guru_".$obj->tu_id);
            }
        }
        //pr($return);
        return $return;
    }
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if(!isset($this->nama_depan))$err['nama_depan'] = Lang::t('err nama_depan empty');
        
        return $err;
    }
}
