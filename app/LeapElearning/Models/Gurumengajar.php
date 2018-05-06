<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gurumengajar
 *
 * @author EO
 */
class Gurumengajar extends Model{
    //put your code here
    var $table_name = "ry_guru__mengajar";
    var $main_id = "mj_guru_id";
    var $default_read_coloms = "mengajar_id, mj_mp_id, mj_ta_id, mj_kelas_id, mj_jam";
    //connected table name, name can be changed, not connected to other
    protected $mj_mp_id;
    protected $mj_kelas_id;
    protected $mj_ta_id;
    
    //protected $m
    
    public function __construct($mpID, $kelas, $tahunajaran) {
        $this->mj_mp_id = $mpID;
        $this->mj_kelas_id = $kelas ;
        $this->mj_ta_id= $tahunajaran;
       
    }
    
    public function getGuruId(){
        global $db;
        $q = "SELECT mj_guru_id FROM {$this->table_name} WHERE mj_mp_id = '{$this->mj_mp_id}' AND mj_kelas_id = '{$this->mj_kelas_id}' AND mj_ta_id = '{$this->mj_ta_id}'";               
        $resultGuruID = $db->query($q,1); 
        return $resultGuruID;    
    }       

    public static function getMyLehrtMPID($guruID, $ta, $kelas_id){
        global $db;
        $q = "SELECT mj_mp_id FROM ry_guru__mengajar WHERE mj_guru_id = '$guruID' AND mj_kelas_id = '$kelas_id' AND mj_ta_id = '$ta'";               
        $resulMPID = $db->query($q,1);
        
        return $resulMPID;
        
		}
}