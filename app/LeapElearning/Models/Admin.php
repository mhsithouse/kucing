<?php

/*
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */
/**
 * Description of AdminController
 *
 * @author User
 */
class Admin extends ModelAccount {
    var $table_name = "ry_sysadmin__data";
    var $main_id = "sys_id";
    var $default_read_coloms = "sys_id,account_id,sys_aktiv";
     //connected table name, name can be changed, not connected to other
    var $linked_table_name = "sp_admin_account"; 
    
    
    var $sys_id;
    var $account_id;
    var $sys_aktiv;
    
   
    
}
