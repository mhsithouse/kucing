<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of MatapelajaranController
 *
 * @author User
 */
class Matapelajaran extends Model {
    //my table name
    var $table_name = "ry_sekolah__matapelajaran";
    var $main_id ="mp_id";
    
    var $default_read_coloms = "mp_id,mp_name,mp_singkatan,mp_group";
    
    var $coloumlist= "mp_name,mp_singkatan,mp_group,mp_foto,mp_ket,mp_aktiv,mp_color";
    
    // isi database
    var $mp_id;
    var $mp_singkatan;
    var $mp_group;
    var $mp_foto;
    var $mp_ket;
    var $mp_aktiv;
    var $mp_name;
    var $mp_color;
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            //kalau ada yang tidak mau tampilkan bisa dengan type hidden
            $return['mp_group'] = new Leap\View\InputSelect(array('Group A'=>'Group A','Group B'=>'Group B'),"mp_group", "mp_group",$this->mp_group);
           
            $return['mp_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"mp_aktiv", "mp_aktiv",$this->mp_aktiv);
            $return['mp_color'] = new Leap\View\InputText("color", "mp_color", "mp_color", $this->mp_color);            
            $return['mp_ket'] = new Leap\View\InputTextArea("mp_ket", "mp_ket", $this->mp_ket);
            $return['mp_foto'] = new \Leap\View\InputFoto("mp_foto", "mp_foto", $this->mp_foto);
            return $return;
    }
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if(!isset($this->mp_name))$err['mp_name'] = Lang::t('err mp_name empty');
        if(!isset($this->mp_singkatan))$err['mp_singkatan'] = Lang::t('err mp_singkatan empty');
        if(!isset($this->mp_group))$err['mp_group'] = Lang::t('err mp_group empty');
        return $err;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(isset($obj->mp_foto)){
                $obj->mp_foto = \Leap\View\InputFoto::getAndMakeFoto($obj->mp_foto, "foto_mp_".$obj->mp_id);
            }
        }
        //pr($return);
        return $return;
    }
    
    public function getName() {
        return $this->mp_name;
    }
    
    public static function getFirstMPID(){
        global $db;
        $q = "SELECT mp_id FROM ry_sekolah__matapelajaran WHERE mp_aktiv = 1 ORDER BY mp_id ASC LIMIT 0,1";
        $mp = $db->query($q,1);
        return $mp->mp_id;
    }    
}
