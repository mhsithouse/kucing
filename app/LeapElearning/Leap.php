<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Leap
 * Leap dan TopicMap adalah satu2nya WebApps dari leapsystem, controller yag lain adalah Webservice semuanya
 * @author Elroy Hardoyo
 */
class Leap extends WebApps{
    // leap elearning roles, can be different for different RBAC
    var $roles = array("admin","supervisor","tatausaha","guru","murid");
    // leap to load tab for different roles
    //GuruTab dihilangkan
    var $loadedDomains4Role = array(
        "admin"=>array("AdminTab","SchoolSetupTab","StudentSetupTab","SupervisorWallTab","InboxTab","SupervisorMuridTab"),
        "supervisor"=>array("SupervisorWallTab","SchoolSetupTab","StudentSetupTab","SupervisorMuridTab",
            //"eLearning", "Finance",
            "InboxTab"),
        "guru"=>array("GuruWallTab","SupervisorMuridTab",
            //"eLearningGuruTab",
            "InboxTab"),
        "tatausaha"=>array("StudentSetupTab","SupervisorMuridTab","InboxTab"),
        "murid"=>array("MuridTab","SupervisorMuridTab","InboxTab"),
        );
    
    var $domains = array(
        "AdminTab"=>array(
            "SupervisorAccManager"=>"Adminweb/supervisor",
            "AdminAccManager"=>"Adminweb/admin",
            "QuizManager"=>"Adminweb/quiz",
            "TopicmapManager"=>"Adminweb/topicmap"),
        "SchoolSetupTab"=>array(
            "EffDay"=>"Schoolsetup/getEffDay",
            //"MarcelTest"=>"marcel/hapusUpload2Datamurid",
            //"testTBS"=>"Thebodyshop/test",
            //"Hellow"=>"Leap/hello",
            "TableMengajar"=>"Schoolsetup/tablemengajar",
           // "TotalSession"=>"Schoolsetup/totalsession",
            "GuruAccManager"=>"Schoolsetup/guru",
            "SubjectManager"=>"Schoolsetup/matapelajaran",
            "KelasManager"=>"Schoolsetup/kelas",
            "TatausahaAccManager"=>"Schoolsetup/tatausaha",
            "SchoolsettingManager"=>"Schoolsetup/schoolsetting",
            "AccountManager"=>"Schoolsetup/account"
            
            ),
        "StudentSetupTab"=>array(
            "BagiKelas"=>"StudentSetup/bagikelas",
            //"NaikKelas"=>"StudentSetup/naikkelas",
            "AbsensiManager"=>"StudentSetup/absensi",
            "JadwalMP"=>"StudentSetup/Jadwalmatapelajaran2",
            "MuridAccManager"=>"StudentSetup/murid",
            "Nilai"=>"NilaiWeb/index"
		),
        "SupervisorWallTab"=>array(
            "AllClassWall"=>"Wallweb/all_class_wall",
            "Schoolwall"=>"Wallweb/schoolwall"),
        
        // Anfang Tab Guru
        "GuruWallTab"=>array(
            "MyClassWall"=>"Wallweb/all_class_wall",
            "Schoolwall"=>"Wallweb/schoolwall",
            "JadwalMP"=>"StudentSetup/Jadwalmatapelajaran2",
            "Nilai"=>"NilaiWeb/guruNilai",
	    "AbsensiManager"=>"StudentSetup/absensi"
            
            ),
        "GuruTab"=>array(
            "MySchedule"=>"GuruWeb/mySchedule",
            "MyeLearning"=>"GuruWeb/myElearning"),
        "eLearningGuruTab"=>array(
           "Quiz"=>"Elearningweb/quiz"
        ), // Ende Tab Guru
        
        // Anfang Tab Murid
        "MuridTab"=>array(
            "MyProfile"=>"MuridWeb/myProfile",
            "MyClassWall"=>"MuridWeb/myClassWall",
            "Schoolwall"=>"Wallweb/schoolwall",
            "MyCalendar"=>"MuridWeb/myCalendar",
            "MyJadwalMP"=>"MuridWeb/myJadwal",
            "MyAbsensi"=>"MuridWeb/myAbsensi",
            "MyClassmate"=>"MuridWeb/myClassmate",
             "MyGrad"=>"MuridWeb/MyGrad"
            //"MyMurideLearning"=>"MuridWeb/myElearning",
            //"MyGrade"=>"MuridWeb/myElearning",
            //"MyFinances"=>"MuridWeb/myFinances"
            ),
        
//         "eLearning"=>array(
//           "Quiz"=>"Elearningweb/quiz",
//           "Gudang"=>"Elearningweb/quiz",  
//           ),
        
         "Finance"=>array(
            "SPP"=>"Inboxweb/myinbox",
            "DPP"=>"Inboxweb/myinbox?cb=1",
            "LEAP"=>"Inboxweb/myinbox?cb=1",
            "School Bus"=>"Inboxweb/myinbox?cb=1",
            "DPP"=>"Inboxweb/myinbox?cb=1"    
            ),
        
        "InboxTab"=>array(
            "Inbox"=>"Inboxweb/myinbox"
            //,
            //"CommunicationBook"=>"Inboxweb/myinbox?cb=1"
            ),
        "SupervisorMuridTab"=>array(
            "BrowseMurid"=>"Studentsetup/browseStudent",
            "BrowseStaff"=>"Schoolsetup/browseStaff",
            "BrowseMP"=>"Studentsetup/browseMP"),
        "eLearningTab"=>array(
            "Matapelajaran"=>"elearningweb/myinbox",
            "TopicMap"=>"elearningweb/mycombook",
            "BikinSoal"=>"elearningweb/chat")
    );
    
    
    //put your code here
    function index(){
       //check apakah ada cookie untuk remember
       Auth::indexCheckRemember();
       if(Auth::isLogged()){ // kl sukses login pakai cookie
           //load school setting
            $ss = new Schoolsetting();
            $ss->loadToSession();
            
           Account::setRedirection();
       }
       //kalau tidak ada keluarkan loginform
       Mold::both("loginform");      
    }
    
    function login()
    {
        $username =  addslashes($_POST["admin_username"]);
        $password = addslashes($_POST["admin_password"]);
        $rememberme = (isset($_POST["rememberme"]) ? 1 : 0);
        $row = array("admin_username"=>$username,"admin_password"=>$password,"rememberme"=>$rememberme);
        //login pakai row credential
        Auth::login($row);
        //kalau sukses
        if(Auth::isLogged()){
            //load school setting
            $ss = new Schoolsetting();
            $ss->loadToSession();
            //redirect
            Account::setRedirection ();
        }
        else{
            Redirect::loginFailed();
        }        
    }
    
    function logout(){
        Auth::logout();
    }
    var $access_home = "murid";
    function home(){   
        $arrTabs =$this->loadedDomains4Role[Account::getMyRole()];
        $arrDomain = $this->domains;
        //mold ini masi ada logic dibelakangnya untuk first loadnya..
        //Mold::both("header",array("arrTabs"=>$arrTabs,"arrDomain"=>$arrDomain));
        //$st = new Schoolsetup();
        //$st->getEffDay();
        //Mold::both("timeline");
        ?>
<script type="text/javascript">
    $(document).ready(function(){
    openLw('Home','<?=_SPPATH;?>homeLoad','fade');
    });
</script>    
        <?
    }
    
    function homeLoad(){   
        //$arrTabs =$this->loadedDomains4Role[Account::getMyRole()];
        //$arrDomain = $this->domains;
        //mold ini masi ada logic dibelakangnya untuk first loadnya..
        //Mold::both("header",array("arrTabs"=>$arrTabs,"arrDomain"=>$arrDomain));
        //$st = new Schoolsetup();
        //$st->getEffDay();
        Mold::both("timeline");
        exit();
    }
    /*
     * fungsi utk print dan createFile lang empty
     */
    public function createLang(){
        global $db;
        $q = "SELECT * FROM ry_lang ORDER BY lang_ts ASC";
        $arr = $db->query($q,2);
        
        
        ///mulai write
        $myFile = "emptyLang.php";
        $fh = fopen($myFile, 'w') or die("can't open file");
        
        $str = "<?php \n";
        fwrite($fh, $str);
        //pr($arr);
        foreach($arr as $l){
            if($l->lang_id != ""){
                $str = '$_lang[\''.$l->lang_id.'\'] = "'.$l->lang_id.'";'." \n";
                fwrite($fh, $str);  
            }
            //$str .= '$_lang[\''.$l->lang_id.'\'] = "'.$l->lang_id.'";\n';
        }
        
       
       // fwrite($myfile, $str);
        
        //$stringData = $str;        
        //fwrite($fh, $stringData);
        fclose($fh);
        
    }
	public function replacePassword(){
		$acc = new Account();
		$arrAcc = $acc->getWhere("admin_id != 0");
		
		foreach($arrAcc as $ac){
			$ac->load = 1;
			$ac->admin_password  = "demo";
			$ac->save();
		}
		
	
	}
    
}
