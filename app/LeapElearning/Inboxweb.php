<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inboxweb
 *
 * @author User
 */
class Inboxweb extends WebService{
    
    public function myinbox(){
        
        $id = Account::getMyID();
        $inbox = new Inbox();
        $begin = (isset($_GET['begin'])?addslashes($_GET['begin']):0);
        $limit = 10;
        
        $w = (isset($_GET['word'])?addslashes($_GET['word']):'');
        
        //search if commbook
        if(isset($_GET['cb'])){
            if($w != ''){
                $retArr = $inbox->searchCb($w,$id,$begin,$limit);
                $arrMsg = $retArr['arrMsg'];            
                $return['total'] = $retArr['total'];
            }
            else{
                $whereClause = "(inbox_from = '$id' OR inbox_to = '$id') AND inbox_type = 'cb' ORDER BY inbox_changedate DESC LIMIT $begin,$limit";        
                $arrMsg = $inbox->getWhere($whereClause);

                $clause = " (inbox_from = '$id' OR inbox_to = '$id') AND inbox_type = 'cb' ";
                $return['total'] = $inbox->getJumlah($clause);
            }
        }
        elseif(isset($_GET['search'])){ //get search word
            //sementara di off in
            
            //yg bs dicari nama_depan pengirim dan judul dan msg nya saja, 
            $retArr = $inbox->search($w,$id,$begin,$limit);
            $arrMsg = $retArr['arrMsg'];            
            $return['total'] = $retArr['total'];
        }
        else{
            $whereClause = "inbox_from = '$id' OR inbox_to = '$id' ORDER BY inbox_changedate DESC LIMIT $begin,$limit";        
            $arrMsg = $inbox->getWhere($whereClause);
            
            $clause = "inbox_from = '$id' OR inbox_to = '$id'";
            $return['total'] = $inbox->getJumlah($clause);
        
        }
        
        //ambil last reply
        foreach($arrMsg as $obja){
                       
            //ambil last conversations
            $reply = new InboxReply();
            $reply->getLastReply($obja->inbox_id);
            if(isset($reply->inbox_msg) && $reply->inbox_msg!=''){
                $obja->inbox_msg = $reply->inbox_msg; 
            }
        }   
        
        $return['limit'] = $limit;
        $return['begin'] = $begin;
        $return['arrMsg'] = $arrMsg;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['word'] = $w;
        $return['cb'] = (isset($_GET['cb'])?$_GET['cb']:0);
        Mold::both("inbox/myinbox", $return);
        //pr($arrMsg);
    }
    
    public function see(){
        $inbox_id = (isset($_GET['id'])?addslashes($_GET['id']):die('inbox id empty'));
        
        $begin = (isset($_GET['begin'])?addslashes($_GET['begin']):'0');
        $limit = 20;
        $all = 0; //for all
        $id = Account::getMyID();
        
        $inbox = new Inbox();
        $inbox->getByID($inbox_id);
        
        //set read utk inbox
        if($inbox->inbox_read == 0){
            if($inbox->inbox_giliran_read == $id){
                $inbox->setRead($inbox_id); // set read to 1
                $inbox->setOld($inbox_id); // set notification - 1
            }
        }
        
        
        $ir = new InboxReply();
        
        //ambil jumlah total
        $clause = " inbox_id = '$inbox_id' ";
        $return['total'] = $ir->getJumlah($clause);
        
        if($begin == "all"){
            $all = 1;
            $begin = $limit;
            $limit = $return['total']-$limit;
           // echo $return['total']. " " .$begin." ".$limit;
        }
        
        
        $whereClause = "inbox_id = '$inbox_id' ORDER BY inbox_createdate DESC LIMIT $begin,$limit";
        $arrReply = $ir->getWhere($whereClause);
        
        //set read 
        foreach($arrReply as $num=>$obja){                        
            if($obja->inbox_read == 0){
                if($inbox->inbox_giliran_read == $id){
                    //dicomment sementara roy.
                    $obja->setReadReply($obja->inbox_reply_id);                    
                }
            }
        }
        //pr($inbox);
        //pr($arrReply);
        
        $newArr[] = $inbox;
        if($all)$merge = array_reverse($arrReply);
        else $merge = array_merge($newArr, array_reverse($arrReply)); 
        
        //to
        $to = new Account();
        $to->getByID($inbox->inbox_to);
        //from
        $from = new Account();
        $from->getByID($inbox->inbox_from);
        
        
        
        
        $return['limit'] = $limit;
        $return['begin'] = $begin;
        
        $return['merge'] = $merge;
        $return['inbox'] = $inbox;
        $return['arrReply'] = $arrReply;
        $return['to'] = $to;
        $return['from'] = $from;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['id'] = $id;
        $return['all'] = $all;
        // get all di set jadi di return tanpa chatbox dan judul, isinya aja...
        if(isset($_GET['all']))$return['all'] = $_GET['all'];
        Mold::both("inbox/see", $return);
        
    }
    
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     * untuk mengisi calendar
     */
    public function inbox(){
        //create the model object
        $cal = new Inbox();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
    /*
     * Compose 
     */
    var $access_compose = "murid";
    public function compose(){
        
        $kelas = new Kelas();
        $arrKelas = $kelas->getWhere("kelas_aktiv = 1 ORDER BY kelas_id ASC", "kelas_id,kelas_name");
                      
        $guru = new Guru();
        $arrGuru = $guru->getWhere("guru_aktiv = 1 ORDER BY nama_depan ASC", "guru_id,account_id,nama_depan");
        
        $supervisor = new Supervisor();
        $arrSupervisor = $supervisor->getWhere("supervisor_aktiv = 1 ORDER BY nama_depan ASC", "supervisor_id,account_id,nama_depan");
        
        $tatausaha = new Tatausaha();
        $arrTU = $tatausaha->getWhere("tu_aktiv = 1 ORDER BY nama_depan ASC", "tu_aktiv,account_id,nama_depan");
        
        $admin = new Admin();
        $arrAdmin = $admin->getWhere("sys_aktiv = 1 ORDER BY nama_depan ASC", "sys_id,account_id,nama_depan");
        
        $t = time();
        
        $return['arrTU'] = $arrTU;
        $return['arrSupervisor'] = $arrSupervisor;
        $return['arrAdmin'] = $arrAdmin;
        $return['arrGuru'] = $arrGuru;
        $return['arrKelas'] = $arrKelas;
        $return['method'] = __FUNCTION__;
        $return['webClass'] = __CLASS__;
        $return['byID'] = 0;
        Mold::both("inbox/compose", $return);
        
    }
    /*
     * compose by ID
     */
    public function composeByID(){
        $acc_id = ((isset($_GET['acc_id'])?addslashes($_GET['acc_id']):die('ACC iD empty')));
        
        $acc = new Account();
        $acc->getByID($acc_id);
        
        $return['method'] = __FUNCTION__;
        $return['webClass'] = __CLASS__;
        $return['acc'] = $acc;
        $return['byID'] = 1;
        Mold::both("inbox/compose", $return);
    }
    function isikelas(){
        $id = addslashes($_GET['id']);
        if($id == "")die ();
        global $db;
        $ta = TahunAjaran::ta();
        
        $kelas = new Kelas();
        $kelas->getByID($id);
        
        $murid = new Murid();
        $arrMuridinClass = $murid->getMuridDiKelas($kelas,$ta);

        $t = time();
        
        $return['method'] = __FUNCTION__;
        $return['webClass'] = __CLASS__;
        $return['arrMuridinClass'] = $arrMuridinClass;
        $return['id'] = $id;
        $return['kelas'] = $kelas;
        Mold::both("inbox/isikelas", $return);
        
    }
    function sendMsg(){
        $json['bool']= 0;
        $json['err'] = "ok";
        $accid = addslashes($_POST['acc_id']);
        $judul = addslashes($_POST['judul']);
        $isi = addslashes($_POST['isi']);
        $emai = (isset($_POST['emai'])?addslashes($_POST['emai']):0);
        
        $type = (isset($_POST['type'])?addslashes($_POST['type']):"casual");
        if($accid == Account::getMyID())$json['err'] = Lang::t('Receipient ID error');
        if($accid=="")$json['err'] = Lang::t('Receipient ID empty');
        if($judul=="")$json['err'] = Lang::t('Message Title empty');
        if($isi=="")$json['err'] = Lang::t('Message Content empty');
        
        if($json['err']=="ok"){
            $in = new Inbox();
            $tgl = date("Y-m-d H:i:s");
            
            $in->inbox_from = Account::getMyID();
            $in->inbox_to = $accid;
            $in->inbox_giliran_read = $accid;
            $in->inbox_read = 0;
            $in->inbox_createdate = $tgl;
            $in->inbox_changedate = $tgl;
            $in->inbox_judul = $judul;
            $in->inbox_msg = $isi;
            $in->inbox_type = $type;
            $inboxid = $in->save();
            if($inboxid){                
               $json['bool']= $in->addInboxNotif($accid,$inboxid,1); // cek read didalamnya makanya dikasi val 0               
               //send mail
               if($emai){
                   $lem = new Leapmail();
                   if(!$lem->sendByID($accid, $judul, $isi)){
                       $json['err'] = Lang::t('Send Email Failed');
                   }
               }
            }
            else $json['err'] = Lang::t('Saving Failed');
        }
        echo json_encode($json);
    }
   
    function sendReplyMsg(){
        $json['bool']= 0;
        $json['err']= "ok";
        $accid = addslashes($_POST['acc_id']);
        $inboxid = addslashes($_POST['inboxid']);
        $isi = addslashes($_POST['isi']);
       // $emai = addslashes($_POST['emai']);
        
        if($accid=="")$json['err'] = Lang::t('lang_id_empty');
        if($inboxid=="")$json['err'] = Lang::t('lang_inbox_id_empty');
        if($isi=="")$json['err'] = Lang::t('lang_isi_empty');
        
        if($json['err']=="ok"){
            $in = new InboxReply();
            $tgl = date("Y-m-d H:i:s");
            
            $in->inbox_id = $inboxid;
            $in->inbox_to = $accid;
            $in->inbox_from = Account::getMyID();
            $in->inbox_msg = $isi;
            $in->inbox_createdate = $tgl;
            
            
            if($in->save()){
               //update inbox
                $inbox = new Inbox();
                $inbox->getByID($inboxid);
                $inbox->inbox_changedate = $tgl;
                $inbox->inbox_anzahlreply++;
                $inbox->load = 1;
                
                $inbox->addInboxNotif($accid,$inboxid,$inbox->inbox_read);//cek read didalamnya 
                
                if($inbox->inbox_read){
                    //update Notif                                      
                    $inbox->inbox_read = 0;
                }
                
                $inbox->inbox_giliran_read = $accid;
                $inbox->save();
                
                
                
                $json['bool']= 1;
            }
            else $json['err'] = Lang::t('lang_failed');
        }
        echo json_encode($json);
        exit();
    }
    /*
     * fillEnvelope($jumlah = 5)
     */
    public function fillEnvelope(){
        $inbox = new Inbox();
        $return = $inbox->fillEnvelope();
        $return['method'] = __FUNCTION__;
        $return['webClass'] = __CLASS__;
        Mold::both("inbox/fillEnvelope", $return);
    }
    
}
