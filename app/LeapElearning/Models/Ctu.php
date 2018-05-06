<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ctu
 *
 * @author User
 */
class Ctu extends Model {
    //put your code here
    
    public $table_name = "test__ctu";
    public $main_id = "ctu_number";
    //Default Coloms
    var $default_read_coloms = 'ctu_number,ctu_supplier_id';
    
     //allowed colom in database
    var $coloumlist = "ctu_number,ctu_supplier_id,ctu_item_array";
   
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
        
            $murid = new Murid();
            $arrMurid = $murid->getWhere("murid_id != 0");
            
            foreach($arrMurid as $m){
                $arrayBaru[$m->murid_id] = $m->nama_depan;
            }
            //kalau ada yang tidak mau tampilkan bisa dengan type hidden
            $return['ctu_supplier_id'] = new Leap\View\InputSelect($arrayBaru,"ctu_supplier_id", "ctu_supplier_id",$this->ctu_supplier_id);
           
            
            return $return;
    }
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if(!isset($this->ctu_item_array))$err['ctu_item_array'] = "Piye to ra mbok isi";
        if(!isset($this->ctu_number))$err['ctu_number'] = "Piye to ra mbok isi";
        return $err;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
            if(is_numeric($obj->ctu_supplier_id)){
                $murid = new Murid();
                $murid->getByID($obj->ctu_supplier_id);
                $obj->ctu_supplier_id = $murid->nama_depan;
            }
            
        }
        //pr($return);
        return $return;
    }
}
