<?php

/*
 * 
 * 
 * 
 */

/**
 * Description of SchoolWall
 *
 * @author User
 */
class SchoolWall extends Wall{
    public $table_name = "ry_sekolah__wall";
    public $main_id = "wall_id";
    
    var $default_read_coloms = "wall_id,wall_ta_id,wall_kelas_id,wall_from,wall_msg,wall_date,wall_files,wall_kls_ta,wall_role,wall_timestamp";
    
    public $wall_id;
    public $wall_ta_id;
    public $wall_kelas_id;
    public $wall_from;
    public $wall_msg;
    public $wall_date;
    public $wall_files;
    public $wall_kls_ta;
    public $wall_role;
    public $wall_update;
    public $wall_commentcount;
    
    var $coloumlist = "wall_id,wall_ta_id,wall_kelas_id,wall_from,wall_msg,wall_date,wall_files,wall_kls_ta,wall_role,wall_timestamp";
    /*
     * Alle Walls werden in einem Array gesammelt
     * Rueckgabe ist ein Array
     */
    public function getLatest($begin = 0,$limit = 20){
        global $db;
        $q = "SELECT * FROM {$this->table_name} ORDER BY wall_timestamp DESC LIMIT $begin,$limit";
        $muridkelas = $db->query($q,2);
        
        $newMurid = array();
        $classname = get_called_class();
        foreach($muridkelas as $databasemurid){
            
            $m = new SchoolWall();                
            $m->fill(toRow($databasemurid));
            $newMurid[] = $m;
        }
        return $newMurid;
    }
}
