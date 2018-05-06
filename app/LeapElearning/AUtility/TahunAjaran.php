<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TahunAjaran
 *
 * @author User
 */
class TahunAjaran {
    // Tahun Ajaran function
    public static $bulanMulaiTA = 7;
    
    public static function getTahunAjaran(){
        //kalau ada session
        if(isset($_SESSION['ta']))return $_SESSION['ta'];
        
        $nextyear  = date("Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
        $prevyear  = date("Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-1));
        if(date("n")>=self::$bulanMulaiTA){
            
            return date("Y")."/".$nextyear;
        }
        return $prevyear."/".date("Y");        
    }
    /*
     * cari pakai get kalau tidak ada pakai yang aktuel
     * @return ta
     */
    public static function ta(){
        $ta = (isset($_GET["ta"])?addslashes($_GET["ta"]):self::getTahunAjaran());
        $_SESSION['ta'] = $ta;
        return $_SESSION['ta'];
    }
    public static function taInArray(){
        $ta = self::ta();
        $exp = explode("/", $ta);
        return $exp;
    }
    public static function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }

    public static function fgetDay($day)
    {
        if($day == 1)
        {
            return Lang::t('Monday');
        }
        if($day == 2)
        {
            return Lang::t('Tuesday');
        }
        if($day == 3)
        {
            return Lang::t('Wednesday');
        }
        if($day == 4)
        {
            return Lang::t('Thursday');
        }
        if($day == 5)
        {
            return Lang::t('Friday');
        }        

    }    
    
     public static function getNextTahunAjaran(){
        $nextyear  = date("Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
        $prevyear  = date("Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")-1));
        if(date("n") < self::$bulanMulaiTA){
            return date("Y")."/".$nextyear;
        }    
    }
}
