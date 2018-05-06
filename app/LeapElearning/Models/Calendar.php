<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendar
 *
 * @author User
 */
class Calendar extends Model {
    //my table name
    var $table_name = "ry_sekolah__calendar";
    var $main_id ="cal_id";
    
    var $default_read_coloms = "cal_id,cal_name,cal_mulai,cal_akhir,cal_warna,cal_ta_id,cal_type";
    
    var	$cal_id;	
    var	$cal_name;
    var	$cal_mulai;
    var	$cal_akhir;
    var	$cal_warna;
    var	$cal_ta_id;
    var	$cal_type;
    
    public $arrCl = array("awal"=>"#b6f7ad","holiday"=>"#9b5eff","event"=>"#fffd00","dues"=>"#ff7200","duesmurid"=>"#2b49ff","weekend"=>"#ffe4e4","exam"=>"#ff374b");

    
    public function getEffDay(){
        //get actual tahun ajaran        
        $ta = TahunAjaran::ta();
        //get 1st, 2nd and Last Days
        $arrFirstDays = $this->get1stDays($ta);
        //get Holidays
        $arrHolidays = $this->getHolidays($ta);
        //get Event and other activities
        $arrRestDays = $this->getEventAndStuffs($ta);
        
        //durchlaufen semua date dalam sebulan dan simpan di 2 array
        //1 array asal urut
        //1 array perbulan
        $completeArr = $this->satukanEffDay($arrFirstDays,$arrHolidays,$arrRestDays);
        return $completeArr;
        //pr($arrFirstDays);pr($arrHolidays);pr($arrRestDays);
    }
    public function get1stDays($ta){
        $whereClause = "cal_type = 'awal' AND cal_ta_id = '$ta'";
        $days = $this->getWhere($whereClause);
        
        return $days;
    }
    public function getHolidays($ta){
        
        $whereClause = "cal_type = 'holiday' AND cal_ta_id = '$ta' ORDER BY cal_mulai ASC";
        return $this->getWhere($whereClause);
    }
    public function getEventAndStuffs($ta){
        
        $whereClause = "cal_type != 'awal' AND cal_type != 'holiday' AND cal_ta_id = '$ta' ORDER BY cal_mulai ASC";
        return $this->getWhere($whereClause);
    }
   
    public function satukanEffDay($arrFirstDays,$arrHolidays,$arrRestDays){
        //get actual tahun ajaran        
        $ta = TahunAjaran::taInArray();
        $jul = TahunAjaran::$bulanMulaiTA;
        $jun = $jul-1;
        
        $returnArray = array();
        
        $returnArray = self::verteiltDatum($arrFirstDays, $returnArray);
        $returnArray = self::verteiltDatum($arrHolidays, $returnArray);
        $returnArray = self::verteiltDatum($arrRestDays, $returnArray);
        
       // pr($returnArray);
        
        
        $strDateFrom = $ta[0]."-0".$jul."-01"; 
        $strDateTo = $ta[1]."-0".$jun."-30"; 
        $arrAllDates = TahunAjaran::createDateRangeArray($strDateFrom, $strDateTo);
        
        //apakah weekend masuk??
        $arrWeekDay = array(1,2,3,4,5); //1 mon 5 fri
        if(Schoolsetting::apaSabtuMasuk())$arrWeekDay[] = 6;
        if(Schoolsetting::apaMingguMasuk())$arrWeekDay[] = 7;
        
        $newArr = array();
        $newArrBulanan = array();
        $cntEffDaySem = array(0,0,0,0,0);
        $cntTotalEffDay = 0;
        $semester = 0;
        $firstdayID = 0;
        $seconddayID = 0;
        $lastdayID = 0;
        foreach ($arrAllDates as $dtInMonth){
            $insertArr = array();
            $insertArr["type"] = array(); //set type as array
            $insertArr["eff"] = 0; //set eff day as 0
            // check kl ada firstdays di tanggal2 ini
            if(isset($returnArray[$dtInMonth])){
                $insertArr["activities"] = $returnArray[$dtInMonth];
                //masukan jenis harinya
                foreach ($returnArray[$dtInMonth] as $act){
                    if(strstr ($act->cal_id,"1stday")){                       
                        $insertArr["type"][] = "1stday";
                        $semester = 1;
                        $firstdayID = $act->cal_id;
                    }
                    if(strstr ($act->cal_id,"2ndday")){
                        $insertArr["type"][]= "2ndday";
                        $semester = 2;
                        $seconddayID = $act->cal_id;
                    }
                    if(strstr ($act->cal_id,"akhir")){
                        $insertArr["type"][] = "akhir";
                        $semester = 3;
                        $insertArr["eff"] = 1;
                        $lastdayID = $act->cal_id;
                    }
                    $insertArr["type"][] = $act->cal_type;
                }
            }

            
            
            //cari jenis hari
            list($tahun,$bulan,$hari) = explode("-", $dtInMonth);           
            $jenishari = date("N",mktime(0,0,0,$bulan,$hari,$tahun));
            $insertArr["jenishari"] = $jenishari;
            if(!in_array($jenishari, $arrWeekDay)){
                $insertArr["type"][] = "weekend";
            }
            
            
            //hitung counter
            if(in_array("holiday", $insertArr['type']) || in_array("weekend", $insertArr['type'])){
                
            }else{
                $cntEffDaySem[$semester]++;
                //$cntTotalEffDay++;
                if($semester>0&&$semester<3)
                $insertArr["eff"] = 1;
            }
            
            //cari bulanan
            $jenisbulan = date("n",mktime(0,0,0,$bulan,$hari,$tahun));
            $newArrBulanan[$jenisbulan][$dtInMonth] = $insertArr;
            
            //harian
            $newArr[$dtInMonth] = $insertArr;  
        }
        //totalnya di jumplah
        $cntTotalEffDay = $cntEffDaySem[1]+$cntEffDaySem[2];
        $newArr['TotalEffDay'] = $cntTotalEffDay;
        $newArr['EffDaySem'] = $cntEffDaySem;
        $newArr['EffDay1'] = $cntEffDaySem[1];
        $newArr['EffDay2'] = $cntEffDaySem[2];
        $arrAwal = array("first"=>$firstdayID,"second"=>$seconddayID,"akhir"=>$lastdayID);
        ksort($newArr);
        //pr($newArr);
        //pr($newArrBulanan);
        
        return array("harian"=>$newArr,"bulanan"=>$newArrBulanan,"awal"=>$arrAwal);
    }
    public static function verteiltDatum($arrZuVerteilen,$return=array()){
              
        foreach($arrZuVerteilen as $firstDays){
            
            $strDateFrom = $firstDays->cal_mulai; 
            $strDateTo = $firstDays->cal_akhir; 
            $arrAllDates = TahunAjaran::createDateRangeArray($strDateFrom, $strDateTo);
            foreach ($arrAllDates as $dates){
                $return[$dates][] = $firstDays;
            }
        }
        return$return;
    }
    public static function CekApakahLibur($arrAct){
        $arrType = array();
        foreach ($arrAct as $act){
            if($act->cal_type == "holiday")
                return 1;
        }
        return 0;
    }
    
    /*
     * constraint pas insert
     */
    public function constraints(){
        global $db; 
        //err id => err msg
        $err = array();
        //get action
        $act = (isset($_POST['act'])?$_POST['act']:'holiday');
        $load = (isset($_POST['load'])?$_POST['load']:0);
        //empty check
        if(!isset($this->cal_name))$err['cal_name'] = Lang::t('err cal_name empty');
        if(!isset($this->cal_mulai))$err['cal_mulai'] = Lang::t('err cal_mulai empty');
        if($act != "first" && $act != "second" &&   $act != "akhir"){
            if(!isset($this->cal_akhir))$err['cal_akhir'] = Lang::t('err cal_akhir empty');
        }        
        
        //cek date mulai, ambil TA dulu
        $ta = (isset($this->cal_ta_id)?$this->cal_ta_id:TahunAjaran::ta());
        $mulai = $this->cal_mulai;
        $akhir= $this->cal_akhir;
	list($tahunawal,$tahunakhir) = explode("/",$ta);
        
        //cek range
        $datemulai = new DateTime($mulai);
	$dateawal = new DateTime($tahunawal."-07-01");
	$dateakhir = new DateTime($tahunakhir."-06-31");       
        $myakhir = new DateTime($akhir);
        
        //cek if cal mulai di dalam range
        if($datemulai>$dateakhir || $datemulai<$dateawal){
            $err['cal_mulai'] = Lang::t('cal_mulai out of range');
        }
        
        //check if holiday
        if($act == 'holiday') {            
            if($datemulai>$myakhir || $myakhir>$dateakhir || $myakhir<$dateawal){
                $err['cal_akhir'] = Lang::t('cal_akhir out of range');        
            }
	}
        //secondday
        if($act == "second"){
            $firstid = "1stday_$ta";
            $q = "SELECT cal_mulai FROM {$this->table_name} WHERE cal_id = '$firstid'";
            $firstday = $db->query($q,1);
            if($firstday->cal_mulai != "0000-00-00"){
                $datefirst = new DateTime($firstday->cal_mulai);
                if($datefirst>$datemulai){
                    $err['cal_mulai'] = Lang::t('2nd day must be greater than 1st day');	
                }
            }
            else{
                $err['cal_mulai'] = Lang::t('1st day must be define first');			
            }		
	}
        //last day
        if($act == "akhir"){
            $firstid = "1stday_$ta";
            $q = "SELECT cal_mulai FROM {$this->table_name} WHERE cal_id = '$firstid'";
            $firstday = $db->query($q,1);
            if($firstday->cal_mulai != "0000-00-00" && isset($firstday->cal_mulai)){
                $datefirst = new DateTime($firstday->cal_mulai);
                if($datefirst>$datemulai){
                    $err['cal_mulai'] = Lang::t('Last day must be greater than 1st day');	
                }
                else{
                    $secondid = "2ndday_$ta";
                    $q = "SELECT cal_mulai FROM {$this->table_name} WHERE cal_id = '$secondid'";
                    $secondday = $db->query($q,1);
                    if($secondday->cal_mulai != "0000-00-00" && $secondday->cal_mulai != ""){
                        $datesecond = new DateTime($secondday->cal_mulai);
                        if($datemulai<$datesecond){
                        $err['cal_mulai'] = Lang::t('Last day must be greater than 2nd day');	
                        }
                    }
                    else{
                        $err['cal_mulai'] = Lang::t('2nd day must be define first');			
                    }
                }
            }
            else{
                $err['cal_mulai'] = Lang::t('1st day must be define first');			
            }		
	}
        
        //ganti id 
        if($act == "second"){
            $this->cal_id = "2ndday_$ta";
            $this->cal_warna = $this->arrCl["awal"];
            $this->cal_akhir = $this->cal_mulai;
        }
        else if($act == "akhir"){
            $this->cal_id = "akhir_$ta";
            $this->cal_warna = $this->arrCl["awal"];
            $this->cal_akhir = $this->cal_mulai;
        }
        else if($act == "first"){ 
            $this->cal_id = "1stday_$ta";
            $this->cal_warna = $this->arrCl["awal"];
            $this->cal_akhir = $this->cal_mulai;
        }
        else if($act == "holiday"){
            if(!$load){
            $this->cal_id = $mulai."_".$ta."_".time();
            $this->cal_warna = $this->arrCl[$act];
            }
        }
        
        return $err;
    }
    /*
     * overwrite form
     * disini cal_ta_id di overwrite
     */
    public function overwriteForm($return,$returnfull){
            $act = (isset($_GET['act'])?$_GET['act']:'holiday');
            //kalau ada yang tidak mau tampilkan bisa dengan type hidden
            $ta = (isset($this->cal_ta_id)?$this->cal_ta_id:TahunAjaran::ta());
            $return['cal_ta_id'] = new Leap\View\InputText("hidden", "cal_ta_id", "cal_ta_id", $ta);  
            $return['cal_name'] = new Leap\View\InputText("Text", "cal_name", "cal_name", $this->cal_name);
            
            //bagi ID untuk awal spy standard
            $cal_id = (isset($this->cal_id)?$this->cal_id:0);
            if($act == "first" && $cal_id == 0){
                $cal_id = "1stday_$ta";
            }
            if($act == "second" && $cal_id == 0){
                $cal_id = "2ndday_$ta";
            }
            if($act == "akhir" && $cal_id == 0){
                $cal_id = "akhir_$ta";
            }
            
           
            $return['cal_id'] = new Leap\View\InputText("hidden", "cal_id", "cal_id", $cal_id); 
            
            //masukan act utk dikirim dan di cek di constraint
            $return['act'] = new Leap\View\InputText("hidden", "act", "act", $act);
            
            //hitung cal_type dr arrCl
            foreach($this->arrCl as $type=>$color){
                if($act=="holiday" && $type == "awal")
                  continue;
                if($act!="holiday" && $type != "awal")
                  continue;
                $arrCType[$type] = Lang::t($type);
            }
            $return['cal_type'] = new Leap\View\InputSelect($arrCType,"cal_type", "cal_type",$this->cal_type);
                      
            $return['cal_warna'] = new Leap\View\InputText("hidden", "cal_warna", "cal_warna", $this->cal_warna);
            
            //set cal mulai and akhir as date
            if($act == "holiday" && isset($_GET['tglmulai'])){
                $this->cal_mulai = $_GET['tglmulai'];
                $this->cal_akhir = $this->cal_mulai;
            }
            
            $return['cal_mulai'] = new Leap\View\InputText("date", "cal_mulai", "cal_mulai", $this->cal_mulai);
            
            //kalau awal, cuman keluarkan 1 datum saja
            $cal_akhir_type = "date";
            if($act != "holiday"){
                $cal_akhir_type = "hidden";
                $this->cal_akhir = $this->cal_mulai;
               //$return['cal_akhir'] = new Leap\View\InputText($cal_akhir_type, "cal_akhir", "cal_akhir", $this->cal_mulai);     
            }
            else {
                $return['cal_akhir'] = new Leap\View\InputText($cal_akhir_type, "cal_akhir", "cal_akhir", $this->cal_akhir);     
            }  
//            pr($return);
            return $return;
    }
    /*
     * cari calendar dlm sebulan
     */
    function getCalinMonth($mid){
        global $db;
            
        $ta = TahunAjaran::ta();
            
        $q = "SELECT * FROM {$this->table_name} WHERE cal_type = 'holiday' AND cal_ta_id = '$ta' ORDER BY cal_mulai ASC";
            $holidays = $db->query($q,2);
                
            $q = "SELECT * FROM {$this->table_name} WHERE cal_type != 'awal' AND cal_type != 'holiday' AND cal_ta_id = '$ta' ORDER BY cal_mulai ASC";
            $events = $db->query($q,2);
            
            
            foreach($holidays as $h){
                    // cek if pindah bulan ... 
                    
                    $m = date("n",strtotime($h->cal_mulai));
                    $y1 = date("Y",strtotime($h->cal_mulai));
                    $m2 = date("n",strtotime($h->cal_akhir));
                    $y2 = date("Y",strtotime($h->cal_mulai));
                    $b1 = new DateTime($h->cal_mulai);
                    $b2 = new DateTime($h->cal_akhir);
                    $interval = $b1->diff($b2);
                  //  echo $h->cal_name;                    
                   // pr($interval);
                    
                    $bedabulan = $interval->m;
                    $bedahari = $interval->days;
                    
                    if($m!=$m2){
                        $pertama = clone $h;
                        $num_of_days_mulai = cal_days_in_month(CAL_GREGORIAN, $m, $y1);
                        $pertama->cal_akhir = date("Y-m-d",mktime(0,0,0,$m,$num_of_days_mulai,$y1));
                        $harrbegin[$h->cal_mulai] = $pertama;			
                         
                        $harrend[date("Y-m-d",mktime(0,0,0,$m,$num_of_days_mulai,$y1))] =$pertama;
                        $bedabulan++;
                        $holidaym[$m][] = $pertama;
                        $nextmon = array();
                        for($x=1;$x<=$bedabulan;$x++)
                        $nextmon[] = date("Y-n-d",strtotime(date("Y-m-d", mktime(0,0,0,$m,1,$y1)) . " +$x month"));
                        //pr($nextmon);
                        foreach ($nextmon as $num=> $nex){
                         //   echo $num; echo count($nextmon);
                             $kedua = clone $h;
                            // $kedua->cal_name = $kedua->cal_name.$nex;
                             list($yy,$ny,$dy) = explode("-",$nex);
                             
                             $kedua->cal_mulai = date("Y-m-d",mktime(0,0,0,$ny,1,$yy));
                             $num_of_days_mulai = cal_days_in_month(CAL_GREGORIAN, $ny, $yy); 
                             $harrbegin[date("Y-m-d",mktime(0,0,0,$ny,1,$yy))] = $kedua;
                             if($num < (count($nextmon)-1)){
                                 $kedua->cal_akhir = date("Y-m-d",mktime(0,0,0,$ny,$num_of_days_mulai,$yy));
                                $harrend[date("Y-m-d",mktime(0,0,0,$ny,$num_of_days_mulai,$yy))] = $kedua;
                             }
                             else{
                               //  $kedua->cal_akhir = date("Y-m-d",mktime(0,0,0,$ny,$num_of_days_mulai,$yy));
                                $harrend[$h->cal_akhir] = $kedua;  
                             }
                             $holidaym[$ny][] = $kedua;
                            // pr($kedua);
                        }
                    }
                    else{
                    /*if($m!=$m2){
                        // kalau beda tahun
                       if($y1!=$y2){ 
                           
                            
                       }
                       $num_of_days_mulai = cal_days_in_month(CAL_GREGORIAN, $m, $y1); 
                    }*/
                    
                    
			$harrbegin[$h->cal_mulai] = $h;
			$harrend[$h->cal_akhir] = $h;
			
			$holidaym[$m][] = $h;
			$datemulai = new DateTime($h->cal_mulai);
			/*if($datemulai<$date2){
				$holiday1[] = $h;
			}
			if($datemulai<$dateE){
				$holiday2[] = $h;
			}*/
                    }
			
		}
                
                $adakejadian = array();
                if(isset($holidaym[$mid]))
                foreach($holidaym[$mid] as $h){
                    $begin = new DateTime( $h->cal_mulai);
                    $end = new DateTime( $h->cal_akhir );
                    $end = $end->modify( '+1 day' ); 

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);

                    foreach($daterange as $date){
                       // echo $h->cal_name." hoho". $date->format("Ymd") . "<br>";
                        $adakejadian[$date->format("Y-m-d")][] = $h;
                        
                    }
                }
                foreach($events as $h){
                    //untuk semua event simpan dikejadian harian
                    $begin = new DateTime( $h->cal_mulai);
                    $end = new DateTime( $h->cal_akhir );
                    $end = $end->modify( '+1 day' ); 

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval ,$end);

                    foreach($daterange as $date){
                       // echo $h->cal_name." hoho". $date->format("Ymd") . "<br>";
                        $adakejadian[$date->format("Y-m-d")][] = $h;
                        
                    }
                     $m = date("n",strtotime($h->cal_mulai));
                    $holidaym[$m][] = $h;

		}
                return $adakejadian;
               // pr($adakejadian);
               // return $holidaym[$mid];
             //  pr($holidaym); 
          //  pr($holidays);
           // pr($events);
        }
        /*
         * getCalInmonnthOptimizesd
         */
    public function getCalInMonthOptimized($mon,$year){
            global $db;            
            $q="SELECT * FROM {$this->table_name} WHERE (YEAR(cal_mulai) = $year AND MONTH(cal_mulai) = $mon) OR (YEAR(cal_akhir) = $year AND MONTH(cal_akhir) = $mon) ORDER BY cal_mulai ASC";
            $muridkelas = $db->query($q,2);     
            $newMurid = array();
            $classname = get_called_class();
            foreach($muridkelas as $databasemurid){

                $m = new Calendar();                
                $m->fill(toRow($databasemurid));
                $newMurid[] = $m;
            }
            return $newMurid;
        }
        
    
   
}
