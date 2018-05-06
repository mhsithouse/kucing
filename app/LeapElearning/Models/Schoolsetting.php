<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Schoolsetting
 *
 * @author User
 */
class Schoolsetting extends Model {
   //my table name
    var $table_name = "ry_sekolah__setting";
    var $main_id ="set_id";
    
    var $default_read_coloms = "set_id,set_name,set_value";
    
    var	$set_id;	
    var	$set_name;
    var	$set_value;
    
     //allowed colom in database
    var $coloumlist = "set_name,set_value";
    
    public static function apaSabtuMasuk(){
        if($_SESSION[get_called_class()]['weekend_saturday']=="false")return 0;
        else return 1;
    }
    public static function apaMingguMasuk(){
        if($_SESSION[get_called_class()]['weekend_sunday'] == "false")return 0;
        else return 1;
    }
    public static function getTingkatanMax(){
        return $_SESSION[get_called_class()]['tingkat'];
    }
    public static function getJamPelajaran(){
        return $_SESSION[get_called_class()]['jadwalkelas'];
    }
    public static function getJamIstirahat(){
        return $_SESSION[get_called_class()]['jamistirahat'];
    }
    public static function getJenisPembayaran(){
        return $_SESSION[get_called_class()]['jenis_pembayaran'];
    }
    public static function getPrincipalID(){
        return $_SESSION[get_called_class()]['principal SD'];
    }
    public static function getSchoolLogo(){
        return $_SESSION[get_called_class()]['SCHOOLLOGO'];
    }
    public static function getSchoolName(){
        return $_SESSION[get_called_class()]['SCHOOLNAME'];
    }

    public function loadToSession($whereClause = '',$selectedColom = "*"){
         global $db;
         $where = "";
         if($whereClause!='')$where = " WHERE ".$whereClause;
         $q ="SELECT {$selectedColom} FROM {$this->table_name} $where";
         $arr = $db->query($q,2);
         //pr($arr);
         foreach($arr as $ss){
            $_SESSION[get_called_class()][$ss->set_id] = $ss->set_value;
         }
         //pr($_SESSION);die();
     }
}
