<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wall
 *
 * @author User
 */
class Wall extends Model {
    
    public static function createID(){
        $nextmsgid = time() . rand(0, 100);
        return $nextmsgid;
    }
    public static function getDateTime(){
        return date("Y-m-d H:i:s");
    }
}
