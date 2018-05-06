<?php
namespace Leap;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Leap\Utility\Db;
use Leap\View\Template;
use Leap\Utility\MobileDetect;
use Leap\Utility\Ausnahme;
use Leap\Control\WebService; // skip templating
use Leap\Control\Controller; // cek instance

/**
 * Description of InitLeap
 *
 * @author User
 */
class InitLeap 
{
    protected $db; // db object
    protected $params; // parameter yg dipisah pakai /
    protected $DbSetting;
    protected $WebSetting;
    protected $template;
    protected $mobileDetect;
    protected $hardwareType;
    protected $WebAppsNoAutoLoad; //class yang tidak di autoload foldernya, yang diload cuman Webapps dan webservice
    protected $timezone;
    protected $mainObj;
    protected $mainClass;
    protected $activeClass;
    protected $activeObj;
    
    protected $namespaceforApps = array();
    
    /*
     * Constructor
     */
    public function __construct($mainClass){       
       // $code =  "\$new = new ".$mainClass."();";eval($code);
       // $this->mainObj = $new;
        $this->mainClass = $mainClass;
       // $this->checkIfZugffrifAble($this->mainObj);
    }

    /*
     * Get and Set the DB
     */
    public function getDB(){
        return $this->db;
    }
    public function setDB($DbSetting){
        //init DB
        $this->DbSetting = $DbSetting;
        //Initialize DB
        $this->db = new Db($this->DbSetting);        
    }
    /*
     * Get and Set the Template
     */
    public function getTemplate(){
        return $this->template;
    }
    public function setTemplate($WebSetting){
         $this->WebSetting = $WebSetting;
         $this->template = new Template($this->WebSetting); 
    }
    /*
     *  Get and Set Web Parameter to a $_GET parameter
     *  see leap .htaccess
     */
    public function getParams(){
        return $this->params;
    }
    public function setParams(){
        //get URL and Location
        $_GET["url"] = addslashes($_GET["url"]);
        $realparams = explode("?",$_GET["url"]);
        if(count($realparams)>1)
        $this->getGET($realparams[1]);
        $this->params = explode("/",$realparams[0]);               
    }
    /*
     *  Check if hardware mobile,tablet or desktop
     */
    public function setHardwareType(){
        //get Mobile parameter
        $this->mobileDetect = new MobileDetect();
        
        if($this->mobileDetect->isMobile()){            
            if(!$this->mobileDetect->isTablet()){
                $this->hardwareType = "mobile";                              
            }
            else{
                $this->hardwareType = "tablet";
            } 
        }else{
            $this->hardwareType = "desktop";
        }
    }
    public function getHardwareType(){
        return $this->hardwareType;
    }
    /*
     * timezone
     */
    public function setTimezone($timezone){
        //set timezone
        $this->timezone = $timezone;
        date_default_timezone_set($timezone);
    }
    public function getTimezone(){
        return $this->timezone;
    }
    /*
     *  setGlobal Variables using Leap Standard Websetting
     */
    public function setGlobalVariables($WebSetting){
        //set PATH
        define('_SPPATH',$WebSetting['folder']);
        define('_BPATH', "http://".$WebSetting['domain'].$WebSetting['folder']);
        //comment this for multiple static path
        //define('_PHOTOPATH',$WebSetting['photopath']);
        //define('_PHOTOURL',$WebSetting['photourl']);
        define('_THEMEPATH',$WebSetting['themepath']);   
    }
    /*
     * Set name spaces for createRunObject function
     */
    public function setNameSpacesForApps($ns){
        $this->namespaceforApps = $ns;
    }
    /*
     * set Main Obj
     */
    public function setMainObj($mainClass){
         $code =  "\$new = new ".$mainClass."();";eval($code);
         $this->mainObj = $new;
         $this->mainClass = $mainClass;
         $this->checkIfZugffrifAble($this->mainObj);
    }
    protected function checkIfZugffrifAble($obj){
        if(!($obj instanceof Controller)){
                Ausnahme::notFound();
        }
    }
    
    public function createRunObject(){
        
        $params = $this->params;  
           
        //kalau index classname = $mainclass
        if(!isset($params[0]) || $params[0] == "index"){
            $this->activeClass = $this->mainClass;
            $this->activeObj = $this->mainObj;
            $this->params[1] = "index";
            $this->params[0] = $this->mainClass;            
        }
        if(!isset($params[1])){            
            $this->params[1] = $params[0];
            $this->params[0] = $this->mainClass;
            $this->activeClass = $this->mainClass;
            $this->activeObj = $this->mainObj;            
        }
        //set classname
        $classname =  ucwords($this->params[0]);
        //echo $classname;
        foreach($this->namespaceforApps as $ns){
            $nsClassname = $ns.$classname; 
            //echo $nsClassname;
            if(class_exists($nsClassname)){
                //echo "exist".$nsClassname;
                $code =  "\$new = new ".$nsClassname."();";eval($code);
                $this->activeObj = $new;
                $this->activeClass = $nsClassname;
                break;
            }
        }

    }
    protected function checkRBAC(){
        //check access variable
        $gabungan = "access_".$this->params[1];
        $bcheck = "";
        if(isset($this->activeObj->$gabungan)){
            $bcheck = $this->activeObj->$gabungan;
        }                        
        if($bcheck != "all" && $bcheck != ""){
            \Auth::checkRole($bcheck);
        }
    }

    protected function checkIfMethodExists(){
        // kalo method nya ada
        if(method_exists($this->activeObj,$this->params[1])){           
            $this->checkRBAC();
            //kalau lolos checkrole kerjakan
            return 1;
        }
        else Ausnahme::notFound();
    }

    public function run(){
        //create if run object exist
        $this->createRunObject();
        if(isset($this->activeObj)){
            $this->checkIfZugffrifAble($this->activeObj);
            $this->checkIfMethodExists();
            
            //implode arguments as array
            $arrgs = array();
            $cnt = 0;
            foreach($this->params as $p){
                    if($cnt>1)
                    $arrgs[] = $p;
                    $cnt++;
            }
            //define str variable here
            $new = $this->activeObj;
            $code =  "\$str = \$new->".$this->params[1]."(\$arrgs);";
            ob_start();
            eval($code);
            $str = ob_get_contents();
            ob_end_clean();
        }else{
            Ausnahme::notFound();
        }
                       
        //Kalau dia webservice lgs di die, tanpa template
        if($new instanceof WebService){
            die($str);
        }
        //no error , print to template
        if(!isset($str))$str = ' <!-- empty -->';
        $this->template->printHTML($str);
        //return $this->insert2Theme($location, $arr)$str;       
        
   }
    
   protected function getGET($str){
        if($str == "")return 0;
        $exp = explode("&",$str);
        foreach($exp as $nv){
                $exp2 = explode("=",$nv);
                $_GET[$exp2[0]] = $exp2[1];
            }
    }
   /*
    *  Check if session already started
    */
   protected function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    } 
}
