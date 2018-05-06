<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Generic
 *
 * @author efindiongso
 */
class Generic {

    //put your code here
    public static function getTingkatanName($id_tingkatan) {
        $kelas = new Kelas();
        $arrKelas = $kelas->getWhere("kelas_tingkatan='$id_tingkatan'");
        return $arrKelas;
    }

    public static function getNextTingkatanName($id_tingkatan) {
        $kelas = new Kelas();
        $id_tingkatan = $id_tingkatan + 1;
        $arrKelas = $kelas->getWhere("kelas_tingkatan='$id_tingkatan'");
        return $arrKelas;
    }

    public static function coba() {
        echo "coba";
    }

}
