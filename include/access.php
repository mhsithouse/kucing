<?php
/*
 *  Database, Websetting and Path Setting
 *  untuk multiple selection di def di init.php
 */
$serverpath = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "leap_sd";
//$db_name = "mapp_live_1";
$db_prefix = '';
//init db setting
$DbSetting = array("serverpath"=>$serverpath,"db_username"=>$db_username,"db_password"=>$db_password,"db_name"=>$db_name,"db_prefix"=>$db_prefix);
//Websetting
//$domain = $_SERVER['SERVER_NAME'];
$domain = "localhost:8888";
//$domain = "mhssd.menaraharapan.sch.id";
$folder = '/mhssd/';
$title = 'Leap System';
$metakey = 'Leap Key| Menara Harapan School';
$metadescription = 'Leap Description';
$lang = 'en';
$currency = 'IDR';
//$photo_path = 'D:/xampp/htdocs/static/musterkindergarten/'; //kalau untuk multiple selection di def di init.php
//$photo_path = '/home/u7408203/public_html/static/musterkindergarten/'; //kalau untuk multiple selection di def di init.php
$photo_url = 'http://static.menaraharapan.sch.id/musterkindergarten/';

$photo_path = '/Users/efindiongso/Documents/htdocs/static/musterkindergarten/'; //always use full path - elroy 19 12 2014
$photo_url = '/Users/efindiongso/Documents/htdocs/static/musterkindergarten/';

//themepath
$themepath = 'adminlte';

//ini_set('display_errors', '1');
//error_reporting(E_ALL);
// init web setting
$WebSetting = array("domain"=>$domain,"folder"=>$folder,"title"=>$title,"metakey"=>$metakey,"metadescription"=>$metadescription,"lang"=>$lang,"currency"=>$currency,"photopath"=>$photo_path,"photourl"=>$photo_url,"themepath"=>$themepath);
//timezone
$timezone = 'Asia/Jakarta';

//javascript files
$js = "loader_js.php";
//css files
$css = "loader_css.php";

//main class MUST BE subclass of Apps
$mainClass = "Leap";
//set namespace for apps
$nameSpaceForApps = array("");