<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adminweb
 *
 * @author User
 */
class Adminweb extends WebService{
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function supervisor(){
        //create the model object
        $gr = new Supervisor();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($gr,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function admin(){
        //create the model object
        $gr = new Admin();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($gr,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function quiz(){
        //create the model object
        $gr = new Quiz();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($gr,$webClass);

    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function topicmap(){
        //create the model object
        $gr = new Topicmap();
        //send the webclass 
        $webClass = __CLASS__;
        
        //run the crud utility
        Crud::run($gr,$webClass);

    }
}
