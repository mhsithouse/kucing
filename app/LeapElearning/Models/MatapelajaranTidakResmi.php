<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatapelajaranTidakResmi
 *
 * @author EO
 */
class MatapelajaranTidakResmi extends Matapelajaran{
    //put your code here
    
    var $table_name = "ry_sekolah__matapelajaran_tdkresmi";
    var $main_id ="mptr_id";
    
    //Felder der Datenbank
    var $mptr_name;
    var $mptr_desr;
    var $mptr_color;
    
    public static function getMatapelajaranname($mptr_id){
       global $db;     
       $query = "SELECT mptr_name FROM ry_sekolah__matapelajaran_tdkresmi WHERE mptr_id = '$mptr_id'";      
       
       $resultMatapelajaran = $db->query($query,1);    
       return $resultMatapelajaran->mptr_name;
    } 
   
    public static function getMatapelajaranDescription($mptr_id){
       global $db;     
       $query = "SELECT mptr_desr FROM ry_sekolah__matapelajaran_tdkresmi WHERE mptr_id = '$mptr_id'";  
       $resultMatapelajaran = $db->query($query,1);    
       return $resultMatapelajaran->mptr_desr;
   } 
   
    public static function getMatapelajaranColor($mptr_id){
       global $db;     
       $query = "SELECT mptr_color FROM ry_sekolah__matapelajaran_tdkresmi WHERE mptr_id = '$mptr_id'";  
       $resultMatapelajaran = $db->query($query,1);    
       return $resultMatapelajaran->mptr_color;
   } 
}
