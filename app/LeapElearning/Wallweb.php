<?php
/**
 * Description of Wallweb
 *
 * @author Elroy Hardoyo
 */
class Wallweb extends WebService {
    public $limit = 20;
    public $newFor = 1; //1 day
    /*
     * fungsi all class wall with class selector
     */
    public function all_class_wall($cmd = ""){
        //define ta
        $ta = TahunAjaran::ta();
        //define kelas_id        
        $kelas_id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):1);
        $begin = (isset($_GET['begin'])?addslashes($_GET['begin']):0);
        //untuk view murid
        
        
        $return = $this->getKelasWall($kelas_id,$ta,$begin);
        
        $return['kelas_id'] = $kelas_id;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['muridview'] = (isset($_GET['muridview'])?addslashes($_GET['muridview']):0);
        $return['newFor'] = $this->newFor;
        $return['cmd'] = $cmd;
        Mold::both("wall/all_class_wall", $return);
        //pr($arrWall);
    }
    /*
     * fungsi enzelne kelas wall
     */
    public function getKelasWall($kelas_id,$ta,$begin = 0,$filter = "all"){
        
        $kelas = new Kelas();
        $kelas->getByID($kelas_id);
        $limit = $this->limit;
        
        $wall = new MuridWall();
        //set filter
        $filtext = '';
        if($filter != "all")$filtext = " AND wall_role = '$filter' ";
        
        $whereClause = "wall_kelas_id = '$kelas_id' AND wall_ta_id = '$ta' $filtext ORDER BY wall_update DESC LIMIT $begin,$limit";
        $selectedColom = "wall_id,wall_from,wall_msg,wall_date,wall_commentcount,wall_role,wall_update";
        $arrWall = $wall->getWhere($whereClause, $selectedColom);
        
        //get account
        foreach($arrWall as $m){
            //account
            $acc = new Account();
            $acc->getByID($m->wall_from);
            $m->acc = $acc;
            
            //foto
            $target = "kelaswall___" . $m->wall_id;
            $foto = new Fotoajax();
            $arrFoto = $foto->getWhere("photo_target_id = '$target' ORDER BY photo_date DESC");
            $m->foto = $arrFoto;
            
            //last reply
            /*
            $wr = new MuridWallComment();
            $wr->getLastCommentByID($m->wall_id);
                        
            if(isset($wr->cid_admin_id)){
                $accComment = new Account();
                $accComment->getByID($wr->cid_admin_id);
                $wr->acc = $accComment;
            }           
            $m->lastComment = $wr;
             * 
             */
        }
        
        $return['kelas_id'] = $kelas_id;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['arrWall'] = $arrWall;
        $return['kelas'] = $kelas;
        $return['ta'] = $ta;
        $return['filter'] = $filter;
        $return['begin'] = $begin;
        return $return;
    }
    /*
     * fungsi get kls wall next
     */
    public function getKelasWallNext(){
        //define ta
        $ta = TahunAjaran::ta();
        //define kelas_id        
        $kelas_id = (isset($_GET['klsid'])?addslashes($_GET['klsid']):1);
        $begin = (isset($_GET['begin'])?addslashes($_GET['begin']):0);
        $filter = (isset($_GET['filter'])?addslashes($_GET['filter']):'all');
        
        
        $return = $this->getKelasWall($kelas_id,$ta,$begin,$filter);
        
        $return['kelas_id'] = $kelas_id;
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        
        //pr($return);
        
        foreach($return['arrWall'] as $m){
            Mold::both("wall/einzel_post", array("m"=>$m,"typ"=>"kelas","klsid"=>$kelas_id));     
        }
        if(count($return['arrWall'])<1){
            die("no");
        }
        //Mold::both("wall/getKelasWallNext", $return);
    }
    /*
     * getSchool wall
     */
    public function getSchoolWall($begin = 0,$limit = 10){
        //define ta
        $ta = TahunAjaran::ta();
        //schoolwall
        $wall = new SchoolWall();
        $arrWall = $wall->getLatest($begin,$limit);
       
        //get account
        foreach($arrWall as $m){
            
            $acc = new Account();
            // Holt die ID vom Posten
            $acc->getByID($m->wall_from);
            //pr($acc->getByID($m->wall_from));
            $m->acc = $acc;
            
            $target = "kelaswall___" . $m->wall_id;
            $foto = new Fotoajax();
            $arrFoto = $foto->getWhere("photo_target_id = '$target' ORDER BY photo_date DESC");
            
            $m->foto = $arrFoto;
        }
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['arrWall'] = $arrWall;
        $return['ta'] = $ta;
        
        return $return;
    }
    /*
     * schoolwall
     */
    public function schoolwall($noPost=0){
        
        //define ta
        $ta = TahunAjaran::ta();
        $begin = 0;
        $limit = $this->limit;
        $return = $this->getSchoolWall($begin,$limit);
        
        //return
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return['noPost'] = $noPost;
        $return['newFor'] = $this->newFor;
        Mold::both("wall/school_wall", $return);
                
    }
    /*
     * schoolwallNext
     */
    public function schoolwallNext(){
        //define ta
        $ta = TahunAjaran::ta();
        //define begin
        $begin = (isset($_GET['begin'])?addslashes($_GET['begin']):0);
        $limit = $this->limit;
        $return = $this->getSchoolWall($begin,$limit);
        
        //return
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        
        foreach($return['arrWall'] as $m){
            Mold::both("wall/einzel_post", array("m"=>$m,"typ"=>"school","klsid"=>""));     
        }
        if(count($return['arrWall'])<1){
            die("no");
        }
    }
    /*
     * compose wall yang di get
     * typ : kelas, school
     * kl kelas ada klsid
     */
    public function composewall(){
        $ta = TahunAjaran::ta();
        
        $typ = (isset($_GET['typ'])?addslashes($_GET['typ']):'');
        $klsid = (isset($_GET['klsid'])?addslashes($_GET['klsid']):'');
        $cmd = (isset($_GET['cmd'])?addslashes($_GET['cmd']):'form');
        
        if($typ == "")die('Type must be defined');
        if($typ == "kelas" && $klsid == "")die("Kelas must be defined");
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        
        
        if($cmd == "form"){
            $return["typ"] = $typ;
            $return["klsid"] = $klsid;
            $return['id'] = Wall::createID();
            Mold::both("wall/compose", $return);
        }
        if($cmd == "add"){
            $json['bool'] = 0;
            $json['err'] = '';
            
            if(isset($_POST['wall_msg']))$wall_msg = trim(rtrim ($_POST['wall_msg']));
            if($wall_msg == '')    
                $json['err'] .= Lang::t('Message is empty');
            
            $id = (isset($_GET['id'])?addslashes($_GET['id']):'');
            if($id=='')$json['err'] .= Lang::t('Id is empty');
            
            if($json['err']==''){
                //$wall_msg = addslashes(strip_tags(trim(rtrim ($_POST['wall_msg'])),'<p><a><br><b><i><img><hr>'));
                // am 01.10.2014,insert <embed><iframe> vom Efindi
                $wall_msg = (strip_tags(trim(rtrim ($_POST['wall_msg'])),'<p><a><br><b><i><img><hr><embed><iframe>'));
                if($typ == "kelas"){
                    $wall = new MuridWall();
                    $wall->wall_id =  $id;
                    $wall->wall_msg = $wall_msg;
                    $wall->wall_from = Account::getMyIDwithCheck();
                    $wall->wall_kelas_id = $klsid;
                    $wall->wall_role = Account::getMyRole();
                    $wall->wall_ta_id = $ta;
                    $tgl = Wall::getDateTime();
                    $wall->wall_date = $tgl;
                    $wall->wall_update = $tgl;
                    $json['bool'] = $wall->save();
                }
                if($typ == "school"){
                    $wall2 = new SchoolWall();
                    $wall2->wall_id =  $id;
                    $wall2->wall_msg = $wall_msg;
                    $wall2->wall_from = Account::getMyIDwithCheck();
                    $wall2->wall_role = Account::getMyRole();
                    //Auth::checkRole ("supervisor");
                    $wall2->wall_kls_ta = "school";
                    $tgl = Wall::getDateTime();
                    $wall2->wall_date = $tgl;
                  //  echo "in";
                  //  die($wall_msg);
                    $json['bool'] = $wall2->save();
                }
            }
            die(json_encode($json));            
        }
    }
    /*
     * viewcomment
     */
    public function viewcomment(){
        $ta = TahunAjaran::ta();
        $wid = (isset($_GET['wid'])?addslashes($_GET['wid']):'');
        $klsid = (isset($_GET['klsid'])?addslashes($_GET['klsid']):'');
        $typ = (isset($_GET['typ'])?addslashes($_GET['typ']):'');
        $cmd = (isset($_GET['cmd'])?addslashes($_GET['cmd']):'view');
        
        $return['webClass'] = __CLASS__;
        $return['method'] = __FUNCTION__;
        $return['ta'] = $ta;
        $return["klsid"] = $klsid;
        
        if($cmd == "form"){
            $return["typ"] = $typ;
            $return['id'] = $wid;
            $return['mode'] = "viewcomment";
            Mold::both("wall/compose", $return);
            die();
        }
        
        if($cmd == "add"){
            $json['bool'] = 0;
            $json['err'] = '';
            //pr($_POST);
            if(isset($_POST['wall_msg']))$wall_msg = trim(rtrim ($_POST['wall_msg']));
            if($wall_msg == '')    
                $json['err'] .= Lang::t('Message is empty');
            
            $id = (isset($_GET['id'])?addslashes($_GET['id']):'');
            if($id=='')$json['err'] .= Lang::t('Id is empty');
            
            if($json['err']==''){
                // am 01.10.2014,insert <embed><iframe> vom Efindi
                //$wall_msg = addslashes(strip_tags(trim(rtrim ($_POST['wall_msg'])),'<p><a><br><b><i><img><hr>'));
                $wall_msg = (strip_tags(trim(rtrim ($_POST['wall_msg'])),'<p><a><br><b><i><img><hr><embed><iframe>'));
                if($typ == "kelas"){
                    $wall = new MuridWallComment();
                    $wall->wid =  $id;
                    $wall->cid_admin_nama = Account::getMyName();
                    $wall->cid_admin_foto = Account::getMyFoto();
                    $wall->cid_admin_id = Account::getMyID();
                    //create date
                    $tgl = Wall::getDateTime();
                    $wall->c_date = $tgl;
                    $wall->c_text = $wall_msg;                  
                    $json['bool'] = $wall->save();
                    
                    if($json['bool']){
                        
                        $wall2 = new MuridWall();
                        $wall2->getByID($id);
                        $wall2->wall_commentcount++;
                        $wall2->wall_update = $tgl;
                        $wall2->load = 1; //spy update
                        $json['bool'] = $wall2->save();
                       
                    }
                }                
            }
            die(json_encode($json));            
        }
        
        if($cmd == "view"){
            $mwc = new MuridWallComment();

            $whereClause = "wid = '$wid' ORDER BY c_date DESC";
            $arrComment = $mwc->getWhere($whereClause);

            $wall = new MuridWall();
            $wall->getByID($wid); 
            $acc = new Account();
            $acc->getByID($wall->wall_from);
            $wall->acc = $acc;


            $target = "kelaswall___" . $wall->wall_id;
            $foto = new Fotoajax();
            $arrFoto = $foto->getWhere("photo_target_id = '$target' ORDER BY photo_date DESC");
            $wall->foto = $arrFoto; 


            $return['wall'] = $wall;
            $return['mwc'] = $arrComment;

            Mold::both("wall/viewcomment", $return);
        
        }
    }
    /*
     * delete
     */
    public function delete(){
        $wid = (isset($_POST['id'])?addslashes($_POST['id']):'');
        $typ = (isset($_POST['typ'])?addslashes($_POST['typ']):'');
        
        if($wid == "")die('ID empty');
        if($typ == '')die('Type empty');
        
        $json['bool'] = 0;
                
        if($typ == "kelas"){
            $wallmurid = new MuridWall();
            
        }
        if($typ == "school"){
            $wallmurid = new SchoolWall();            
        }
        //load
        $wallmurid->getByID($wid);
        
        if($wallmurid->wall_from == Account::getMyID()){
            $json['bool'] = $wallmurid->delete($wid);
        }
        else{
            $json['err'] = Lang::t('Not Authorize');
        }
        
        die(json_encode($json));
    }
    /*
     * commentdelete
     */
    public function commentdelete(){
        $wid = (isset($_POST['id'])?addslashes($_POST['id']):'');

        
        if($wid == "")die('ID empty');

        
        $json['bool'] = 0;
                
        $wallmurid = new MuridWallComment();
        //load
        $wallmurid->getByID($wid);
        
        if($wallmurid->cid_admin_id == Account::getMyID()){
            
            $json['bool'] = $wallmurid->delete($wid);
            
            if($json['bool']){
                $wall = new MuridWall();
                $wall->getByID($wallmurid->wid);
                $wall->wall_commentcount--;
                $wall->load = 1;
                $tgl = Wall::getDateTime();
                $wall->wall_update = $tgl;
                $json['bool'] = $wall->save();
            }
        }
        else{
            $json['err'] = Lang::t('Not Authorize');
        }
        
        die(json_encode($json));
    }
    
    
}
