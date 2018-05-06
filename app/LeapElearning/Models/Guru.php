<?php

/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of GuruController
 *
 * @author User
 */
class Guru extends ModelAccount {
    var $table_name = " ry_guru__data";
    var $main_id = "guru_id";
    var $default_read_coloms = "guru_id,foto,nama_depan,guru_color,guru_aktiv";
    //connected table name, name can be changed, not connected to other
    var $linked_table_name = "sp_admin_account"; 
    
    var $guru_id,
    $foto,
    $nama_depan,
    $nama_belakang,
    $account_id,
    $createdate,
    $guru_aktiv,
    $guru_color;
    
    var $_homeroom  = array();
    var $_mengajar = array();
    var $_mengajarMP = array();
    //allowed colom in database
    var $coloumlist = "nama_depan,guru_color,guru_aktiv,foto";
    
    var $table_mengajar = "ry_guru__mengajar";
    var $table_homeroom = "ry_guru__homeroom";
    
    function __construct() {
        $this->account_id = Account::getMyID();
        $this->guru_id = $this->getObjectProperty($this->account_id, 'guru_id');
        $this->foto = $this->getObjectProperty($this->account_id, 'foto');
        $this->nama_depan = $this->getObjectProperty($this->account_id, 'nama_depan');
        $this->nama_belakang = $this->getObjectProperty($this->account_id, 'nama_belakang');
        $this->createdate = $this->getObjectProperty($this->account_id, 'createdate');
        $this->guru_aktiv = $this->getObjectProperty($this->account_id, 'guru_aktiv');
        $this->guru_color = $this->getObjectProperty($this->account_id, 'guru_color');
        $this->_homeroom = $this->getHomeroom($this->guru_id);        
        $this->_mengajar = $this->getMPIDbyGuruID($this->guru_id);
        $this->_mengajarMP = $this->getMPNamebyGuruID($this->guru_id);
    }
    
    private function getObjectProperty($account_id, $property){
        global $db;
        $q = "SELECT {$property} FROM {$this->table_name} WHERE account_id= $this->account_id";
        return $db->query($q,1)->$property;
        
    }
    
    private function getHomeroom($guru_id){
       global $db;
       $arrHomeroom = array();
       $q = "SELECT hr_ta_id, hr_kelas_id FROM {$this->table_homeroom} WHERE hr_guru_id= $guru_id ORDER BY hr_ta_id ASC";
       $result = $db->query($q,2);      
       foreach ($result as $hasil){
           $arrHomeroom[$hasil->hr_ta_id] = $hasil->hr_kelas_id;
       }
       return $arrHomeroom;
    }
    
    
    
     private function getMPIDbyGuruID($guru_id){
       global $db;
       $arrMPID = array();
       $q = "SELECT mj_mp_id, mj_ta_id, mj_kelas_id FROM {$this->table_mengajar} WHERE mj_guru_id= $guru_id ORDER BY mj_ta_id, mj_kelas_id  ASC";
       $result = $db->query($q,2);      
       //pr($q);
       foreach ($result as $hasil){
           $arrMPID[$hasil->mj_ta_id][$hasil->mj_kelas_id][$hasil->mj_mp_id] = $hasil->mj_mp_id;
       }
       return $arrMPID;
    }   
    
 
     private function getMPNamebyGuruID($guru_id){
       global $db;
       $arrMP = array();
       $q = "SELECT mj_mp_id, mj_ta_id, mj_kelas_id FROM {$this->table_mengajar} WHERE mj_guru_id= $guru_id ORDER BY mj_ta_id, mj_kelas_id  ASC";
       $result = $db->query($q,2);      
       //pr($q);
       foreach ($result as $hasil){
           $arrMP[$hasil->mj_ta_id][$hasil->mj_kelas_id][$hasil->mj_mp_id] = MatapelajaranResmi::getMatapelajaranname($hasil->mj_mp_id);
       }
       return $arrMP;
    } 
    
    public function getGuruTeachsFirstKelas($guru, $ta){
//        object guru - mengajar - ta -kelas
      
        foreach($guru->_mengajar as $taHelp=>$value){ 
            if($ta == $taHelp){
                 foreach($value as $kelas=>$kelasid){
                     return $kelas;
                     break;
                 }
            }
        }
    }
  
    public function getGuruTeachsFirstMPID($guru, $ta){
//        object guru - mengajar - ta -kelas
        
        foreach($guru->_mengajarMP as $taHelp=>$value){ 
            if($ta == $taHelp){
              foreach($value as $kelas=>$kelasid){
                  if($kelas == $this->getGuruTeachsFirstKelas($guru, $ta) ){                      
                      foreach($kelasid as $mp_id=>$mp_name){                           
                          return ($mp_id);
                          break;
                      }                      
                  }                 
                }  
            }
        }
    }  
    
    public function getGuruTeachsFirstMPIDByKelas($guru, $ta, $kls_id){
//        object guru - mengajar - ta -kelas
        
        foreach($guru->_mengajarMP as $taHelp=>$value){ 
            if($ta == $taHelp){
              foreach($value as $kelas=>$kelasid){
                  if($kelas == $kls_id ){                      
                      foreach($kelasid as $mp_id=>$mp_name){                           
                          return ($mp_id);
                          break;
                      }                      
                  }                 
                }  
            }
        }
    }       
    
    // Check guru ngajar MP di kelas di ta tersebut
    public function isGuruTeachsMPbyID($guru, $ta, $kls_id, $mpID_ygdicari){
            $result = false;
            foreach($guru->_mengajarMP as $taHelp=>$value){ 
                if($ta == $taHelp){
                    foreach($value as $kelas=>$kelasid){  
                        if($kelas == $kls_id ){
                            foreach($kelasid as $mp_id=>$mp_name){  
                                if($mp_id == $mpID_ygdicari){
                                    $result = true;
                                    
                                }
                            } 
                        }    
                    }
                }
            }
            return $result;
    }
    
    public function getTableMengajar($ta){
        global $db;
        $q = "SELECT mengajar_id,guru_id,mj_mp_id,mj_kelas_id,mj_jam,nama_depan,foto,account_id,guru_color FROM {$this->table_mengajar},{$this->table_name} WHERE mj_ta_id = '$ta' AND mj_guru_id = guru_id";        
        $mjarr = $db->query($q,2);
        return $mjarr;
    }
    /*
     * get full from 4 table
     */
    public function getTableMengajarFull($ta){
        global $db;
        $mp = new Matapelajaran();
        $kelas = new Kelas();
        $q = "SELECT mengajar_id,guru_id,mj_mp_id,mj_kelas_id,mj_jam,nama_depan,foto,account_id,guru_color,mp_name,kelas_name,mp_singkatan "
                . "FROM {$this->table_mengajar},{$this->table_name},{$mp->table_name},{$kelas->table_name} "
        . "WHERE mj_ta_id = '$ta' AND mj_guru_id = guru_id AND mj_mp_id = mp_id AND mj_kelas_id = kelas_id";        
        $mjarr = $db->query($q,2);
        return $mjarr;
    }
    public function getHomeroomFromKelas($ta,$klsid){
        global $db;
        $hr_id = $ta."_".$klsid;				
        $q = "SELECT hr_id,guru_id,nama_depan,hr_kelas_id,guru_color,account_id FROM {$this->table_homeroom},{$this->table_name} WHERE hr_id = '$hr_id' AND hr_guru_id = guru_id";
        $hr = $db->query($q,1);
        return $hr;
    }
    public function getHomeroomFromTa($ta){
        global $db;	
        $kelas = new Kelas();
        $q = "SELECT hr_id,guru_id,nama_depan,hr_kelas_id,guru_color,kelas_name FROM {$this->table_homeroom},{$this->table_name},{$kelas->table_name}"
        . " WHERE hr_ta_id = '$ta' AND hr_guru_id = guru_id AND hr_kelas_id = kelas_id";
        $hr = $db->query($q,2);
        return $hr;
    }
    /*
     * load selection guru on MJ
     */
    public function loadMJGuruSelection($ta){
        $guru_id = addslashes($_GET["guru_id"]);
        $mp_id = addslashes($_GET["mp_id"]);
        $kelas_id = addslashes($_GET["kelas_id"]);
        $load = addslashes($_GET["load"]);
        //load  guru aktiv
        $guru = new Guru();
        $arrGuru = $guru->getWhere("guru_aktiv = 1 ORDER BY nama_depan ASC","guru_id,nama_depan");
        
       
        //define the ID's'
        $id = Guru::createMjId($mp_id, $kelas_id, $ta);       
        $loadid = time()."__".$mp_id."_".$kelas_id;
        
        if($load){
            global $db;
            $q ="SELECT * FROM {$this->table_mengajar} WHERE mengajar_id = '$id'";
            $mj = $db->query($q,1);
            $return['mj'] = $mj;
        }
        
        //create returns
        $return['mj_id'] = $id;        
        $return['loadid'] = $loadid;
        $return['arrGuru'] = $arrGuru;
        $return['posts'] = $_GET;
        
        return $return;
    }
    /*
     * static create mengajar ID
     */
    public static function createMjId($mp_id,$kelas_id,$ta_id){
        return $mp_id."_".$kelas_id."_".$ta_id;    
    }
    /*
     * fungsi set Mengajar di panggil di table mengajar utk set jam dan guru
     */
    public function setMengajar(){
        global $db;
        $guru_id = addslashes($_POST["guru_id"]);
        $mjid =  addslashes($_POST["mjid"]);
	$jam =  addslashes($_POST["jam"]);
        $arr = explode("_",$mjid);
        global $db;
        $q ="INSERT INTO {$this->table_mengajar} SET mengajar_id = '$mjid',mj_jam ='$jam',mj_guru_id ='$guru_id',mj_mp_id = '{$arr[0]}',mj_kelas_id = '{$arr[1]}',mj_ta_id='{$arr[2]}'"
        . "ON DUPLICATE KEY UPDATE "
        . "mj_guru_id ='$guru_id',mj_jam ='$jam'";
        $json['bool'] = $db->query($q,0);
        if(!$json['bool'])
            $json['err'] = Lang::t('Insert Failed');
        return $json;
    }
    /*
     * fungsi set setHomeroom di panggil di table mengajar utk set  guru
     */
    public function setHomeroom(){
        global $db;
        $guru_id = addslashes($_POST["guru_id"]);
        $hrid =  addslashes($_POST["hrid"]);
        $arr = explode("_",$hrid);
        global $db;
        $q ="INSERT INTO {$this->table_homeroom} SET hr_id = '$hrid',hr_guru_id ='$guru_id',hr_kelas_id = '{$arr[1]}',hr_ta_id='{$arr[0]}'"
        . "ON DUPLICATE KEY UPDATE "
        . "hr_guru_id ='$guru_id'";
        $json['bool'] = $db->query($q,0);
        if(!$json['bool'])
            $json['err'] = Lang::t('Insert Failed');
        return $json;
    }
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            $return['nama_belakang'] = new Leap\View\InputText("hidden", "nama_belakang", "nama_belakang", $this->nama_belakang);            
            $return['account_id'] = new Leap\View\InputText("hidden", "account_id", "account_id", $this->account_id);            
            $return['guru_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"guru_aktiv", "guru_aktiv",$this->guru_aktiv);
            $return['foto'] = new \Leap\View\InputFoto("foto", "foto", $this->foto);
            $return['guru_color'] = new Leap\View\InputText("color", "guru_color", "guru_color", $this->guru_color); 
            return $return;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(isset($obj->foto)){
                $obj->foto = \Leap\View\InputFoto::getAndMakeFoto($obj->foto, "foto_guru_".$obj->guru_id);
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
    
    public function getKelasIDFromHomeroomID($ta,$guruID){
        global $db;
        $q = "SELECT hr_kelas_id FROM {$this->table_homeroom} WHERE hr_ta_id='$ta' AND hr_guru_id='$guruID'";
        $r = $db->query($q,1);
       return $r;
    }   
}
