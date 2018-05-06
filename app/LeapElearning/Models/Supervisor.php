<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of SupervisorController
 *
 * @author User
 */
class Supervisor extends ModelAccount {
    var $table_name = "ry_supervisor__data";
    var $main_id = "supervisor_id";
    var $default_read_coloms = "supervisor_aktiv,account_id,supervisor_id,nama_depan,foto";
    
    //database as variable
    var $supervisor_id;
    var $account_id;
    var $supervisor_aktiv;
    
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            $return['nama_belakang'] = new Leap\View\InputText("hidden", "nama_belakang", "nama_belakang", $this->nama_belakang);            
            $return['account_id'] = new Leap\View\InputText("hidden", "account_id", "account_id", $this->account_id);            
            $return['supervisor_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"supervisor_aktiv", "supervisor_aktiv",$this->supervisor_aktiv);
            $return['foto'] = new \Leap\View\InputFoto("foto", "foto", $this->foto);
          //  $return['guru_color'] = new Leap\View\InputText("color", "guru_color", "guru_color", $this->guru_color); 
            return $return;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(isset($obj->foto)){
                $obj->foto = \Leap\View\InputFoto::getAndMakeFoto($obj->foto, "foto_supervisor_".$obj->supervisor_id);
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
