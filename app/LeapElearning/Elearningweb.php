<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Elearningweb
 *
 * @author User
 */
class Elearningweb extends WebService {
    
    public function quiz(){
        
        $ta = TahunAjaran::ta();      
        $guru = new Guru();
        $return['guru'] = $guru;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
   
       
       Mold::both("elearning/quiz_view_guru", $return);
    }
    public function matapelajaran(){
        pr($_SESSION);
        $klslevel = (isset($_GET['klslevel'])?addslashes($_GET['klslevel']):1);
        
        pr($klslevel);
        //$kls = new Kelas();
        //$kls->getByID($id);
        
        
        $mp = new Matapelajaran();
        $mp_id = (isset($_GET['mp_id'])?addslashes($_GET['mp_id']):die('MP ID empty'));
        
        $mp->getByID($mp_id);
        
        //get quizes
        $quiz = new Quiz();
        $whereClause = "quiz_guru_id = guru_id AND quiz_mp_id = '$mp_id' AND quiz_tingkatan = '$klslevel' ORDER BY quiz_create_date DESC";
        $arrTables = array("Guru");
        $arrQuiz = $quiz->getWhereFromMultipleTable($whereClause, $arrTables);

        //pr($arrQuiz);
        
        //get topicmaps
        $tm = new Topicmap();
        $whereClause = "tm_guru_id = guru_id AND tm_mp_id = '$mp_id'  AND tm_kelas_tingkatan  = '$klslevel' ORDER BY tm_updatedate DESC";
        $arrTables = array("Guru");
        $arrTM = $tm->getWhereFromMultipleTable($whereClause, $arrTables);
        //pr($arrTM);
        
        
        $return["mp"] = $mp;
        $return['kelas'] = $kls;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['klslevel'] = $klslevel;
        $return['arrQuiz'] = $arrQuiz;
        $return['arrTM'] = $arrTM;
        Mold::both("elearning/mp_profile", $return);
        //pr($mp);
    }
}
