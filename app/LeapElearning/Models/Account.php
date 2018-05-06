<?php
/**
 * Description of Account
 * Account manages user login account
 * @author Elroy Hardoyo
 */
class Account extends Model {
    
    //Nama Table
    public $table_name = "sp_admin_account";  
    
    //Primary
    var $main_id = 'admin_id';
    
    //Default Coloms
    var $default_read_coloms = 'admin_id,admin_username,admin_password';
    
    var $rememberme;
    var $role2role_table = "sp_role2role";
    var $role2acc_table = "sp_role2account";
    
    /*
     *  Colom di Database
     */
    var $admin_id;
    var $admin_username;
    var $admin_password;
    var $admin_lastupdate;
    var $admin_ip;
    var $admin_aktiv;
    var $admin_email;
    var $admin_inbox;
    var $admin_nama_depan;
    var $admin_nama_belakang;
    var $admin_foto;
    var $admin_role;
    var $admin_inbox_update;
    var $admin_inbox_timestamp;
    var $print = 1;
    /*
     * Role Based Access Control
     */
    var $roles = array();
    
    //allowed colom in database
    var $coloumlist = "admin_username,admin_password,admin_lastupdate,admin_aktiv,admin_email";
    
    public static function getMyName(){
        $name = (isset($_SESSION['account']->admin_nama_depan)?$_SESSION['account']->admin_nama_depan:"Please Login");
        return $name;
    }

    public static function getMyFoto(){
        $name = (isset($_SESSION['account']->admin_foto)?$_SESSION['account']->admin_foto:"");
        if($name == "foto" || $name == "")return _SPPATH."images/noimage.jpg";
        return _PHOTOURL.$name;
    }
    public static function getMyRole(){
        $name = (isset($_SESSION['account']->admin_role)?$_SESSION['account']->admin_role:"No");
        return $name;       
    }
    public static function getMyID(){
        $name = (isset($_SESSION['account']->admin_id)?$_SESSION['account']->admin_id:0);
        return $name;
    }
    public static function getMyUsername(){
        $name = (isset($_SESSION['account']->admin_username)?$_SESSION['account']->admin_username:0);
        return $name;
    }
    public static function getMyPassword(){
        $name = (isset($_SESSION['account']->admin_password)?$_SESSION['account']->admin_password:0);
        return $name;
    }
    public static function getMyIDwithCheck(){
        $name = self::getMyID();
        if($name == 0)die('Login First');
        return $name;
    }
    public static function getMyLastUpdate(){
        $name = (isset($_SESSION['account']->admin_lastupdate)?$_SESSION['account']->admin_lastupdate:"long time ago");
        return $name;       
    }
    public static function getMyKelas($ta){
        $kelas = (isset($_SESSION['myKelas'.$ta]->kelas_id)?$_SESSION['myKelas'.$ta]:'no');
        if($kelas == 'no'){
            //kalau belum punya kelas
            $murid = new Murid();
            $murid->default_read_coloms = "murid_id,nama_depan,foto";
            $murid->getByAccountID(Account::getMyID());
            $kelas = $murid->getMyKelas($ta);
            $_SESSION['myKelas'.$ta] = $kelas;
        }
        return $kelas;       
    }
    /*
     * get name
     */
    public function getName() {
        return $this->admin_nama_depan;
    }

    public function loadByUserLogin() {
    	//get parameters
        $username =  $this->admin_username;
        $password = $this->admin_password;
        $rememberme = $this->rememberme;
        
        //checksyarat
        if(!isset($username)||!isset($password))Redirect::loginFailed ();
        
        //load from db
        global $db;
        $sql = "SELECT * FROM {$this->table_name} WHERE admin_username = '$username' AND admin_password = '$password' AND admin_aktiv = 1 ";  
        $obj = $db->query($sql,1);
        
        $row = toRow($obj);
                
        $this->fill( $row );
        
        if(isset($this->admin_id)){
            $_SESSION["admin_session"] = 1;
            $_SESSION["account"] = $obj;
            //Update setlastlogin
            return self::setLastUpdate($_SESSION["account"]->admin_id);           
        }
        else return 0;
    }
    /*
     * Update lastupdate
     */
    public static function setLastUpdate($id){
        if(!isset($id)) die('Id empty setLastLogin');
        global $db;
        $acc = new Account();
        $sql = "UPDATE {$acc->table_name} SET admin_lastupdate =now(),admin_ip = '".$_SERVER["REMOTE_ADDR"]."' WHERE admin_id = '{$id}'";
        return $db->query($sql,0);
    }
    /*
     * insert New Role get called in modelaccount
     */
    public function insertNewRole(){
       global $db;
       $q = "INSERT INTO {$this->role2acc_table} SET "
       . "role_admin_id = '{$this->admin_id}', "
       . "role_id = '{$this->admin_role}', "
       . "account_username = '{$this->admin_username}'";
       return $db->query($q,0);
    }
    /*
     * delete role
     */
    public function deleteRole($id){
        if(!isset($id))return 0;
        else{
            if($id<0)return 0;
            if($id=='')return 0;
        }
        global $db;
        $q = "DELETE FROM {$this->role2acc_table} WHERE role_admin_id = '$id'";
        //echo $q;
        return $db->query($q,0);
    }
    /*
     * Load role, called in auth
     */
    public function loadRole(){
        global $db;
        $sql = "SELECT * FROM {$this->role2acc_table} WHERE role_admin_id = '{$this->admin_id}'";
        $role2acc = $db->query($sql,2);
        $_SESSION["roles"] = array();
        foreach($role2acc as $x){
            $role = $x->role_id;
            
            if(!in_array($role,$_SESSION["roles"])&& isset($role)){
                $_SESSION["roles"][] = $role;
            }
        }        
        /*
         * LOAD smaller roles
         */
        $udahdi = array();
        $sem = (sizeof($_SESSION['roles'])? $_SESSION["roles"] : array());
        while(sizeof($sem)>0){
            $r = array_pop($sem);
            if(!in_array($r,$udahdi)){
                $sql = "SELECT * FROM {$this->role2role_table} WHERE role_big = '$r'";
                $role2role = $db->query($sql,2);
                foreach($role2role as $ri){
                     if(!in_array($ri->role_small,$_SESSION["roles"]) && $ri->role_small!=""){
                        $_SESSION["roles"][] = $ri->role_small;
                        $sem[] = $ri->role_small;
                     }
                }
                $udahdi[]=$r;
            }
        }
        $this->roles  = $_SESSION['roles'];
    }
    public static function setRedirection(){
        $account = $_SESSION['account'];
        switch ($_SESSION['account']->admin_role){
            case "admin":                
                //loadData
                $accountRole = new Admin();
                $accountRole->getByAccountID($account->admin_id);                       
               break;
            case "supervisor":
                $accountRole = new Supervisor();
                $accountRole->getByAccountID($account->admin_id); 

              break;
            case "tatausaha":
                $accountRole = new Tatausaha();
                $accountRole->getByAccountID($account->admin_id); 

              break;
            case "guru":
                $accountRole = new Guru();
                $accountRole->getByAccountID($account->admin_id); 
                
            break;
            default:
                $accountRole = new Murid();
                $accountRole->getByAccountID($account->admin_id);                                
        }
        //fill the data of the Role
        $accountRole->fill(toRow($account));  
        //$account->admin_role;
        $_SESSION['account'] = $accountRole;
        //setRedirection
        Redirect::firstPage();

    }
    
    /*
     * getFoto
     */
    public function getFoto($src = ""){
        if($src == "")$src = $this->admin_foto;
        return Leap\View\InputFoto::getFoto($src);
    }
    /*
     * printFoto
     */
    public function makeFoto($size = 45){
        $src = $this->getFoto();        
        Account::printFoto($src,$size);
    }
    /*
     * makeMyFoto
     */
    public static function makeMyFoto($size = 45){
        $src = Account::getMyFoto();
        Account::printFoto($src, $size);
    }
    /*
     * printFoto
     */
    public static function printFoto($src,$size){
        $classname = "img-rounded";
        if($size == "responsive"){
            //roy edit sebelum presentasi kawarwci 5.10.2014
            //$classname = "img-responsive";
            //$size = "45";
        } 
        if($size == "responsive"){
            ?>
        <div class="foto<?=$size;?>">
            <img src="<?=$src;?>" class="<?=$classname;?>" style="width: 100%;">
        </div>
            <?
        }else{
        ?>
        <style type="text/css">
        .foto<?=$size;?>{
            width: <?=$size;?>px; height: <?=$size;?>px; overflow: hidden;
        }
        .foto<?=$size;?> img{ width: <?=$size;?>px;  }
        </style> 
        <div class="foto<?=$size;?>">
            <img src="<?=$src;?>" class="notresponsive" onload="OnImageLoad(event,<?=$size;?>);">
        </div>
         <?
        }
    }
    /*
     * printFotoIterator
     */
    public static function makeFotoIterator($src,$size = 45){
        $acc = new Account();
        $src2 = $acc->getFoto($src);
        Account::printFoto($src2, $size);
    }
    
    
    /*
     * fungsi untuk ezeugt select/checkbox
     * 
     */
    public function overwriteForm($return,$returnfull){
            $return['admin_ip'] = new Leap\View\InputText("hidden", "admin_ip", "admin_ip", $this->admin_ip);            
            $return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);            
            $return['admin_nama_depan']  = new Leap\View\InputText("hidden", "admin_nama_depan", "admin_nama_depan", $this->admin_nama_depan);  
            $return['admin_nama_belakang']  = new Leap\View\InputText("hidden", "admin_nama_belakang", "admin_nama_belakang", $this->admin_nama_belakang);  
            $return['admin_lastupdate']  = new Leap\View\InputText("hidden", "admin_lastupdate", "admin_lastupdate", $this->admin_lastupdate);  
            $return['admin_aktiv'] = new Leap\View\InputSelect(array('0'=>0,'1'=>1),"admin_aktiv", "admin_aktiv",$this->admin_aktiv);
            
            $return['admin_foto'] = new Leap\View\InputText("hidden", "admin_foto", "admin_foto", $this->admin_foto);            
            $return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);            
            $return['admin_role']  = new Leap\View\InputText("hidden", "admin_role", "admin_role", $this->admin_role);  
            $return['admin_inbox_update']  = new Leap\View\InputText("hidden", "admin_inbox_update", "admin_inbox_update", $this->admin_inbox_update);  
            $return['admin_inbox_timestamp']  = new Leap\View\InputText("hidden", "admin_inbox_timestamp", "admin_inbox_timestamp", $this->admin_inbox_timestamp);  
           
            return $return;
    }
    /*
     * waktu read alias diganti objectnya/namanya
     */
    public function overwriteRead($return){
        $objs = $return['objs'];
        foreach ($objs as $obj){
           /* if(isset($obj->foto)){
                $obj->foto = \Leap\View\InputFoto::getAndMakeFoto($obj->foto, "foto_guru_".$obj->tu_id);
            }
            * */
            
        }
        //pr($return);
        return $return;
    }
    /*
     * batasin wktu sebelum save
     */
    public function constraints(){
        //err id => err msg
        $err = array();
        
        if(!isset($this->admin_username))$err['admin_username'] = Lang::t('err admin_username empty');
        if(!isset($this->admin_password))$err['admin_password'] = Lang::t('err admin_password empty');
        if(!isset($this->admin_id))$err['admin_username'] = Lang::t('Create New User Not Allowed');
        return $err;
    }
}