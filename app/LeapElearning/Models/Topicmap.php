<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Topicmap
 *
 * @author User
 */
class Topicmap extends Model{
    public $table_name = "ry_topicmap__data"; // harus ada
    public $main_id = "topicmap_id";
    
    public $topicmap_id;
    public $tm_name;
    public $tm_mp_id;
    public $tm_guru_id;
    public $tm_kelas_tingkatan;
    public $tm_kelas_id;
    public $tm_create_date;
    public $tm_updatedate;
    public $tm_aktiv;
    public $tm_updateby_guru_id;
    public $tm_cc_stroke;
    public $tm_cc_stroke_width;
    public $tm_bg_url;
    public $tm_jml_el;
    
    var $default_read_coloms = "topicmap_id,tm_name,tm_mp_id,tm_guru_id,tm_kelas_tingkatan,tm_create_date,tm_updatedate,tm_aktiv,tm_jml_el";
    var $coloumlist = "topicmap_id,tm_name,tm_mp_id,tm_guru_id,tm_kelas_tingkatan,tm_create_date,tm_updatedate,tm_aktiv,tm_jml_el";
    
}
