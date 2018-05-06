<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MuridWallComment
 *
 * @author User
 */
class MuridWallComment extends Model {
    public $table_name = "ry_kelas__wallcomment";
    public $main_id = "cid";
    
    public $cid;
    public $cid_admin_nama;
    public $wid;
    public $c_date;
    public $cid_admin_id;
    public $cid_admin_foto;
    public $c_text;
    
    public $default_read_coloms = "cid,cid_admin_nama,wid,c_date,cid_admin_id,cid_admin_foto,c_text";
   
    /*
     * getLastCommentByID
     */
    public function getLastCommentByID($wid){
        global $db;
        $q = "SELECT {$this->default_read_coloms} FROM {$this->table_name} WHERE wid = '$wid' ORDER BY c_date DESC LIMIT 0,1";
        $obj = $db->query($q,1);            
        $this->fill(toRow($obj));
    }
}
