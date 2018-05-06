<?php

/* **********************************

 * 

 *        Leap System eLearning

 *      @author elroy,efindi,budiarto

 *          www.leap-systems.com

 * 

 ************************************/

/******************************

 *  LOAD All Frameworks

 *  using Leap loosely coupled Object Oriented Framework

 *  using PHP Framework Interop Group Standard

 *****************************/

require_once 'SplClassLoader.php';

//enginepath

$enginepath = 'framework';

//namespace or vendorname

$ns = "Leap";

//autoload all Classes in the FrameWork

$loader = new SplClassLoader($ns, $enginepath);

$loader->register();

 

//get the init class, kalau tidak ada perubahan juga bisa langsung pakai Init yang di framework

//use Leap\InitLeap;

require_once 'Init.php'; // pembedanya adalah yg disini untuk load yg local classes saja

//get global functions 

require_once 'functions.php';



/******************************

 *  AUTO LOAD Apps

 *****************************/



// LOAD Leap eLearning Apps

/*$pathToApps = 'app';

//namespace

$nsToApps = "LeapElearning";

//autoload all Classes in the FrameWork

$loader = new SplClassLoader($nsToApps, $pathToApps);

$loader->register();

*/

$di = new RecursiveDirectoryIterator('app',RecursiveDirectoryIterator::SKIP_DOTS);
//pr($di);
$it = new RecursiveIteratorIterator($di);
//pr($it);

//sort function
$files2Load = array();
foreach($it as $file)
{

    if(pathinfo($file,PATHINFO_EXTENSION) == "php")
	{
    	$files2Load[]= $file->getPathname();
	}
}
sort($files2Load);
//pr($files2Load);

foreach($files2Load as $file)

{

     require_once $file;

}

// include db setting, web setting, and paths

require_once 'include/access.php';



$init = new Init($mainClass,$DbSetting,$WebSetting,$timezone,$js,$css,$nameSpaceForApps);

//starting the session
session_start();
//pr($WebSetting);
//Init Languange

$lang = new Lang($WebSetting['lang']);

$lang->activateLangSession();

$lang->activateGetSetLang();
//pr($lang);
//pr($_SESSION);
$selected_lang = Lang::getLang();
if(!isset($selected_lang) || $selected_lang == "" || is_object($selected_lang))
$selected_lang = "en";

//pr($selected_lang);

//echo "lang/".strtolower($selected_lang).".php";
require_once ("lang/".strtolower($selected_lang).".php");

//get globals

$db = $init->getDB();

$params = $init->getParams();

$template = $init->getTemplate();

//pr($init);

$init->run();



//pr($_SESSION);



//$allClass = get_declared_classes();

//pr($allClass);

/*

pr($init);

pr($_GET);

pr($_SESSION);

pr($_COOKIE);

$allClass = get_declared_classes();

pr($allClass);

*/

//$l = new \LeapElearning\Coba();

//$l->haha();

/*

 * Main Class adalah selalu class Leap di folder class

 */

//set main template as canvas for the HTML code

//$template = $init->template;

//$detect = $init->mobileDetect;



/*

 * Tambahan isi untuk template, bisa langsung dituliskan di themes/skeleton, bsa juga lewat $template

 */

/*

$template->bodyfirst[] = "

<div id=\"loadingtop\" style=\"display:none; position: fixed; width:100%; top:40%;z-index:200000000;\">

<div id=\"loadingtop2\" style=\"text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #5c6e7d; font-weight: bold; margin:0 auto;\">

<img style=\"margin-bottom:10px;\" src=\"".$folder."images/leaploader.gif\"/>

<div>".Lang::t('lang_loading')."</div>

</div>

</div>

";

$template->bodyfirst[] = "

<div id=\"oktop\" style=\"display:none; position: fixed; width:100%; top:40%;z-index:20000000;\">

<div id=\"oktop2\" style=\"text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #7db660; font-weight: bold; margin:0 auto;\">

<img style=\"margin-bottom:10px;\" src=\"".$folder."images/ok.gif\"/>

<div style='font-size:48px;'>".Lang::t('OK')."</div>

</div>

</div>

";

*/

//$init->run($init);



//echo "end";