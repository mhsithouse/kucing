<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nilai
 *
 * @author EO
 */
class Nilai extends Model{
    //put your code here
    
    var $table_name = "ry_murid__nilaiulangan";
    var $main_id ="nilai_id";
    var $default_read_coloms = "murid_id,mp_id,nilai, tgl_ujian, jenis_ujian, ta";
    var $coloumlist= "kelas_id,kelas_name,kelas_tingkatan,kelas_foto,kelas_aktiv";
    
    public $tahunAjaran;
    public $murid;
    public $matapelajaran;
    protected $matapelajaranID;
    public $tanggalUjian;
    public $jenisUjian;
    public $kelas_id;
    public $arrayTanggalUjian;
    public $arrayNilai;
    protected $namaMatapelajaran;




    public function __construct($tahunAjaran, $murid, $matapelajaranID, $kelas_id) 
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->murid = $murid;
        $this->matapelajaranID = $matapelajaranID;
        $this->kelas_id = $kelas_id;
        $this->namaMatapelajaran = MatapelajaranResmi::getMatapelajaranname($this->matapelajaranID);
    }
    
    public function getNilaiKelasSortNachDatum()
    {
        $this->arrayTanggalUjian = $this->getTanggalUjianNachKelasID($this->kelas_id,$this->matapelajaranID, $this->tahunAjaran);
        for($i = 0; $i < count($this->murid); $i++)
        {
            $nama_depan = $this->murid[$i]->admin_nama_depan;
            for($j = 0; $j <count($this->arrayTanggalUjian); $j++)
            {
                $tgl_ujian =  $this->arrayTanggalUjian[$j]->tgl_ujian ;
                $this->arrayNilai[$nama_depan][$tgl_ujian] =  $this->getNilaiByTanggal_Kelas_MuridID($this->murid[$i]->murid_id, $this->kelas_id, $this->matapelajaranID, $this->arrayTanggalUjian[$j]->tgl_ujian, $this->tahunAjaran);
            }
        }
    }   
    
    public function getMyNilai()
    {   
        $this->arrayTanggalUjian = $this->getTanggalUjianNachKelasID($this->kelas_id,$this->matapelajaranID, $this->tahunAjaran);
        for($j = 0; $j <count($this->arrayTanggalUjian); $j++)
        {
            $tgl_ujian =  $this->arrayTanggalUjian[$j]->tgl_ujian ;
            $this->arrayNilai[$this->murid->nama_depan][$tgl_ujian] =  $this->getNilaiByTanggal_Kelas_MuridID($this->murid->murid_id, $this->kelas_id, $this->matapelajaranID, $this->arrayTanggalUjian[$j]->tgl_ujian, $this->tahunAjaran);
        }
    }
    
    public function getTanggalUjianNachKelasID($kelas_id, $matapelajaranID, $tahunajaran)
    {
        global $db;
        $q = "SELECT DISTINCT  tgl_ujian FROM {$this->table_name} WHERE kelas_id='$kelas_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' ORDER BY tgl_ujian ASC ";
        $arrTanngalUjian = $db->query($q,2);  
        return $arrTanngalUjian;  
    }
    
    public function getTanggalUjianNachMuridID($murid_id, $matapelajaranID, $tahunajaran)
    {
        global $db;
        $q = "SELECT DISTINCT  tgl_ujian FROM {$this->table_name} WHERE murid_id='$murid_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' ORDER BY tgl_ujian ASC ";
        $arrTanngalUjian = $db->query($q,2);  
        return $arrTanngalUjian;        
    }

    public function getNilaiByTanggalAndKelas($kelas_id, $matapelajaranID, $tanggalUlangan, $tahunajaran)
    {  
        global $db;
        $q = "SELECT * FROM ry_murid__nilaiulangan WHERE kelas_id='$kelas_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' AND tgl_ujian = '$tanggalUlangan' ORDER BY tgl_ujian ASC ";
        $resultNilai = $db->query($q,2);  
        return $resultNilai;        
    }
    
    public function getNilaiByTanggal_Kelas_MuridID($murid_id, $kelas_id, $matapelajaranID, $tanggalUlangan, $tahunajaran)
    {  
        global $db;
        $q = "SELECT * FROM ry_murid__nilaiulangan WHERE murid_id='$murid_id' AND kelas_id='$kelas_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' AND tgl_ujian = '$tanggalUlangan' ORDER BY tgl_ujian ASC ";
        //echo $q . "<br>";
        $resultNilai = $db->query($q,2);  
        return $resultNilai;        
    }
    
    public function getNilaiByKelas($kelas_id, $matapelajaranID, $tahunajaran)
    {  
        global $db;
        $q = "SELECT tgl_ujian FROM {$this->table_name} WHERE kelas_id='$kelas_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' ORDER BY tgl_ujian ASC ";
        $resultNilai = $db->query($q,2);  
        return $resultNilai;        
    }

    public function getNilaiByMuridID($murid_id, $matapelajaranID, $tahunajaran)
    {  
        global $db;
        $q = "SELECT * FROM {$this->table_name} WHERE murid_id = '$murid_id' AND ta = '$tahunajaran' AND mp_id = '$matapelajaranID' ORDER BY tgl_ujian ASC ";
        $resultNilai = $db->query($q,2);  
        return $resultNilai;        
    }
    
    public function insertTanggalUjian($murid_id,  $matapelajaranID, $nilai, $tglUjian, $jenisUjian, $tahunajaran, $kelas_id)
    {
        echo $tglUjian;
        global $db;
        $q = "INSERT INTO {$this->table_name}  (murid_id, mp_id, nilai, tgl_ujian,  jenis_ujian, ta,kelas_id) VALUES ('$murid_id',  '$matapelajaranID', '$nilai', '$tglUjian', '$jenisUjian', '$tahunajaran', '$kelas_id' )";
      //  echo $q;
        $insertNilai = $db->query($q,2);  
        //echo  $insertNilai;        
    }
    
    public  function getNilaiNachSubject($murid_id, $matapelajaran_id, $tahunajaran)
    {
        global $db;
        $q_nilai = "SELECT * FROM ry_murid__nilaiulangan WHERE mp_id='$matapelajaran_id' AND murid_id='$murid_id' AND ta='$tahunajaran' ORDER BY tgl_ujian ASC";               
        $r_nilai = $db->query($q_nilai, 2);
        return $r_nilai;
    }
}
