<?php
/**
 * Description of Schoolsetup
 * Schoolsetup berisi fungsi2 untuk pengaturan sekolah, termasuk bbrp master data
 * @author Elroy Hardoyo
 */
class Schoolsetup extends WebService {
    
    /*
     *  Ambil Hari Efektif mengajar dalam satu semesternya, 
     *  Kombinasikan dengan hari libur, weekend, ujian, event, dll
     */
    public function getEffDay(){
               
        // calendar model
        $c = new Calendar();
        
        //get Effective Day
        $arr = $c->getEffDay();       
        
        //set bahwa yang skrg akses bukan murid
        $arr['muridview'] = 0; 
        
        //Molding ke Desain / view
        Mold::both("calendar/calendar_effday",$arr);
        
        //Data di molding ke 2 view yang berbeda
        Mold::both("calendar/calendar_effday_bulanan",$arr);
        
    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     * untuk mengisi calendar
     */
    public function calendar(){
        
        //$ta = TahunAjaran::ta();
    
        //create the model object
        $cal = new Calendar();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
    

    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function matapelajaran(){
        //create the model object
        $mp = new Matapelajaran();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($mp,$webClass);
        
         
        //pr($mps);
    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function kelas(){
        //create the model object
        $kls = new Kelas();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($kls,$webClass);      
        //pr($mps);
    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function guru(){
        //create the model object
        $gr = new Guru();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($gr,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function tatausaha(){
        //create the model object
        $tt = new Tatausaha();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($tt,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function schoolsetting(){
        //create the model object
        $st = new Schoolsetting();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($st,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     * untuk mengisi Account
     */
    public function account(){
        //create the model object
        $cal = new Account();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
    /*
     * table mengajar, spy tahu guru apa ngajar apa
     */
    public function tablemengajar(){
        //load ta
        $ta = TahunAjaran::ta();
        
        //command switch
        $cmd = (isset($_GET['cmd'])?$_GET['cmd']:"read");
        //edit mj
        if($cmd == "edit"){
            $guru = new Guru();
            $return = $guru->loadMJGuruSelection($ta);
            $return['method'] = __FUNCTION__;
            $return['webClass'] = __CLASS__;
            //pr($return);
            //die();
            Mold::both("schoolsetup/tablemengajar_selection", $return);
            exit();
        }
        //submit mj
        if($cmd == "editSubmit"){
            $guru = new Guru();
            $json = $guru->setMengajar();
            die(json_encode($json));
        }
        // edit homeroom
        if($cmd == "editHr"){
            $guru = new Guru();
            $kelas_id = (isset($_GET['kelas_id'])?$_GET['kelas_id']:0);
            if($kelas_id == 0)die('kelas id must exists');
            $return['hr'] = $guru->getHomeroomFromKelas($ta,$kelas_id);
            
            //load  guru aktiv
            $guru = new Guru();
            $arrGuru = $guru->getWhere("guru_aktiv = 1 ORDER BY nama_depan ASC","guru_id,nama_depan");
            
            $return['hrid'] = $ta."_".$kelas_id;
            $return['arrGuru'] = $arrGuru;
            $return['method'] = __FUNCTION__;
            $return['webClass'] = __CLASS__;
            $return['loadid'] = time();
            Mold::both("schoolsetup/tablemengajar_homeroomselect", $return);
            exit();
        }
        //submit hr
        if($cmd == "editSubmitHr"){
            $guru = new Guru();
            $json = $guru->setHomeroom();
            die(json_encode($json));
        }
        
        //load all mp aktiv
        $mp = new Matapelajaran();
        $arrMp =$mp->getWhere("mp_aktiv = 1 ORDER BY mp_group ASC,mp_singkatan ASC","mp_id,mp_name,mp_singkatan,mp_group");
        
        //load all kelas aktiv
        $kls = new Kelas();
        $arrKelas = $kls->getWhere("kelas_aktiv = 1 ORDER BY kelas_name ASC,kelas_tingkatan ASC","kelas_id,kelas_name,kelas_tingkatan");
        
        //pr($arrMp);pr($arrKelas);
        //load guru mengajar
        $guru = new Guru();
        $arrMj = $guru->getTableMengajar($ta);
        
        //bikin array yang pas
        $group = "";
        $newArr = array();
        $newArrID = array();
        $newArrObject = array();
        $totalPerBag = array();
        $totalPerKelas = array();
        $hrPerKelas = array();
        
        foreach ($arrMp as $mps){
            if($group != $mps->mp_group)
                $group = $mps->mp_group;
            foreach($arrKelas as $kl){
                //get homeroom
                if(!isset($hrPerKelas[$kl->kelas_name]))
                $hrPerKelas[$kl->kelas_name] = $guru->getHomeroomFromKelas($ta, $kl->kelas_id);
                
                if(!isset($totalPerBag[$group][$kl->kelas_name]))
                $totalPerBag[$group][$kl->kelas_name] = 0;
                
                if(!isset($totalPerKelas[$kl->kelas_name]))
                    $totalPerKelas[$kl->kelas_name] = 0;
                
                //masukan ke array
                $newArr[$group][$mps->mp_name][$kl->kelas_name] = null;
                //masukan id nya
                $newArrID[$mps->mp_name]= $mps->mp_id;
                $newArrID[$kl->kelas_name]= $kl->kelas_id;
                //save objectnya di array
                $newArrObject[$mps->mp_name]= $mps;
                $newArrObject[$kl->kelas_name]= $kl;
                
                foreach($arrMj as $mj){
                    if($mps->mp_id == $mj->mj_mp_id && $kl->kelas_id == $mj->mj_kelas_id){
                        $mj->mp_obj = $mps;
                        $mj->kelas_obj = $kl;
                        $newArr[$group][$mps->mp_name][$kl->kelas_name] = $mj;
                        $totalPerBag[$group][$kl->kelas_name] += $mj->mj_jam;
                        $totalPerKelas[$kl->kelas_name] += $mj->mj_jam;
                    }
                }
            }
            //$newArr[$group][$mps->mp_name]
        }
        //ksort($newArr);
        //pr($newArr);

        
        //pr($arrMj);
        //pasang ke table
        $return['ta'] = $ta;        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        //yang array taruh bawah
        $return['mp'] = $arrMp;
        $return['kelas'] = $arrKelas;
        $return['arrMj'] = $arrMj;
        $return['sortArrMj'] = $newArr;
        $return['totalPerGroup'] = $totalPerBag;
        $return['totalPerKelas'] = $totalPerKelas;
        $return['hrPerKelas'] = $hrPerKelas;
        $return['arrIDs'] = $newArrID;
        $return['arrObjs'] = $newArrObject;
        Mold::both("schoolsetup/tablemengajar", $return);
    }
    /*
     * Total Session
     */
    public function totalsession(){
        //load ta
        $ta = TahunAjaran::ta();
        //load all mp aktiv
        $guru = new Guru();
        $arrGuru = $guru->getWhere("guru_aktiv = 1 ORDER BY nama_depan ASC","nama_depan,guru_id,account_id,foto,guru_color");
        
        //load mj
        $arrMj = $guru->getTableMengajarFull($ta);
        
        //getHomeroom
        $arrHr = $guru->getHomeroomFromTa($ta);
        
        $totalGuru = array();
        $detailMJ = array();
        $hrPerGuru = array();
        
        foreach($arrGuru as $gr){
            if(!isset($totalGuru[$gr->guru_id]))
                $totalGuru[$gr->guru_id] = 0;
            
            foreach($arrMj as $mj){
                if($gr->guru_id == $mj->guru_id ){
                    $totalGuru[$gr->guru_id] += $mj->mj_jam;
                    $detailMJ[$gr->guru_id][] = $mj;
                }
            }
            
            foreach($arrHr as $hr){
                if($gr->guru_id == $hr->guru_id ){
                    $hrPerGuru[$gr->guru_id] = $hr;
                }
            }
        }
        //pr($arrHr);
        //pr($arrMj);
        //pr($arrGuru);
        
        $return['ta'] = $ta;        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        
        
        $return['totalGuru'] = $totalGuru;
        $return['detailMJ'] = $detailMJ;
        $return['hrPerGuru'] = $hrPerGuru;
        
        $return['arrHr'] = $arrHr;
        $return['arrGuru'] = $arrGuru;
        $return['arrMj'] = $arrMj;
        
        Mold::both("schoolsetup/totalsession", $return);
    }
    /*
     * browseStaff
     */
    public function browseStaff(){
        $guru = new Guru();
        $arrGuru = $guru->getWhere("guru_aktiv = 1 ORDER BY nama_depan ASC", "guru_id,account_id,nama_depan,foto");
        
        $supervisor = new Supervisor();
        $arrSupervisor = $supervisor->getWhere("supervisor_aktiv = 1 ORDER BY nama_depan ASC", "supervisor_id,account_id,nama_depan,foto");
        
        $tatausaha = new Tatausaha();
        $arrTU = $tatausaha->getWhere("tu_aktiv = 1 ORDER BY nama_depan ASC", "tu_aktiv,account_id,nama_depan,foto");
        
        $admin = new Admin();
        $arrAdmin = $admin->getWhere("sys_aktiv = 1 ORDER BY nama_depan ASC", "sys_id,account_id,nama_depan,foto");
        
        $t = time();
        
        $return['arrTU'] = $arrTU;
        $return['arrSupervisor'] = $arrSupervisor;
        $return['arrAdmin'] = $arrAdmin;
        $return['arrGuru'] = $arrGuru;
        $return['method'] = __FUNCTION__;
        $return['webClass'] = __CLASS__;
        
        Mold::both("leap/browseStaff", $return);
    }
}
