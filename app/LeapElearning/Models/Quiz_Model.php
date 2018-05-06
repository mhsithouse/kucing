<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quiz
 *
 * @author User
 */
class Quiz_Model extends Model{
    public $table_name = "ry_quiz__data";
    public $main_id = "quiz_id";
    
    public $quiz_id;
    public $quiz_mp_id;
    public $quiz_guru_id;
    public $quiz_tingkatan;
    public $quiz_judul;
    public $quiz_type;
    public $quiz_create_date;
    
    var $default_read_coloms = "quiz_id,quiz_mp_id,quiz_guru_id,quiz_tingkatan,quiz_judul,quiz_type,quiz_create_date";
    var $coloumlist = "quiz_id,quiz_mp_id,quiz_guru_id,quiz_tingkatan,quiz_judul,quiz_type,quiz_create_date";
    
    var $mc_table ="ry_quiz__multiple";
    
    
}
