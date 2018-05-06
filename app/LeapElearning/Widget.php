<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Widget
 *
 * @author User
 */
class Widget extends WebService{
    
    public function mySchoolCalendarWidget(){
        $mon = Absensi::getBulan();
        $year = Absensi::getTahun();
        $ta = TahunAjaran::ta();
        $calendar = new Calendar();
        $calthismonth = $calendar->getCalInMonthOptimized($mon,$year);
        
        
        //pr($calthismonth);
        //pr($calendar);
        $return['bln'] = $calthismonth;
        $return['calendar'] = $calendar;
        $return['mon'] = $mon;
        $return['year'] = $year;
        $return['refreshID'] = "mySchoolCalendarWidget";
        $return['ta'] = $ta;
        Mold::both("calendar/calendar_widget", $return);
    }
    public function myAbsensiWidget(){
        $murid = new Murid();
        $murid->default_read_coloms = "*";
        $murid->getByAccountID(Account::getMyID());
        
        $mon = Absensi::getBulan();
        $year = Absensi::getTahun();
        
        $abs = new Absensi();
        $murid->absensi = $abs->getAbsensiEinzel($murid->murid_id,$mon,$year);
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['murid'] = $murid;
        $return['absensi'] = $murid->absensi;
        $return['mon'] = $mon;
        $return['year'] = $year;
        $return['ta'] = TahunAjaran::ta();
        //ambil kejadian dlm bulan
        //$cal = new Calendar();
        //$return['calendar'] = $cal->getCalinMonth(Absensi::getBulan());
        $return['refreshID'] = "myAbsensiWidget";
        // get number of day dlm sebulan
        //$num_of_days = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
        //$return["numDays"] = $num_of_days;
        
        Mold::both("murid/absensi_widget",$return);
    }
    public function myHomeroomTeacher(){
        $ta = TahunAjaran::ta();
        $kelas = Account::getMyKelas($ta);
        
        $guru = new Guru();
        $row = $guru->getHomeroomFromKelas($ta, $kelas->kelas_id);
        $guru->getByID($row->guru_id);
        //$guru->fill(toRow($row));
        //pr($row);
        //pr($guru);
        Mold::both("leap/homeroom_widget", array("guru"=>$guru,"kelas"=>$kelas));
    }
}
