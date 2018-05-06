<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatapelajaranResmi
 *
 * @author EO
 */
class MatapelajaranResmi extends Matapelajaran{
    //put your code here
   
    public static function getMatapelajaranname($mp_id){
       global $db;     
       $query = "SELECT mp_name FROM ry_sekolah__matapelajaran WHERE mp_id = '$mp_id'";      
       $resultMatapelajaran = $db->query($query,1);    
       return $resultMatapelajaran->mp_name;
    } 
   
    public static function getMatapelajaranSingkatan($mp_id){
       global $db;     
       $query = "SELECT mp_singkatan FROM ry_sekolah__matapelajaran WHERE mp_id = '$mp_id'";          
       $resultMatapelajaran = $db->query($query,1);    
       return $resultMatapelajaran->mp_singkatan;
   } 
}
