<?php

class Mouja {

    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function getMoujaList() {
        $sql = "SELECT * FROM tbl_mouja";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getMoujaById($id) {
        $sql = "SELECT * FROM tbl_mouja WHERE id= $id ";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getMoujaListByParentValue($division, $zilla, $upazilla){
        $division = mysqli_real_escape_string($this->db->link, $division);
        $zilla    = mysqli_real_escape_string($this->db->link, $zilla);
        $upazilla = mysqli_real_escape_string($this->db->link, $upazilla);

        $sql = "SELECT tbl_mouja.id, moujaBn, moujaEn, upazillaBN, zillaBN, divisionBN FROM tbl_mouja, tbl_upazilla, tbl_zilla, tbl_division WHERE tbl_mouja.upazilla = tbl_upazilla.id AND tbl_mouja.zilla = tbl_zilla.id AND tbl_mouja.division = tbl_division.id AND tbl_division.id = $division AND tbl_zilla.id = $zilla AND tbl_upazilla.id = $upazilla";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getMoujaListAd() { // this is advanced query for get mouja list with full details
        $sql = "SELECT tbl_mouja.id, moujaBn, moujaEn, upazillaBN, zillaBN, divisionBN FROM tbl_mouja, tbl_upazilla, tbl_zilla, tbl_division WHERE tbl_mouja.upazilla = tbl_upazilla.id AND tbl_mouja.zilla = tbl_zilla.id AND tbl_mouja.division = tbl_division.id";
        $run = $this->db->select($sql);
        return $run;
    }

    public function insertMouja($moujaBn, $moujaEn, $upazilla, $zilla, $division) {
        $isExist = 0;
        $moujaNameEn = $this->fm->validation($moujaEn);
        $moujaNameEn = mysqli_real_escape_string($this->db->link, $moujaNameEn);

        $moujaNameBn = $this->fm->validation($moujaBn);
        $moujaNameBn = mysqli_real_escape_string($this->db->link, $moujaNameBn);

        $upazilla = $this->fm->validation($upazilla);
        $upazilla = mysqli_real_escape_string($this->db->link, $upazilla);

        $zilla = $this->fm->validation($zilla);
        $zilla = mysqli_real_escape_string($this->db->link, $zilla);

        $division = $this->fm->validation($division);
        $division = mysqli_real_escape_string($this->db->link, $division);

        // Checking already exist or not
        $sql = "SELECT * FROM tbl_mouja WHERE moujaEn = '{$moujaNameEn}' AND moujaBn = '{$moujaNameBn}' AND zilla = '$zilla' AND upazilla = '$upazilla' AND division = '$division' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($moujaNameEn) || empty($moujaNameBn) || empty($upazilla) || empty($zilla) || empty($division)) {
            $msg = "সবগুলো ঘর পূরণ করুন";
            return ['error', $msg];
        } elseif ($isExist == 1) {
            $msg = "মৌজাটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন";
            return ['error', $msg];
        } else {

            $sql = "INSERT INTO `tbl_mouja` (`moujaEn`, `moujaBn`, `upazilla`, `zilla`, `division`) VALUES ('$moujaNameEn', '$moujaNameBn', $upazilla, $zilla, $division)";
            $run = $this->db->insert($sql);
            if ($run) {
                $msg = "মৌজা সফলভাবে তৈরি হয়েছে";
                return ['success', $msg];
            } else {
                $msg = "Something went wrong";
                return ['error', $msg];
            }
        }
    }

    public function updateMoujaById($id, $moujaBn, $moujaEn, $upazilla, $zilla, $division) {
        $isExist = 0;
        // Checking already exist or not
        $sql = "SELECT * FROM tbl_mouja WHERE moujaEn = '{$moujaEn}' AND moujaBn = '{$moujaBn}' AND zilla = '$zilla' AND upazilla = '$upazilla' AND division = '$division' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($moujaBn) || empty($moujaEn) || empty($upazilla) || empty($zilla) || empty($division)) {
            $msg = "সবগুলো ঘর পূরণ করুন";
            return ['error', $msg];
        }elseif ($isExist == 1) {
            $msg = "মৌজার তথ্য পরিবর্তন করা হয়নি";
            return ['warning', $msg];
        }else {
            $sql = "UPDATE tbl_mouja SET moujaBn = '$moujaBn', moujaEn = '$moujaEn', upazilla = $upazilla, zilla = $zilla, division = $division  WHERE id = $id";
            $run = $this->db->update($sql);

            if ($run) {
                $msg = "মৌজা সফলভাবে সংস্করন করা হয়েছে";
                return ['success', $msg];
            } else {
                $msg = "Something went wrong!";
                return ['error', $msg];
            }
        }
    }

    public function deleteMouja($id){
        $sql = "DELETE FROM tbl_mouja WHERE id= '$id' ";
        $run = $this->db->delete($sql);
        if($run){
            $msg = "মৌজা মুছে ফেলা হয়েছে";
            return ['success', $msg];
        }
        else{
            $msg = "Something went wrong";
            return ['error', $msg];
        }
    }

}