<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MuridWall
 *
 * @author User
 */
class MuridWall extends Wall{
     //my table name
    var $table_name = "ry_kelas__wall";
    var $main_id ="wall_id";
    
    var $default_read_coloms = "wall_id,wall_ta_id,wall_kelas_id,wall_from,wall_msg,wall_date,wall_files,wall_kls_ta,wall_role,wall_update,wall_commentcount";
    
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
}
