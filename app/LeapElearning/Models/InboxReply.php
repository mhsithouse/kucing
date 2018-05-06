<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InboxReply
 *
 * @author User
 */
class InboxReply extends Model {

     var $main_id = "inbox_reply_id";
     var $table_name = "ry_sekolah__inbox_reply";
     
     public $inbox_reply_id;
     public $inbox_id;
     public $inbox_from;
     public $inbox_to;
     public $inbox_judul;
     public $inbox_msg;
     public $inbox_read;
     public $inbox_createdate;
     public $inbox_pics;
     
     var $default_read_coloms = "inbox_reply_id,inbox_id,inbox_from,inbox_to,inbox_judul,inbox_read,inbox_msg";

     function setReadReply($mid){
       
        global $db;
        $q = "UPDATE  {$this->table_name} SET inbox_read = '1' WHERE inbox_reply_id = '$mid'";
        $sc = $db->query($q,0);            
        return $sc;       

    }
    /*
     * get Last Conversation if any
     */
    public function getLastReply($id){
        global $db;
        $q = "SELECT * FROM {$this->table_name} WHERE inbox_id = '$id' ORDER BY inbox_createdate DESC LIMIT 0,1";
        $obj = $db->query($q,1);
        $row = toRow($obj);
        $this->fill( $row );
    }
}
