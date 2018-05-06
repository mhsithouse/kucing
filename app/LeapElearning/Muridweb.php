<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Muridweb
 *
 * @author User
 */
class Muridweb extends WebService{
    /*
     * Calendar Murid
     */
    public function myCalendar(){
         $c = new Calendar();
         $arr = $c->getEffDay();
         
         $arr['muridview'] = 1;
         Mold::both("calendar/calendar_effday_bulanan",$arr);
    }
    /*
     * ClassWall
     */
    public function myClassWall($timeline){
        $ta = TahunAjaran::ta();
        $kelas = Account::getMyKelas($ta);
        //pr($murid);
        //pr($kelas);
        $_GET['klsid'] = $kelas->kelas_id;
        $_GET['muridview'] = 1;
        //die();
        //if($timeline && !is_array($timeline));
        $ww = new Wallweb();
        $ww->all_class_wall("myClassWall");
    }
    
    /*
     * myClassmate
     * ambil teman dlm satu kelas
     */
    //RBAC Control
    public $access_myClassmate = "murid";
    public function myClassmate($nrRow){
        //ambil tahun ajaran actual
        $ta = TahunAjaran::ta();
        
        //ambil kelasku di tahun ajaran actual
        $kelas = Account::getMyKelas($ta);
        
        // Murid Model
        $murid = new Murid();
        
        //ambil murid2 dlm satu kelas
        $arrMurid = $murid->getMuridDiKelas($kelas, $ta);
        if(is_array($nrRow))$nrRow = 2;
        //buat return array sbg data dlm molding
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['arrMurid'] = $arrMurid;
        $return['kelas'] = $kelas;
        $return['ta'] = $ta;
        $return['selectKelas'] = 0;
        $return['nrRow'] = $nrRow;
        //molding desain
        Mold::both("murid/myClassmate", $return);
    }
    
    /*
     * Profiles
     */
    public function profile(){
        
        // get posted ID
        $acc_id = (isset($_GET['acc_id'])?addslashes($_GET['acc_id']):die('Acc ID empty'));
        
        //cek if this profile is mine
        if($acc_id == Account::getMyID()){
            $this->myProfile();
            die();
        }
        
        //Model
        $acc = new Account();
        
        //getByID using superclass function
        $acc->getByID($acc_id);
        
        //get the role
        $role = ucfirst($acc->admin_role);
        
        //kill the program if roleless
        if($role == "")die('Role Empty');

        //create dynamic object, all subclass from ModelAccount
        $murid = new $role();
        
        //get and fill Object
        $murid->getByAccountID($acc_id);
        
        //create Return Object
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['roleObj'] = $murid;
        $return['acc'] = $acc;
        
        //Molding Design
        Mold::both("leap/profile",$return);
    }
    
    /*
     * myProfile
     */
    public function myProfile(){
        $role = Account::getMyRole();
        if($role=="murid"){
            $murid = new Murid();
            $murid->default_read_coloms = "*";
            $murid->getByAccountID(Account::getMyID());

            //pr($murid);

            $ta = TahunAjaran::ta();
            $kelas = $murid->getMyKelas($ta);
            //pr($murid);
            //get all my kelas
            $kelases = $murid->getAllMyKelas();

            $return['webClass'] = __CLASS__;
            $return['method'] = __FUNCTION__;
            $return['murid'] = $murid;
            $return['kelas'] = $kelas;
            $return['kelases'] = $kelases;

            Mold::both("murid/myprofile",$return);
        }else{
            $roleObj = new $role();
            $roleObj->default_read_coloms = "*";
            $roleObj->getByAccountID(Account::getMyID());
            
            $return['webClass'] = __CLASS__;
            $return['method'] = __FUNCTION__;
            $return['roleObj'] = $roleObj;
            
            Mold::both("leap/myprofile",$return);
        }
    }
    /*
     * myAbsensi
     */
    public function myAbsensi(){
        $murid = new Murid();
        $murid->default_read_coloms = "*";
        $murid->getByAccountID(Account::getMyID());
        
        $mon = Absensi::getBulan();
        $year = Absensi::getTahun();
        
        $abs = new Absensi();
        $murid->absensi = $abs->getAbsensiEinzel($murid->murid_id,$mon,$year);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['murid'] = $murid;
        $return['absensi'] = $murid->absensi;
        $return['mon'] = $mon;
        $return['year'] = $year;
        $return['ta'] = TahunAjaran::ta();
        //ambil kejadian dlm bulan
        $cal = new Calendar();
        $return['calendar'] = $cal->getCalinMonth(Absensi::getBulan());
        
        // get number of day dlm sebulan
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
        $return["numDays"] = $num_of_days;
        
        Mold::both("murid/myAbsensi",$return);
    }
    /*
     * Murid Gallery
     */
    public function sendGallery(){
        
        $acc_id = (isset($_GET['acc_id'])?addslashes($_GET['acc_id']):die('ACC id empty'));
        
        $acc = new Account();
        $acc->getByID($acc_id);
        //pr($acc_id);
        ?>
        <h1><?=$acc->getName();?>'s <?=Lang::t('Gallery');?></h1>    
        <?
        //global $c__Fotoajax; $c__Fotoajax->attachment($id,"sendGallery");
        $targetClass = "Account";
        $fotoweb = new Fotoweb(); $fotoweb->attachment($acc_id,$targetClass);
         
    }
    
  public function MyGrad_tmp()
    {

        $ta = TahunAjaran::ta();
        $murid = new Murid();
        $murid->default_read_coloms = "*";
        $murid->getByAccountID(Account::getMyID());
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):  Matapelajaran::getFirstMPID());
        $mp = new Matapelajaran();
        $mp->getByID($mp_id);
       
        $myNilai = new Nilai($ta, $murid, $mp_id, $murid->murid_tingkatan );
        $return = $myNilai->getMyNilai();
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['mp'] = $mp; 
        $return['murid'] = $arrOfMurid;
        $return['nilai'] = $myNilai;
//        pr($return);
        Mold::both("murid/mygrad", $return);
      
    }

         /*
      * 
      */
     public function viewMyNilaiGraph()
     {
       $ta = (isset($_GET['ta'])?addslashes($_GET['ta']):TahunAjaran::ta());
       $murid_id = $_GET['murid_id'];
       $matapelajaranID = $_GET['matapelajaranID'];
       
       $my_graph = new Nilai($ta, "",$matapelajaranID,"");
       $return['webClass'] = __CLASS__;
       $return['method'] = __FUNCTION__;
       $return['ta'] = $ta;
       $return['murid_id'] = $murid_id;      
       $return['matapelajaranID'] = $matapelajaranID; 
       $return['graph'] = $my_graph->getNilaiNachSubject($murid_id, $matapelajaranID, $ta);
       Mold::both("studentsetup/graphnilai", $return);    
     }
     
      public function myJadwal()
      {
        //pr($_SESSION);  
        //ambil tahun ajaran utk Matapelajaran
        $ta = TahunAjaran::ta();
        
        $murid = new Murid();
        $murid->default_read_coloms = "*";
        $murid->getByAccountID(Account::getMyID());
        $kls = $murid->getMyKelas($ta);
        
       
        $cmd = (isset($_GET['cmd'])?$_GET['cmd']:"read");
        
        $id = $kls->kelas_id;
        
        $tag =date("N");
        
        $jadwalMatapelajaran = new Jadwalmatapelajaran($id,$ta, "Weekly", "");
       // pr($jadwalMatapelajaran);
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;
        $jadwalMatapelajaran->init();
        
        $return['jadwalMatapelajaran'] =  $jadwalMatapelajaran;
        
      
        //Mold::both("studentsetup/jadwalmatapelajaran",  $jadwalMatapelajaran);
        //Mold::both("studentsetup/jadwalmatapelajaranDaily",  $jadwalMatapelajaran);
        Mold::both("studentsetup/jadwalmatapelajaranWeekly",  $return);     
        
      }    
  public function MyGrad(){
        $ta = TahunAjaran::ta();
        /*
         * Ambil kelas yang mau dicari absensinya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):0);
        $kls = new Kelas();
        $kls->getByID($id);
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):  Matapelajaran::getFirstMPID());
        $mp = new Matapelajaran();
        $mp->getByID($mp_id);        
        $murid = new Murid();
        $murid->default_read_coloms = "*";
        $murid->getByAccountID(Account::getMyID());        
        
        $murid_id = $murid->murid_id;
        
       // $note_id = (isset($_GET['note_id'])?addslashes($_GET['note_id']):die('note_id empty'));
        global $db;
        
        $q = "SELECT * FROM ry_murid__nilai INNER JOIN ry_murid__name_nilai ON  ry_murid__name_nilai.name_nilai_id = ry_murid__nilai.nilai_note_id WHERE ry_murid__nilai.nilai_murid_id = '$murid_id' AND ry_murid__name_nilai.nilai_note_mp_id = '$mp_id' ORDER BY ry_murid__name_nilai.name_nilai_date ASC";
        $arrNilai = $db->query($q,2);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;      
        $return['mp'] = $mp; 
        $return['murid'] = $murid;
        $return['arrNilai'] = $arrNilai;
        
         Mold::both("murid/myGrad", $return);  
    }    
}
