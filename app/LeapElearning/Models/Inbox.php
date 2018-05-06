<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inbox
 *
 * @author User
 */
class Inbox extends Model {
     var $table_name = "ry_sekolah__inbox";
     var $main_id = "inbox_id";
     var $table_name_reply = "ry_sekolah__inbox_reply";
     
     public $inbox_id;
     public $inbox_from;
     public $inbox_to;
     public $inbox_judul;
     public $inbox_msg;
     public $inbox_read;
     public $inbox_giliran_read;
     public $inbox_createdate;
     public $inbox_replydate;
     public $inbox_pics;
     public $inbox_anzahlreply;
     public $inbox_noreply;
     public $inbox_changedate;
     public $inbox_type;
     
     var $default_read_coloms = "inbox_id,inbox_from,inbox_to,inbox_judul,inbox_read,inbox_msg";
     protected $searchColoms = "inbox_id,inbox_from,inbox_to,inbox_judul,inbox_read,inbox_msg,inbox_changedate,inbox_read,inbox_giliran_read,inbox_type,inbox_anzahlreply";
     /*
      * add notif di acc
      */
    function addInboxNotif($kepada,$inboxid,$inboxread){
        $account = new Account();
        $account->getByID($kepada);
        $account->load = 1;
        
        //ditambah kalau sudah di read
        if($inboxread)
        $account->admin_inbox++;
        
        $oldobj = array();  
        //create array for admin_inbox_update
        if(isset($account->admin_inbox_update) && $account->admin_inbox_update !=''){
            $oldobj = unserialize($account->admin_inbox_update);
        }        
        
        if(!in_array($inboxid, $oldobj)){
            $oldobj[] = $inboxid;
        }
        
        $account->admin_inbox_update = serialize($oldobj);
        $account->admin_inbox_timestamp = time();
        
        return $account->save();
    }
    
    /*
     * search
     */
    function search($word,$accid,$begin = 0 ,$limit = 20){
        
        global $db;
        $acc = new Account();
        $reply = new InboxReply();
              
           
      
       
       $q = "
        
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_from = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )
        UNION
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_to = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )        
        ORDER BY inbox_changedate DESC LIMIT $begin,$limit
     
        ";
        $arr = $db->query($q,2);
       // pr($arr);
       // echo $q;
        
        
        
        $newMurid = array();
        foreach($arr as $databasemurid){
            
            $m = new Inbox();                
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }
        
        
        //return jumlah totalnya
        
        $q = "        
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_from = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )
        UNION
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_to = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )                     
        ";
        $arr2 = $db->query($q,2);
        
        return array("arrMsg"=>$newMurid,"total"=>count($arr2));
        
        //die();
    }
    /*
     * search Commbook
     */
    /*
     * search
     */
    function searchCb($word,$accid,$begin = 0 ,$limit = 20){
        
        global $db;
        $acc = new Account();
        $reply = new InboxReply();
              
           
      
       
       $q = "
        
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_from = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND inbox_type = 'cb' AND 
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )
        UNION
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_to = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND inbox_type = 'cb' AND 
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )        
        ORDER BY inbox_changedate DESC LIMIT $begin,$limit
     
        ";
        $arr = $db->query($q,2);
       // pr($arr);
       // echo $q;
        
        
        
        $newMurid = array();
        foreach($arr as $databasemurid){
            
            $m = new Inbox();                
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }
        
        
        //return jumlah totalnya
        
        $q = "        
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_from = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND inbox_type = 'cb' AND 
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )
        UNION
        (SELECT {$this->searchColoms} FROM {$this->table_name} INNER JOIN {$acc->table_name}
        ON ({$this->table_name}.inbox_to = {$acc->table_name}.admin_id)
        WHERE
            (inbox_from = '$accid' OR inbox_to = '$accid') AND inbox_type = 'cb' AND 
            (inbox_judul LIKE '%$word%' OR inbox_msg LIKE '%$word%' OR admin_nama_depan LIKE '%$word%') 
        )                     
        ";
        $arr2 = $db->query($q,2);
        
        return array("arrMsg"=>$newMurid,"total"=>count($arr2));
        
        //die();
    }
    function fillEnvelope($jumlah = 5){
        $id = Account::getMyID();
        $begin = 0;
        $limit = $jumlah;
        $whereClause = "inbox_from = '$id' OR inbox_to = '$id' ORDER BY inbox_changedate DESC LIMIT $begin,$limit";        
        $arrMsg = $this->getWhere($whereClause);
        
        $myAcc = new Account();
        $myAcc->getByID($id);
        
        foreach($arrMsg as $obja){
            $data = new Account();
            if($id != $obja->inbox_to){
                //to                
                $data->getByID($obja->inbox_to);
            }
            
            if($id != $obja->inbox_from){
                //
                $data->getByID($obja->inbox_from);
            }
            $obja->data = $data;
            
            //ambil last conversations
            $reply = new InboxReply();
            $reply->getLastReply($obja->inbox_id);
            if(isset($reply->inbox_msg) && $reply->inbox_msg!=''){
                $obja->inbox_msg = $reply->inbox_msg; 
            }
        }    
        return array("arrMsg"=>$arrMsg,"myAcc"=>$myAcc,"id"=>$id);        
    }
    function setOld($inbox_id){
        $id = Account::getMyID();        
        $acc = new Account();
        $acc->getByID($id);
        $acc->load = 1;
        $acc->admin_inbox--;
        $oldobj = array();  
        //create array for admin_inbox_update
        if(isset($acc->admin_inbox_update) && $acc->admin_inbox_update !=''){
            $oldobj = unserialize($acc->admin_inbox_update);
        }
        foreach($oldobj as $num=>$ob){
            if($ob == $inbox_id)
                unset($oldobj[$num]);
        }                
        $acc->admin_inbox_update = serialize($oldobj);
        $acc->admin_inbox_timestamp = time();
        //if($acc->admin_inbox == 0)$acc->admin_inbox_update = 0;
        return $acc->save();           
    }

    function setRead($mid){
        global $db;
        $q = "UPDATE  {$this->table_name} SET inbox_read = '1' WHERE inbox_id = '$mid'";
        $sc = $db->query($q,0);            
        return $sc;       
    }
}
