<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Webworker
 *
 * @author User
 */
class Webworker extends WebService {
    function pull(){
        $json['bool']= 1;
        //$time_start = microtime(true);
        global $db;
        $json['inbox'] = 0;
        // infinite loop until the data file is not modified

        //$currentmodif = $this->haveNew();
        $acc = new Account();
        $acc->getByID(Account::getMyID());
        
        
        /*  while ($currentmodif < 1) // check if the data file has been modified
        {
          usleep(100000); // sleep 10ms to unload the CPU
          clearstatcache();
          $currentmodif = $this->haveNew();
        }*/
        $json['totalmsg'] = $acc->admin_inbox;
        $json['updateArr'] = unserialize($acc->admin_inbox_update);
        $json['timestamp'] = $acc->admin_inbox_timestamp;
        echo json_encode($json);
        
        //echo $currentmodif;
        
    }
    function haveNew(){
        $acc = new Account();
        $acc->getByID(Account::getMyID());
        return $acc->admin_inbox;            
    }
}
