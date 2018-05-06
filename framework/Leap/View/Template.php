<?php
namespace Leap\View;

/*
 * LEAP OOP PHP 
 * Each line should be prefixed with  * 
 */

/**
 * Description of Template
 *
 * @author User
 */
class Template {

    protected $charset = "utf-8";
    protected $title; // dipake
    protected $metakey; // dipake
    protected $metades; // dipake
    protected $content = array(); // dipake
    protected $onload; // dipake
    protected $headText = array(); // dipake
    protected $headPhpFiles = array(); // dipake
    protected $bodyLastText = array(); // dipake
    protected $bodyPhpFilesLast = array(); // dipake
    protected $breadcrumbs = array();
    protected $bodyPhpFilesFirst = array();
    protected $bodyFirstText = array();
    protected $admin = 0;
    protected $init;
    protected $namaFileTemplate = "skeleton";
    protected $WebSetting;
    
    
    function __construct($WebSetting) {
        $this->WebSetting = $WebSetting;
    }
    /*
    * Print to template
    */
    public function printHTML($str){
        $location = $this->namaFileTemplate;
        
        //getContent
        $this->content[] = $str;        
        $content = implode('', $this->content);
        //page title
        $title = $this->getTitle();
        //get metakey
        $metaKey = $this->getMetaKey();
        //get metakey
        $metaDescription = $this->getMetaDesc();
        //getHead
        
        //onLoad
        $onLoad = $this->onload;
        
        //getBodyfirst dan last didalam template aja, kalau perlu
       
        $exp = explode("/",$_GET["url"]);
        $class = $exp[0];
        
        if(!@include _THEMEPATH."/{$location}--".$class.".php")              
                include _THEMEPATH."/{$location}.php";                
 
    }
    
    /*
     * namaFileTemplate
     */
    function setNamaFileTemplate($skeleton){
        $this->namaFileTemplate = $skeleton;
    }
    function getNamaFileTemplate(){
        return $this->namaFileTemplate;
    }
    /*
     *              HEAD
     */
    /*
     * Title
     */ 
    function setTitle($title){
        $this->title = $title;
    }
    function getTitle(){
        if($this->title == "") return $this->WebSetting["title"];
        else return $template->title;
    }
    /*
     * Meta Key
     */
    function setMetaKey($metakey){
        $this->metakey = $metakey;
    }
    function getMetaKey(){
        if($this->metakey == "") return "<meta name=\"Keywords\" content=\"".$this->WebSetting["metakey"]."\" />";
        else return "<meta name=\"Keywords\" content=\"".$this->metakey."\" />";
    }
    /*
     * Meta Des
     */
    function setMetaDesc($metades){
        $this->metades = $metades;
    }
    function getMetaDesc(){
        $metades = $this->metades;
        if($this->metades == "")$metades = $this->WebSetting["metadescription"];
        
        return "<meta name=\"Description\" content=\"".$metades."\" />
    <meta http-equiv=\"pragma\" content=\"no-cache\" />
    <meta http-equiv=\"cache-control\" content=\"no-cache\" />";      
    }
    /*
     *  Head Files
     */
    function printHead(){
        foreach($this->headPhpFiles as $j)@include $j;
        foreach($this->headText as $hd){
                   echo $hd;
        }
    }
    /*
     * Add files to <head>
     */
    function addFilesToHead($file){
        $this->headPhpFiles[] = $file;
    }
    /*
     * @return array of path to files
     */
    function getFilesHead(){
        return $this->headPhpFiles;
    }
    /*
     * Add text to <head>
     */
    function addTextToHead($text){
        $this->headText .= $text;
    }
    /*
     *  @return string 
     */
    function getTextHead(){
        return $this->headText;
    }
    
    function getHeadfiles(){
        foreach($this->headPhpFiles as $j)@include $j;
        foreach($this->headText as $hd){
                   //echo htmlentities($hd)."<br><br>";
                   echo $hd;
                }
    }
}
