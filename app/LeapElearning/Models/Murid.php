<?php
/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

/**
 * Description of MuridController
 *
 * @author User
 */
class Murid extends ModelAccount {
    
    //my table name
    var $table_name = "ry_murid__data";
    var $main_id = "murid_id"; //cannot be filtered, use to do view, delete and update operation
    var $default_read_coloms = "nomor_induk,nama_depan,murid_tingkatan,alamat,telp"; 
    
    
    var $murid_id,$nomor_induk,
    $nama_depan,
    $nama_belakang,
    $foto,
    $account_id,
    $murid_aktiv,
    $murid_tingkatan,
    $createdate,
    $tgllahir,
    $tmplahir,
    $alamat,
    $telp,
    $sex,
    $anakke,
    $agama,
    $hobby,
    $outside,
    $namayah,
    $namaibu,
    $alamatwali,
    $telpwali,
    $pekerjaan,
    $nickname;
    //allowed colom in database
    var $coloumlist = "nomor_induk,nama_depan,foto,account_id,murid_aktiv,murid_tingkatan,createdate,tgllahir,tmplahir,
        alamat,telp,sex,anakke,agama,hobby,outside,namayah,namaibu,alamatwali,telpwali,pekerjaan,nickname";
    
    var $table_murid_kelas = "ry_murid__kelas";
    /*
     * ambil murid dr suatu kelas
     */
    public function getMuridDiKelas($kls,$ta){
        if($kls instanceof Kelas){
            $klsid = $kls->{$kls->main_id};
            
            $acc = new Account();
            
            global $db;
            $q = "SELECT admin_nama_depan,admin_id,murid_id,admin_foto,mk_id FROM {$this->table_murid_kelas},{$this->table_name},{$acc->table_name} WHERE mk_ta_id = '$ta' AND mk_kelas_id = '$klsid' AND account_id = admin_id AND mk_murid_id = murid_id AND murid_aktiv = '1' ORDER BY admin_nama_depan ASC";
		//echo $q;
            $muridkelas = $db->query($q,2);
            
            $newMurid = array();
            foreach($muridkelas as $databasemurid){
                $m = new Murid();                
                $m->fill(toRow($databasemurid));
                $newMurid[] = $m;
            }
            return $newMurid;
        }else 
            die('getMuridDiKelas butuh parameter object Kelas');
    }
    /*
     * ambil murid yg belum punya kelas dengan tingkatan yg sama
     */
    public function getMuridWithoutKelas($tingkatan){
        if($tingkatan>0){
            
            $acc = new Account();
            $kls = new Kelas();
            global $db;
            /*$q = "SELECT admin_nama_depan,admin_id,murid_id,admin_foto FROM {$this->table_murid_kelas},{$this->table_name},{$acc->table_name} WHERE mk_ta_id = '$ta' AND mk_kelas_id = '$klsid' AND account_id = admin_id AND mk_murid_id = murid_id AND murid_aktiv = '1' ORDER BY mk_no_urut ASC";
            
            $q = "SELECT t1.nama_depan,t1.murid_id,t1.foto
            FROM {$this->table_name} t1,{$kls->table_name} t3
            LEFT JOIN {$this->table_murid_kelas} t2 ON t2.mk_murid_id = t1.murid_id
            WHERE t2.mk_kelas_id = t3.kelas_id AND t t2.mk_murid_id IS NULL AND t";
            */
            
            $q = "SELECT  admin_nama_depan,admin_id,murid_id,admin_foto,murid_tingkatan
            FROM    {$this->table_name},{$acc->table_name}
            WHERE account_id = admin_id AND murid_tingkatan = '$tingkatan' AND murid_aktiv = '1' AND  murid_id NOT IN (SELECT mk_murid_id FROM {$this->table_murid_kelas}) ORDER BY admin_nama_depan ASC";
            
            $muridkelas = $db->query($q,2);
            
            $newMurid = array();
            foreach($muridkelas as $databasemurid){
                $m = new Murid();                
                $m->fill(toRow($databasemurid));
                $newMurid[] = $m;
            }
            return $newMurid;
        }else 
            die('getMuridWithoutKelas butuh tingkatan');
    }
    /*
     * ambil kelas ku
     */
    public function getMyKelas($ta){        
        global $db;
        $kelas = new Kelas();
        $q = "SELECT kelas_id,kelas_tingkatan,kelas_name FROM {$this->table_murid_kelas},{$kelas->table_name} WHERE mk_ta_id = '$ta' AND mk_murid_id = '{$this->murid_id}' AND mk_kelas_id = kelas_id LIMIT 0,1";
            //echo $q;
        $rows = $db->query($q,1);
        $kelas->fill(toRow($rows));
        return $kelas;
    }
    /*
     * getAllMyKelas
     */
    public function getAllMyKelas(){
        global $db;
        $kelas = new Kelas();
        $q = "SELECT kelas_id,kelas_tingkatan,kelas_name,mk_ta_id FROM {$this->table_murid_kelas},{$kelas->table_name} WHERE mk_murid_id = '{$this->murid_id}' AND mk_kelas_id = kelas_id ORDER BY mk_ta_id ASC";
        //echo $q;
        $muridkelas = $db->query($q,2);
        //pr($muridkelas);    
        $newMurid = array();
        foreach($muridkelas as $databasemurid){
            $m = new Kelas();                
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }
        return $newMurid;
    }
    /*
     * CRUD Config function
     */
    public function overwriteForm($return,$returnfull){
            //kalau ada yang tidak mau tampilkan bisa dengan type hidden
            $return['murid_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"murid_aktiv", "murid_aktiv",$this->murid_aktiv);
            $return['murid_tingkatan'] = new Leap\View\InputSelect(array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6),"murid_tingkatan", "murid_tingkatan",$this->murid_tingkatan);
            
            $return['tgllahir']= new Leap\View\InputText("date", "tgllahir", "tgllahir", $this->tgllahir);  
            $return['account_id']= new Leap\View\InputText("hidden", "account_id", "account_id", $this->account_id);  
            $return['nama_belakang']= new Leap\View\InputText("hidden", "nama_belakang", "nama_belakang", $this->nama_belakang);  

            $return['foto'] = new \Leap\View\InputFoto("foto", "foto", $this->foto);
            return $return;
    }
    public function constraints(){
        //err id => err msg
        $err = array();        
        if(!isset($this->nama_depan))$err['nama_depan'] = Lang::t('err nama_depan_empty');
        return $err;
    }
    

    public function read2($perpage =  20){
        global $db;
        $page = (isset($_GET['page'])? addslashes($_GET['page']):1);
        $all = 0;
        if($page == "all"){
            $page = 1;
            $all = 1;
        }
        $begin = ($page-1)*$perpage;
        $limit = $perpage;
        // get columnlist filter
        $clms = (isset($_GET['clms'])? addslashes($_GET['clms']):'');
        if($clms == "")$clms = $this->default_read_coloms;
        $clmsPlaceholder = $clms;
        $clms = $this->main_id.",".$clms; // add main id to the filter
        $arrClms = explode(",", $clms);
        // searchh
        $searchdb = "WHERE admin_id = account_id";
        $search = (isset($_GET['search'])? addslashes($_GET['search']):0);
        
        $w = (isset($_GET['word'])? addslashes($_GET['word']):'');
        if($search == 1 && $w!=''){
            $searchdb .= " AND (";
            foreach($arrClms as $col){
                $imp[] = " $col LIKE '%{$w}%' ";
               
            }
            $searchdb .= implode(" OR ",$imp);
            $searchdb .= " )";       
            
        }
        // get placeholder
        $placeholder = "";$p = array();
        foreach($arrClms as $col){
             $p[] = Lang::t($col);
        }
        $placeholder = implode(",",$p);
        
        
        $t = time();
        $q = "SELECT count(*) as nr FROM {$this->table_name},{$this->linked_table_name} $searchdb";
        $nr = $db->query($q,1);
        //echo $q;echo "<br>";
        $sortdb = "admin_nama_depan ASC";
        $sort = (isset($_GET['sort'])? addslashes($_GET['sort']):$sortdb);
        $sortdb = $sort;
        //if($sort == "")$sortdb = "admin_nama_depan ASC";
        //if($sort == "namaasc")$sortdb = "admin_nama_depan ASC";
        //if($sort == "namadesc")$sortdb = "admin_nama_depan DESC";
        //echo $searchdb;
        // untuk all
        $beginlimit = "LIMIT $begin,$limit";
        if($all){$beginlimit = ""; $perpage = $nr->nr;}
        $q = "SELECT $clms FROM {$this->table_name},{$this->linked_table_name} $searchdb ORDER BY $sortdb $beginlimit";
        //echo $q;
        //create return array
        
        
        $return['arr'] = $db->query($q,2);
        $return['totalpage'] = ceil($nr->nr/$perpage);
        $return['perpage'] = $perpage;
        $return['page'] = $page;
        $return['sort'] = $sort;
        $return['search'] = $placeholder;
        $return['search_keyword'] = $w;
        $return['search_triger'] = $search;
        $return['coloms'] = $clmsPlaceholder;
        $return['colomslist'] = $this->coloumlist;
        $return['main_id'] = $this->main_id;
        $return['classname'] = get_class($this);
        
        $export = (isset($_GET['export'])? addslashes($_GET['export']):0);
        if($export){
 
            $this->exportIt($return);
        }
        
        return $return;
    }
    
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(isset($obj->foto)){
                $obj->foto = \Leap\View\InputFoto::getAndMakeFoto($obj->foto, "foto_murid_".$obj->murid_id);
            }
        }
        //pr($return);
        return $return;
    }
    
}
