<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Absensi
 *
 * @author User
 */
class Absensi extends Model {
    public $table_name = "ry_murid__absen";
    public $main_id = "id";
    public $arrMacamAbsen = array(0=>"Absen",1=>"Masuk",2=>"Libur",3=>"Ijin",4=>"Weekend");
    
    public function getAbsensi($arrOfMurid){
        $mon = self::getBulan();
        $year = self::getTahun();
        $return['mon'] = $mon;
        $return['year'] = $year;
        $dateObj   = DateTime::createFromFormat('!m', $mon);
        $monthName = $dateObj->format('F');
        $return['monname'] = $monthName;
        // get number of day dlm sebulan
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
        $return["numDays"] = $num_of_days;
        //pr($mon); pr($year);
        //pr($arrOfMurid);
        global $db;
        
        foreach($arrOfMurid as $m){            
            $mid = $m->{$m->main_id};            
            $m->absensi = $this->getAbsensiEinzel($mid,$mon,$year);
        }
        $return["objs"] = $arrOfMurid;
        return $return;
    }
    /*
     * get absensiEinzel
     */
    public function getAbsensiEinzel($mid,$mon,$year){
        //untuk penyimpanan tiiap murid
            $absreturn = array();
            
            global $db;
            
            $q = "SELECT absensi,hari FROM {$this->table_name} WHERE bulan = '$mon' AND tahun = '$year' AND murid_id = '{$mid}'";
            $ct = $db->query($q,2);
            $absreturn['objs'] = $ct;
            
            
            $hari = array();
            //abs0 = absen
            $abs0 = 0; $abs1 =0; $abs2=0; $abs3=0; $abs4 = 0;
            foreach($ct as $c){
                    if($c->absensi == "0")$abs0++;
                    if($c->absensi == "1")$abs1++;
                    if($c->absensi == "2")$abs2++;
                    if($c->absensi == "3")$abs3++;	
                    if($c->absensi == "4")$abs4++;	
                    $hari[$c->hari] = $c->absensi;
            }
            
            $absreturn[$this->arrMacamAbsen[0]] = $abs0;
            $absreturn[$this->arrMacamAbsen[1]] = $abs1;
            $absreturn[$this->arrMacamAbsen[2]] = $abs2;
            $absreturn[$this->arrMacamAbsen[3]] = $abs3;
            $absreturn[$this->arrMacamAbsen[4]] = $abs4;
            $absreturn["hari"] = $hari;
            
            return $absreturn;
    }

    public static function getBulan(){
       //ambil get 
       $bulan = (isset($_GET['mon'])?addslashes($_GET['mon']):date("n"));
       return $bulan;
    }
    public static function getTahun(){
       //ambil get 
       $bulan = (isset($_GET['year'])?addslashes($_GET['year']):date("Y"));
       return $bulan;
    }
}
