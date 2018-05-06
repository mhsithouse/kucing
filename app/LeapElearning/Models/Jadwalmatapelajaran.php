<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jadwalmatapelajaran
 *
 * @author EO
 */
class Jadwalmatapelajaran extends Model{
    //put your code here
    var $table_name = "ry_sekolah__jadwalmp";   
    var $main_id = "jw_id";
   
    // Felder in der Datenbank
    var $jw_kelas_id;
    var $jw_mp_id;
    var $jw_slot_id;
    var $jw_mulai;
    var $jw_end;
    var $jw_ta_id;
    var $jw_hari_id;
    var $jw_type;
    

    protected $slotmatapelajaran;
    public $matapelajaran;
    public $arrayVonKelastingkatan;
    public $kelas_id;
    protected $tahunajaran;
    public $anzahlSchultag;
    protected $guruMengajar;
    public $jadwalMPType;
    // utk mengambil mata pelajaran pada Hari
    public $hari;
    // Table Data guru
   // var $table_dataguru = 
   public function __construct($kelas_id, $tahunajaran, $jadwalMPType, $hari)
    {
        $this->slotmatapelajaran = self::getSlotJamMatapelajaran();
        $this->arrayVonKelastingkatan = Kelas::getAktiveKlasse();        
        $this->anzahlSchultag = self::getAnzahlSchultag();
        $this->kelas_id = $kelas_id;
      
        $this->tahunajaran = $tahunajaran;
        $this->matapelajaran = array();
        $this->jadwalMPType = $jadwalMPType;
        $this->hari = $hari;
        //pr( $this->arrayVonKelastingkatan);
   }
   
   public function init(){
       
        $kls = new Kelas();
        $kls->getByID($this->kelas_id);
        //echo $this->kelas_id;
        //pr($kls);
        
        if($this->jadwalMPType =="Full"){
            
            for($slotID = 0;$slotID<sizeof($this->slotmatapelajaran) - 1; $slotID++)
            {   
                for($hariID=1; $hariID<=$this->anzahlSchultag; $hariID++)
                {  
                    for($klsTingkatanID = 0; $klsTingkatanID<sizeof($this->arrayVonKelastingkatan);$klsTingkatanID++)
                    {   
                        $mp_help = $this->getJadwalMatapelajaranNachTagundSlot($klsTingkatanID + 1, $this->tahunajaran, $hariID, $slotID);                
                        $this->matapelajaran[$this->slotmatapelajaran[$slotID] . " - " . $this->slotmatapelajaran[$slotID + 1]][$hariID] [$this->arrayVonKelastingkatan[$klsTingkatanID]->kelas_name ] =$mp_help;   
                     }
                 }
            }          
        }
        if($this->jadwalMPType =="Weekly")
            { 
               
                for($slotID = 0;$slotID<sizeof($this->slotmatapelajaran)-1; $slotID++)
                {
                     for($hariID=1; $hariID<=$this->anzahlSchultag; $hariID++)
                     {
                         $mp_help = $this->getJadwalMatapelajaranNachTagundSlot($this->kelas_id, $this->tahunajaran, $hariID, $slotID);
                         //pr($mp_help);
                         $this->matapelajaran[$this->slotmatapelajaran[$slotID] . " - " . $this->slotmatapelajaran[$slotID + 1]][$hariID] [$kls->kelas_name] =$mp_help;  
                     }  
                }
            }
           
        if($this->jadwalMPType =="Daily")
        {
            for($slotID = 0;$slotID<sizeof($this->slotmatapelajaran) - 1; $slotID++)
            {
                $mp_help = $this->getJadwalMatapelajaranNachTagundSlot($this->kelas_id, $this->tahunajaran, $this->hari, $slotID);
                $this->matapelajaran[$this->slotmatapelajaran[$slotID] . " - " . $this->slotmatapelajaran[$slotID + 1]] =$mp_help;  
            }
           
        }
        // Hier wird es die Singkatan dari Matapelajaran Resmi dan tidak Resmi ermittelt
        if($this->jadwalMPType !="Daily"){
             foreach($this->matapelajaran as $obj1=>$slot)
             {
                foreach($slot as $obj2=>$hari)
                {
                    foreach($hari as $obj3=>$kelas)
                    {
                        foreach($kelas as $mp)
                        {
                            if($mp->jw_type == "mptr")
                            {
                                $mp->namaMatapelajaran = MatapelajaranTidakResmi::getMatapelajaranDescription($mp->jw_mp_id);
                            }
                            else
                            {
                                $mp->namaMatapelajaran = MatapelajaranResmi::getMatapelajaranSingkatan($mp->jw_mp_id);
                                $mp->guruMengajar = new Gurumengajar($mp->jw_mp_id,$mp->jw_kelas_id, $mp->jw_ta_id );
                                $guruID =  $mp->guruMengajar->getGuruId();                        
                                $mp->guru = new Guru();
                                // Hol alle Eigenschaften von Guru
                                $mp->guru->getByID($guruID->mj_guru_id);
                            }
                        }
                    } 
                }
             }            
        }
         else
         {
             foreach($this->matapelajaran as $obj1=>$slot)
             {
                 foreach($slot as $mp)
                 {
                    if($mp->jw_type == "mptr")
                    {
                        $mp->namaMatapelajaran = MatapelajaranTidakResmi::getMatapelajaranDescription($mp->jw_mp_id);
                    }
                    else
                    {
                        $mp->namaMatapelajaran = MatapelajaranResmi::getMatapelajaranSingkatan($mp->jw_mp_id);
                        $mp->guruMengajar = new Gurumengajar($mp->jw_mp_id,$mp->jw_kelas_id, $mp->jw_ta_id );
                        $guruID =  $mp->guruMengajar->getGuruId();                        
                        $mp->guru = new Guru();
                        // Hol alle Eigenschaften von Guru
                        $mp->guru->getByID($guruID->mj_guru_id);
                    }                     
                 }
             }    
         }
         //pr($this->matapelajaran);
         //pr( $this->arrayVonKelastingkatan);
       return $this->matapelajaran;
   }


   public function getJadwalMatapelajaranNachTagundSlot($kls,$ta, $tag, $slotID)
   {
         global $db;
         if($kls== "")
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta' AND  jw_slot_id = '$slotID' ORDER BY jw_hari_id ASC, jw_slot_id ASC";
         }
         // Schulplan nach Klasse
         else
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta' AND jw_kelas_id='$kls' AND jw_hari_id = '$tag'  AND  jw_slot_id = '$slotID'ORDER BY jw_slot_id ASC";
         }
         $resultMatapelajaran = $db->query($q,2);  
         return $resultMatapelajaran;
    }
    
   public function getJadwalMatapelajaranNachTag($kls,$ta, $tag){
         global $db;
        
         if($kls== "")
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta' ORDER BY jw_hari_id ASC, jw_slot_id ASC";
         }
         // Schulplan nach Klasse
         else
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta' AND jw_kelas_id='$kls' AND jw_hari_id = '$tag' ORDER BY jw_slot_id ASC";
         }
         echo $q;
         echo "<br>";
         $resultMatapelajaran = $db->query($q,2);   
         return $resultMatapelajaran;
       
    }
    /*
     * 
     */
    
    public function getJadwalMatapelajaranID($kls,$ta){
         global $db;
         // Selektieren alle Schulplan
         if($kls == "all")
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta'";
         }
         // Schulplan nach Klasse
         else
         {
             $q = "SELECT * FROM ry_sekolah__jadwalmp WHERE jw_ta_id ='$ta' AND jw_kelas_id='$kls'";
         }
         $resultMatapelajaran = $db->query($q,2);
         return $resultMatapelajaran;
     }

    public function getMatapelajaranSingkatan($arrOfJadwalMP){
        
    }     
    public function getMatapelajaran($arrOfJadwalMP){
        foreach($arrOfJadwalMP as $obj)
        {
            if(Matapelajaran::istMPResmi($obj->jw_type))
            {
                $mp_singkatan = MatapelajaranResmi::getMatapelajaranSingkatan($obj->jw_mp_id);
            }
            else
            {
                $mp_singkatan = MatapelajaranTidakResmi::getMatapelajaranname($obj->jw_mp_id);
            }
            
           //echo $mp_singkatan . "<br>";
        }
        return $arrOfJadwalMP;
    }
    
    public function getGuruLehrt($mpID, $kelas, $tahunajaran){
        
        $guruMengajar = new Gurumengajar($mpID, $kelas, $tahunajaran);
        
        
        
        
    }


 
    
    public  static function getSlotJamMatapelajaran(){
        $arrjdwlkelas = explode(",",$_SESSION['Schoolsetting']['jadwalkelas']);
        return $arrjdwlkelas;
    }
    public static function getAnzahlSchultag(){
     
        return self::getLastschoolday();
    }

    public static function getLastschoolday(){
       //ambil get 
       $endday = 5; // smp jumat masuknya
       if($_SESSION['ss']['weekend_saturday'] == "true")$endday = 6; 
       if($_SESSION['ss']['weekend_sunday'] == "true")$endday = 7;
       return $endday;
    }
   

}
