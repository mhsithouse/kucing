<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of KelasController
 *
 * @author User
 */
class Kelas extends Model {
     //my table name
    var $table_name = "ry_sekolah__kelas";
    var $main_id ="kelas_id";
    var $default_read_coloms = "kelas_id,kelas_name";
    
    var $coloumlist= "kelas_name,kelas_tingkatan,kelas_aktiv";
    
    var $kelas_id;
    var $kelas_name;
    var $kelas_tingkatan;
    var $kelas_foto;
    var $kelas_aktiv;
    
    public function getName() {
        return $this->kelas_name;
    }
    public static function getFirstKelasID(){
        global $db;
        $q = "SELECT kelas_id FROM ry_sekolah__kelas WHERE kelas_aktiv = 1 ORDER BY kelas_id ASC LIMIT 0,1";
        $kls = $db->query($q,1);
        return $kls->kelas_id;
    }

    public static function getAktiveKlasse(){
        global $db;
        $query = "SELECT kelas_tingkatan,kelas_id, kelas_name FROM ry_sekolah__kelas WHERE kelas_aktiv= 1 ORDER BY kelas_tingkatan ASC";
        $result = $db->query($query,2);  
        foreach($result as $kls){
            $kelas[$kls->kelas_id] = $kls;
        }
        return $kelas;
    }    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            for($x=1;$x<=Schoolsetting::getTingkatanMax();$x++){
                $arr[$x] = $x;
            }
            $return['kelas_tingkatan'] = new Leap\View\InputSelect($arr,"kelas_tingkatan", "kelas_tingkatan",$this->kelas_tingkatan);
            $return['kelas_foto'] = new Leap\View\InputText("hidden", "kelas_foto", "kelas_foto", $this->kelas_foto); 
            $return['kelas_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"kelas_aktiv", "kelas_aktiv",$this->kelas_aktiv);
            return $return;
    }
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if(!isset($this->kelas_name))$err['kelas_name'] = Lang::t('err kelas_name empty');
        
        return $err;
    }
    

}
