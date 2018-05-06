<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marcel
 *
 * @author User
 */
class Marcel extends WebService{
    //put your code here
    //var $access_test = "marcel";
    function test(){
        //echo "hello";
        
        $m = new Murid();
        $m->getByID(699);
        
        echo json_encode($m);
    }
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     */
    public function ctu(){
        global $db;
        echo "test";
        $adr[0] = "Jl. Aria Putra Kedaung No.100, Ciputat - Tangerang Selatan";
        $adr[1] = "Jl. Kemuning Ix Blok CH No.120, Komplek Taman Kedaung, Ciputat - Tangerang Selatan";
        $adr[2] = "Jl. Raya Muchtar No. 88, Sawangan  Baru, Depok";
        $adr[3] = "Jl. Perumahan Gran Puri Laras No.168";
        $adr[4] = "Jl. Kl Yos Sudarso No.200";
        $adr[5] = "Gardenia Estate Blok G No. 38, Ciputat - Tangerang Selatan";
        $adr[6] = "Jl. R.E. Martadinata";
 
       
        for($i= 0; $i<=74;$i++)
        {
            $id = $i % 7;
            $start = 633;
            $murid_id = $i + $start;
            echo $murid_id;
            $q = "UPDATE ry_murid__data SET alamat='$adr[$id]' WHERE murid_id = '$murid_id'";
            //echo $q;
            $r = $db->query($q,1);
        }
       
        //pr($mps);
    }
    
    public function hapusUpload2Datamurid()
    {
        echo __FUNCTION__;
        global $db;
        $q = "SELECT account_id, foto FROM ry_murid__data WHERE 1";
        $r = $db->query($q,2);

        foreach ($r as $result)
        {
            echo $result->foto . "<br>";
            $foto = $result->foto;
            $foto =  (explode("/",$foto));
            
            if(count($foto)== 1){
                $updateDataMurid = "UPDATE ry_murid__data SET foto='$foto[0]' WHERE account_id = '$result->account_id'";
                $updateAdmin = "UPDATE sp_admin_account SET admin_foto='$foto[0]' WHERE admin_id = '$result->account_id'";
            }
                   
            else {
                 $updateDataMurid = "UPDATE ry_murid__data SET foto='$foto[1]' WHERE account_id = '$result->account_id'";   
                 $updateAdmin = "UPDATE sp_admin_account SET admin_foto='$foto[1]' WHERE admin_id = '$result->account_id'";
                 }
            
             $rmurid = $db->query($updateDataMurid,1); 
             $radmin = $db->query($updateAdmin,1); 
            //uploadclass2/12caae73a6fe207613243ff533e74877.jpg
        }
    }

    public function hapusUpload2Dataguru()
    {
        echo __FUNCTION__;
        global $db;
        $q = "SELECT account_id, foto FROM ry_guru__data WHERE 1";
        $r = $db->query($q,2);

        foreach ($r as $result)
        {
            echo $result->foto . "<br>";
            $foto = $result->foto;
            $foto =  (explode("/",$foto));

            if(count($foto)== 1){
                $updateDataMurid = "UPDATE ry_guru__data SET foto='$foto[0]' WHERE account_id = '$result->account_id'";
                $updateAdmin = "UPDATE sp_admin_account SET admin_foto='$foto[0]' WHERE admin_id = '$result->account_id'";
            }

            else {
                $updateDataMurid = "UPDATE ry_guru__data SET foto='$foto[1]' WHERE account_id = '$result->account_id'";
                $updateAdmin = "UPDATE sp_admin_account SET admin_foto='$foto[1]' WHERE admin_id = '$result->account_id'";
            }

            $rmurid = $db->query($updateDataMurid,1);
            $radmin = $db->query($updateAdmin,1);
            //uploadclass2/12caae73a6fe207613243ff533e74877.jpg
        }
    }
}
