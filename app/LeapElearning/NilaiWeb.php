<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NilaiWeb
 *
 * @author EO
 */
class NilaiWeb extends WebService {
    //starting seite
    public function index(){
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
        
        ///cari note utk kelas ini di tahunajaran ini
        global $db; 
        $q = "SELECT * FROM ry_murid__name_nilai WHERE 
            nilai_note_kelas_id = '{$kls->kelas_id}'
            AND nilai_note_ta = '{$ta}'
            AND nilai_note_mp_id  = '{$mp->mp_id}' ORDER BY name_nilai_date ASC";
        $arrNote = $db->query($q,2);    
        
        foreach($arrNote as $note){
            $implodeNote[] = $note->name_nilai_id;
        }
        //pr($arrNote);
        $imp = implode(",",$implodeNote);
        
        $q = "SELECT * FROM ry_murid__nilai WHERE nilai_note_id IN ($imp)";
        $arrNilai = $db->query($q,2);
        
        //pr($arrNilai);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;      
        $return['mp'] = $mp; 
        $return['arrOfMurid'] = $arrOfMurid;
        $return['nilai'] = $nilai;
        $return['arrNote'] = $arrNote;
        $return['arrNilai'] = $arrNilai;
        //pr($return['nilai']);
        Mold::both("nilai/index", $return); 
    }
    public function isiNilai(){
       // pr($_POST);
        $nilai_id = (isset($_POST['nilai_id'])?addslashes($_POST['nilai_id']):0);
        
        $nilaibaru = (isset($_POST['nilaibaru'])?addslashes($_POST['nilaibaru']):die('Nilai empty'));
        $note_id = (isset($_POST['note_id'])?addslashes($_POST['note_id']):die('Note ID empty'));
        $murid_id = (isset($_POST['murid_id'])?addslashes($_POST['murid_id']):die('Murid ID empty'));
        
        
        
        global $db;
        
        //ambil dari db dulu apakah sudah ada nilai si murid ini
        $q = "SELECT * FROM ry_murid__nilai WHERE nilai_note_id = '$note_id' AND  nilai_murid_id = '$murid_id'";
        $nilaiObj = $db->query($q,1);
        
        
        if(isset($nilaiObj->nilai_id)){
        $q = "UPDATE ry_murid__nilai SET
            nilai_value = '$nilaibaru' WHERE nilai_id = '{$nilaiObj->nilai_id}'
        ";
        }else{
          $q = "INSERT INTO ry_murid__nilai SET 
            nilai_id  = '$nilai_id',          
            nilai_note_id = '$note_id',
            nilai_murid_id = '$murid_id',
            nilai_value = '$nilaibaru'            
            ";  
        }
        $db->query($q,0);
    }
    public function editNote(){
         $note_id = (isset($_POST['note_id'])?addslashes($_POST['note_id']):die('Note ID empty'));
         $notebaru = (isset($_POST['notebaru'])?addslashes($_POST['notebaru']):die('notebaru ID empty'));
         global $db;
         
         $q = "UPDATE ry_murid__name_nilai SET name_nilai_judul = '$notebaru' WHERE name_nilai_id = '$note_id'";
         $db->query($q,0);
    }
    public function addNote(){
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):die('mp_id ID empty'));
        $kls_id = (isset($_GET['kls_id'])?addslashes($_GET['kls_id']):die('kls_id ID empty'));
        //$name_nilai_date = (isset($_GET['name_nilai_date'])?addslashes($_GET['name_nilai_date']):die('name_nilai_date ID empty'));
        $ta = TahunAjaran::ta();
        $return['mp_id'] = $mp_id;
        $return['kls_id'] = $kls_id;
        $return['name_nilai_date'] = $name_nilai_date;
        $return['ta'] = $ta;
        Mold::both("nilai/addNoteForm",$return);
        
    }
    public function insertNoteToDB(){
        $nilai_note_kelas_id = (isset($_POST['nilai_note_kelas_id'])?addslashes($_POST['nilai_note_kelas_id']):die('Nilai empty'));       
        $nilai_note_ta = (isset($_POST['nilai_note_ta'])?addslashes($_POST['nilai_note_ta']):die('nilai_note_ta empty'));
        $nilai_note_mp_id = (isset($_POST['nilai_note_mp_id'])?addslashes($_POST['nilai_note_mp_id']):die('nilai_note_mp_id empty'));
        //$name_nilai_date = (isset($_POST['name_nilai_date'])?addslashes($_POST['name_nilai_date']):die('name_nilai_date ID empty'));
        $name_nilai_judul = (isset($_POST['name_nilai_judul'])?addslashes($_POST['name_nilai_judul']):die('name_nilai_judul empty'));
        
        $name_nilai_date = date('Y-m-d', strtotime($_POST['name_nilai_date']));
  
        global $db;
        $q = "INSERT INTO ry_murid__name_nilai SET  name_nilai_judul = '$name_nilai_judul',
        name_nilai_date = '$name_nilai_date',
        nilai_note_kelas_id = '$nilai_note_kelas_id',
        nilai_note_ta = '$nilai_note_ta',
        nilai_note_mp_id = '$nilai_note_mp_id'";
//        $json['err'] =  $q;
        $json['bool'] =  $db->query($q,0);
        if(!$json['bool']){
            $json['err'] = Lang::t('Error as insert');
        }
        die(json_encode($json));  
        
    }
    
    public function deleteNote(){
        $note_id = (isset($_POST['note_id'])?addslashes($_POST['note_id']):die('Note ID empty'));
        global $db;
         
         $q = "DELETE FROM  ry_murid__name_nilai WHERE name_nilai_id = '$note_id'";
         $db->query($q,0);
    } 
    
    public function graph(){
        $murid_id = (isset($_GET['murid_id'])?addslashes($_GET['murid_id']):die('Murid ID empty'));
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):die('mp_id empty'));
        $note_id = (isset($_GET['note_id'])?addslashes($_GET['note_id']):die('note_id empty'));
        global $db;
        $q = "SELECT ry_murid__name_nilai.name_nilai_judul, ry_murid__nilai.nilai_value, ry_murid__name_nilai.name_nilai_date FROM ry_murid__nilai INNER JOIN ry_murid__name_nilai ON ry_murid__nilai.nilai_note_id = ry_murid__name_nilai.name_nilai_id WHERE ry_murid__nilai.nilai_murid_id='$murid_id' AND ry_murid__name_nilai.nilai_note_mp_id= '$mp_id'";
        $r = $db->query($q,2);
        Mold::both("nilai/graph", $r);  
    }     

    public function changeDateNote(){
        $note_id = (isset($_POST['note_id'])?addslashes($_POST['note_id']):die('Note ID empty'));
        $dateNoteBaru = (isset($_POST['dateNoteBaru'])?addslashes($_POST['dateNoteBaru']):die('dateNoteBaru ID empty'));
        $dateNoteBaru = date("Y-m-d", strtotime($dateNoteBaru));

        global $db;
        //Ydm
 
        $q = "UPDATE ry_murid__name_nilai SET name_nilai_date = '$dateNoteBaru' WHERE name_nilai_id = '$note_id'";
        $db->query($q,0);
    }
    
    public function guruNilai()
    {
        
        $ta = TahunAjaran::ta();
        $guru = new Guru();
        
        $guru->default_read_coloms = "*";
   
        $id = (isset($_GET['klsIDSelected'])?addslashes($_GET['klsIDSelected']):  $guru->getGuruTeachsFirstKelas($guru, $ta));        
        $kls = new Kelas();
        $kls->getByID($id);
           
        // kls tidak sama, milih subject 
        $mp_id = (isset($_GET['mpIDSelected'])?addslashes($_GET['mpIDSelected']): $guru->getGuruTeachsFirstMPID($guru, $ta));
        $isGuruTeachsMPID = $guru->isGuruTeachsMPbyID($guru, $ta, $id, $mp_id);
        
        if($isGuruTeachsMPID == false){
            $mp_id = $guru->getGuruTeachsFirstMPIDByKelas($guru, $ta, $id);
        }
        $mp = new Matapelajaran();
        $mp->getByID($mp_id);
 
        $murid = new Murid();
        $arrOfMurid = $murid->getMuridDiKelas($kls,$ta);
        ///cari note utk kelas ini di tahunajaran ini
        global $db; 
        $q = "SELECT * FROM ry_murid__name_nilai WHERE 
            nilai_note_kelas_id = '{$kls->kelas_id}'
            AND nilai_note_ta = '{$ta}'
            AND nilai_note_mp_id  = '{$mp->mp_id}' ORDER BY name_nilai_date ASC";
        $arrNote = $db->query($q,2);    
        
        foreach($arrNote as $note){
            $implodeNote[] = $note->name_nilai_id;
        }
        //pr($arrOfMurid);
        $imp = implode(",",$implodeNote);
        
        $q = "SELECT * FROM ry_murid__nilai WHERE nilai_note_id IN ($imp)";
        $arrNilai = $db->query($q,2);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['kls'] = $kls;   
        $return['kls_id'] = $id;  
        $return['mpIDSelected'] = $mp_id; 
        
        $return['mp'] = $mp; 
        $return['arrOfMurid'] = $arrOfMurid;
        $return['nilai'] = $nilai;
        $return['arrNote'] = $arrNote;
        $return['arrNilai'] = $arrNilai;
        $return['guru'] = $guru;
        //pr($return['nilai']);
      
        Mold::both("nilai/gurunilai", $return);
    }
}
