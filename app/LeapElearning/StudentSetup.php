<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentSetup
 *
 * @author User
 */
class StudentSetup extends WebService {
    
    public function absensi(){
        
        //ambil tahun ajaran utk absensinya
        $ta = TahunAjaran::ta();
        /*
         * Ambil kelas yang mau dicari absensinya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
        
        //amnbil murid dikelas
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta);        
        
        if(count($arrOfMurid)<1)die('Murid Belum ada yang dikelas ini');
        
        //di get set bulan dantahun di getAbsensi
        $absensi = new Absensi();
        $return = $absensi->getAbsensi($arrOfMurid);
        
        //ambil kejadian dlm bulan
        $cal = new Calendar();
        $return['calendar'] = $cal->getCalinMonth(Absensi::getBulan());
        
        //pr($arrOfMurid);
        //ambil absensi untuk kelas
        //pr($kls);
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;
        
        Mold::both("studentsetup/absensi", $return);
    }
    /*
     * add absen
     * 
     */
    public function add_absen(){
	$mid = addslashes($_GET['murid']);
        $m = addslashes($_GET['mon']);
        $y = addslashes($_GET['year']);
        $d = addslashes($_GET['day']);
        $st = addslashes($_GET['absenstat']);
	//pr($_GET);
	$id = $mid."__".$d."_".$m."_".$y;
	$tgl = $y."-".$m."-".$d;
	$tgl2 = $d."_".$m."_".$y;
	
        
	global $db;
	$q = "INSERT INTO ry_murid__absen SET 
	id='$id',
	tgl = '$tgl',
	murid_id = '$mid',
	absensi = '$st',
	tgl2 = '$tgl2',
	hari = '$d',
	bulan = '$m',
	tahun = '$y' ON DUPLICATE KEY UPDATE 	
	absensi = '$st'
	";
	$suc=$db->query($q,0);
	
	if($suc){
		$q = "SELECT absensi FROM ry_murid__absen WHERE bulan = '$m' AND tahun = '$y' AND murid_id = '$mid'";
		$ct = $db->query($q,2);
		$abs0 = 0; $abs1 =0; $abs2=0; $abs3=0;$abs4 = 0;
		foreach($ct as $c){
			if($c->absensi == "0")$abs0++;
			if($c->absensi == "1")$abs1++;
			if($c->absensi == "2")$abs2++;
			if($c->absensi == "3")$abs3++;
                        if($c->absensi == "4")$abs4++;
		}
		//echo count($ct);
		?>

<div class="newrow">
<div class="col-md-6" style="text-align:center; background-color: white;">
    <div style="font-size: 40px; color: green;"><?=$abs1;?></div>
    <?=Lang::t("Att");?>
</div> 
<div class="col-md-6" style="text-align:center;background-color: white;">
    <div style="font-size: 40px; color: red;"><?=$abs0;?></div>
    <?=Lang::t("Abs");?>
</div>
</div>
<div class="absenijin" style="background-color:yellow;"><?=Lang::t('Permission');?> : <b><?=$abs3;?></b></div>  


		<?
	}else{
	echo "ERR";
	}
	
	
	
        
    }
	
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function murid(){
     
        //create the model object
        $mp = new Murid();
        
        //send the webclass 
        $webClass = __CLASS__;
       
        //run the crud utility
        Crud::run($mp,$webClass);
        
         
        
    }
    /*
     * Bagi kelas
     */
    public function bagikelas(){
        //ambil tahun ajaran utk absensinya
        $ta = TahunAjaran::ta();
        /*
         * Ambil kelas yang mau dicari absensinya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
        
        //pr($kls);
        //amnbil murid dikelas
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta); 
        
        //pr($arrOfMurid);
        //ambil murid yang free dengan tingkatan yang sama
        $arrOfMuridWOClass = $murid->getMuridWithoutKelas($kls->kelas_tingkatan);
        
        //pr($arrOfMuridWOClass);
        //Mold::both("studentsetup/absensi", $return);
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;
        $return['muridKelas'] = $arrOfMurid;
        $return['muridFree'] = $arrOfMuridWOClass;
        Mold::both("studentsetup/bagikelas", $return);
    }
    
    
    /*
     * ins murid ke kelas
     */
    
    function ins_murid_kelas(){
        global $db;	
        $json["bool"] = 0;
        $err = "";
        $klsid = (isset($_GET['klsid'])?addslashes($_GET['klsid']):"");
        $ta = TahunAjaran::ta();
        
        if($klsid == "" || $klsid <1)die('kls id error');
        
        if(isset($_POST['chk']))
        foreach($_POST['chk'] as $ch => $v1)
        {
            $json[$ch] = $v1;
            $chvalues[] = $v1;
            $q = "INSERT INTO ry_murid__kelas SET mk_murid_id = '$v1',mk_kelas_id = '$klsid',mk_ta_id='$ta'";
            $json["bool"]=  $db->query($q,0);
                
        }        
                											
	$json["err"] = $err;
	echo json_encode($json);
	exit();	
    }
    /*
     * del_murid_kelas
     */
    public function del_murid_kelas(){
        $mk_id = (isset($_GET['mk_id'])?addslashes($_GET['mk_id']):"");
        global $db;

        $q = "DELETE FROM ry_murid__kelas WHERE mk_id = $mk_id";
        $json["bool"]=  $db->query($q,0);

    }
    /*
     * browseStudent
     */
    public function browseStudent(){
        //ambil tahun ajaran utk absensinya
        $ta = TahunAjaran::ta();
        /*
         * Ambil kelas yang mau dicari absensinya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
        
        //pr($kls);
        //amnbil murid dikelas
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta); 
        //pr($arrOfMurid);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['arrMurid'] = $arrOfMurid;
        $return['kelas'] = $kls;
        $return['ta'] = $ta;
        $return['nrRow'] = 2;
        $return['selectKelas'] = 1;
        Mold::both("murid/myClassmate", $return);
    }
    /*
     * browseMP
     */
    public function browseMP(){
        $mp = new Matapelajaran();
        $arrMP = $mp->getWhere("mp_aktiv = 1 ORDER BY mp_name ASC", "mp_id,mp_name,mp_singkatan,mp_foto,mp_group");
        
        //pr($arrMP);
        $return['arrMP'] = $arrMP;
        Mold::both("leap/browseMP", $return);
    }
    
    /*
     * Jadwal Mata pelajaran Efindi
     */
    public function jadwalMataPelajaran(){
        //ambil tahun ajaran utk Matapelajaran
        $ta = TahunAjaran::ta();
//        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
//        $kls = new Kelas();
//        $kls->getByID($id);
       
        
        $cmd = (isset($_GET['cmd'])?$_GET['cmd']:"read");
       // echo "Cmd : " . $cmd;
        //pr($_SESSION);
        /*
         * Ambil kelas yang mau dicari Matapelajarannya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):'1');
       
        $kls = new Kelas();
        $kls->getByID($id);
        
        if($id != "all"){

        }
        
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
     /*
      * Jadwal Mata Pelajaran Elroy w/o table mengajar
      */
      public function jadwalMataPelajaran2(){
        //ambil tahun ajaran utk Matapelajaran
        $ta = TahunAjaran::ta();
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
       
        //echo $id;
        
        $cmd = (isset($_GET['cmd'])?$_GET['cmd']:"read");
       
        
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
     /*
      * elroy bikin buat select di jadwal mp
      */
     public function getJadwalMPSelector(){
         $mp_id = (isset($_GET['mp_id'])? addslashes($_GET['mp_id']): die('mp_id empty'));
         $mp_type = (isset($_GET['mp_type'])? addslashes($_GET['mp_type']): die('mp_type empty'));
         
         $mp = new Matapelajaran();
         $arrMP = $mp->getWhere("mp_id>0");
         
         $mptr = new MatapelajaranTidakResmi();
         $arrMPTR = $mptr->getWhere("mptr_id>0");
         //pr($_GET);
        $t = time();
        
        // untuk query langsung
         $kls_id = (isset($_GET['kls_id'])? addslashes($_GET['kls_id']): die('kls_id empty'));
         $slotID = (isset($_GET['slotID'])? addslashes($_GET['slotID']): die('slotID empty'));
         $day = (isset($_GET['day'])? addslashes($_GET['day']): die('day empty'));
         
         $ta = TahunAjaran::ta();
         
         //elroy : ini di query langsung...
         $id = $day."_".$slotID."_".$kls_id."_".$ta;
         
         //elroy : ini di query langsung...
         $id = $day."_".$slotID."_".$kls_id."_".$ta;
         global $db;
         
         $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_id = '$id'";
         $jd = $db->query($q,1);
         
         ?>
<span id="spanselectmp<?=$t;?>">
<select id="selectmp<?=$t;?>">
         <?
         foreach($arrMP as $mp){   
             $selected = "";
             if($jd->jw_type == "mp")
                 if($mp->mp_id == $jd->jw_mp_id)$selected = "selected";
             ?>
            <option value="mp_<?=$mp->mp_id;?>" <?=$selected;?>><?=$mp->mp_name;?></option>    
             <?
         }
         ?>
         <?
         foreach($arrMPTR as $mptr){    
             $selected = "";
             if($jd->jw_type == "mptr")
                 if($mptr->mptr_id == $jd->jw_mp_id)$selected = "selected";
             ?>
            <option value="mptr_<?=$mptr->mptr_id;?>" <?=$selected;?>><?=$mptr->mptr_desr;?></option>    
             <?
         }
         ?>   
</select>
</span>

<script>
$("#selectmp<?=$t;?>").change(function(){
    var ctr = $("#selectmp<?=$t;?>").val();
    $.get('<?=_SPPATH;?>StudentSetup/setJadwalMP?mp='+ctr+'&kls_id=<?=$_GET['kls_id'];?>&slotID=<?=$_GET['slotID'];?>&day=<?=$_GET['day'];?>',
    function(data) {
        //alert( data );
    });
    $("#spanselectmp<?=$t;?>").html($("#selectmp<?=$t;?> option:selected").text());
});    
</script>
          <?
         //exit();
     }
     public function setJadwalMP(){
         $mp = (isset($_GET['mp'])? addslashes($_GET['mp']): die('mp_id empty'));
         list($mp_type,$mp_id) = explode("_",$mp);
         $kls_id = (isset($_GET['kls_id'])? addslashes($_GET['kls_id']): die('kls_id empty'));
         $slotID = (isset($_GET['slotID'])? addslashes($_GET['slotID']): die('slotID empty'));
         $day = (isset($_GET['day'])? addslashes($_GET['day']): die('day empty'));
         
         $ta = TahunAjaran::ta();
         
         //elroy : ini di query langsung...
         $id = $day."_".$slotID."_".$kls_id."_".$ta;
         global $db;
         
         //cari slot jam mulai dan end
         $jdwltext = Schoolsetting::getJamPelajaran();
         $arrSlot = explode(",", $jdwltext);
         
         foreach($arrSlot as $num=>$val){
             if($num ==  $slotID){
                 $begin = $val;
             }
             if($num == ($slotID+1)){
                 $end = $val;
             }
         }
         
         $q = "INSERT INTO ry_sekolah__jadwalmp SET 
        jw_id= '$id',
        jw_kelas_id = '$kls_id',
        jw_mp_id = '$mp_id',
        jw_slot_id = '$slotID',
        jw_mulai= '$begin',
        jw_end= '$end',
        jw_ta_id = '$ta',
        jw_hari_id = '$day',
        jw_type  = '$mp_type'
        ON DUPLICATE KEY UPDATE jw_type = '$mp_type',jw_mp_id = '$mp_id'";
         $jd = $db->query($q,0);
        
         //pr($jd);
         
         //$jd->save();
     }

     public function nilai()
     {
        //ambil tahun ajaran utk absensinya
        $ta = TahunAjaran::ta();
        /*
         * Ambil kelas yang mau dicari absensinya
         */
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):  Matapelajaran::getFirstMPID());
        $mp = new Matapelajaran();
        $mp->getByID($mp_id);
                
        //amnbil murid dikelas
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta);    
       
        $nilai = new Nilai($ta, $arrOfMurid,$mp_id, $id);
        $return = $nilai->getNilaiKelasSortNachDatum();
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;      
        $return['mp'] = $mp; 
        $return['murid'] = $arrOfMurid;
        $return['nilai'] = $nilai;
        //pr($nilai);
        Mold::both("studentsetup/nilai", $return);
     }
     
     public function insertNilai()
     {

        //ambil tahun ajaran utk absensinya
        $ta = TahunAjaran::ta();
        $id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):Kelas::getFirstKelasID());
        $kls = new Kelas();
        $kls->getByID($id);
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):  Matapelajaran::getFirstMPID());
        $mp = new Matapelajaran();
        $mp->getByID($mp_id);
        
        // utk insert ke db
        $cmd= $_GET['cmd'];
        $murid_id = $_GET['murid_id'];
        $matapelajaranID = $_GET['matapelajaranID'];
        $kelas_id = $_GET['kelas_id'];
        $nilaiUjian = $_GET['nilaiUjian'];
        $tglUjian = $_GET['tglUjian'];
        $jenisUjian = $_GET['jenisUjian'];
        
        //amnbil murid dikelas
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta);    
       
        $nilai = new Nilai($ta, $arrOfMurid,$mp_id, $id);
        if($cmd == "insert")
        {
            $nilai->insertTanggalUjian($murid_id, $matapelajaranID, $nilaiUjian, $tglUjian, "Daily", $ta,$kelas_id);
            $_GET['cmd'] = "";
            Mold::both("studentsetup/insertnilai", $return);
        }
        else
        {
        $return = $nilai->getNilaiKelasSortNachDatum();
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;      
        $return['mp'] = $mp; 
        $return['murid'] = $arrOfMurid;
        $return['nilai'] = $nilai;
        Mold::both("studentsetup/insertnilai", $return);
        }
     } 
     
     /*
      * 
      */
     public function viewNilaiGraph()
     {
       $ta = (isset($_GET['ta'])?addslashes($_GET['ta']):TahunAjaran::ta());
       $murid_id = $_GET['murid_id'];
       $matapelajaranID = $_GET['matapelajaranID'];
       
       $nilai = new Nilai($ta, "",$matapelajaranID,"");
       $return['webClass'] = __CLASS__;
       $return['method'] = __FUNCTION__;
       $return['ta'] = $ta;
       $return['murid_id'] = $murid_id;      
       $return['matapelajaranID'] = $matapelajaranID; 
       $return['graph'] = $nilai->getNilaiNachSubject($murid_id, $matapelajaranID, $ta);
       Mold::both("studentsetup/graphnilai", $return);    
     }
}