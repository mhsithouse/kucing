<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/18/17
 * Time: 7:09 PM
 */
class WS extends WebService
{

    public function loginmb()
    {
        $username = isset($_POST['username']) ? addslashes($_POST['username']) : "";
        $pwd = isset($_POST['pwd']) ? addslashes($_POST['pwd']) : "";


        $acc = new Account();
        $acc->getWhereOne("admin_username='$username' AND admin_password='$pwd'");

        if (is_null($acc->admin_id)) {
            $json['status_code'] = 0;
            $json['status_message'] = "Username atau password salah!";
            echo json_encode($json);
            die();
        } else {
            $murid = new Murid();
            $murid->getWhereOne("account_id='$acc->admin_id'");
            if (is_null($murid->murid_id)) {
                $json['status_code'] = 0;
                $json['status_message'] = "Username atau password salah!";
                echo json_encode($json);
                die();
            }
            $json['status_code'] = 1;
            $json['status_message'] = "Login berhasil!";
            $json['murid'] = $murid;
            echo json_encode($json);
            die();
        }
        pr($acc);

//        $json['status_code'] = 1;
//        $json['murid'] = $arrhlp;
//        $json['status_message'] = "Login Berhasil!";
//        echo json_encode($json);
//        die();


    }

    public function signin()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kode_murid = isset($_POST['kode_siswa']) ? addslashes($_POST['kode_siswa']) : "";
        $gebDatum = isset($_POST['tanggal_lahir']) ? addslashes($_POST['tanggal_lahir']) : "";

        if ($gebDatum == "") {
            Generic::errorMsg("Password kosong!");
        }
        $date = new DateTime($gebDatum);
        $gebDatum = $date->format("Y-m-d");
        $murid = new MuridModel();
        $murid->getWhereOne("kode_siswa='$kode_murid' AND tanggal_lahir='$gebDatum'");
        $ws = $murid->crud_webservice_allowed;
        $wsArray = explode(",", $ws);
        $arrhlp = array();
        foreach ($wsArray as $val) {
            if ($val == "id_level_sekarang") {
                $arrhlp["level"] = Generic::getLevelNameByID($murid->$val);
            } elseif ($val == "gambar") {
                if ($murid->$val == "") {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . "noimage.jpg";
                } else {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . $murid->$val;
                }

            } else {
                $arrhlp[$val] = $murid->$val;
            }

        }
        $tc = Generic::getTCNamebyID($murid->murid_tc_id);
        $arrhlp['tc'] = $tc;
        if (!is_null($murid->id_murid)) {
            $json['status_code'] = 1;
            $json['murid'] = $arrhlp;
            $json['status_message'] = "Login Berhasil!";
            echo json_encode($json);
            die();
        }

        Generic::errorMsg("Login Gagal!");

    }

    public function gantiPasswordMurid()
    {

        $adminAccount = new Account();
        $arrMurid = $adminAccount->getWhere("admin_aktiv='1' AND admin_role='Murid'");
        $modelAccount = new ModelAccount();
        foreach($arrMurid as $val){
            $pwd = $modelAccount->generate_password(6);
            pr($pwd);
            $adminAccountHlp = new Account();
            $adminAccountHlp->getByID($val->admin_id);
            $adminAccountHlp->admin_password = $pwd;
            $adminAccountHlp->load = 1;
            pr($adminAccountHlp->save());
//            pr($adminAccountHlp);
//            $val->admin_password = $modelAccount->generate_password(6);
//            $val->save(1);
        }
//        pr(count($arrMurid));
//        pr($arrMurid);

        //SELECT * FROM `sp_admin_account` WHERE `admin_aktiv` = 1 AND `admin_role` LIKE 'murid' ORDER BY `admin_id` ASC
    }

    public function printAccountPassword()
    {
        $adminAccount = new Account();
        $arrMurid = $adminAccount->getWhere("admin_aktiv='1' AND admin_role='Murid' ORDER BY admin_id DESC");
        foreach ($arrMurid as $key => $val) {
            ?>

            <div style="border: 2px dashed">
                <table align='center'>
                    <tr>
                        <td><h1>Account: <?= $val->admin_nama_depan; ?></h1></td>
                    </tr>
                </table>

                <div>
                    <table style='width:960px; margin:0 auto;'>
                        <tr bgcolor='#CCCCCC' height='30'>
                            <td><b>Username</b></td>
                            <td><b>Password</b></td>
                        </tr>
                        <tr height='30'>
                            <td><b><?= $val->admin_username; ?></b></td>
                            <td><b><?= $val->admin_password; ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <br style=" clear: both;">
            <?
        }

    }
}