<?php
//	include_once 'lib/Database.php';
//	include_once 'helpers/format.php';

class Division{
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function addDivision($divisionBn, $divisionEn){
        $isExist = 0;
        // English
        $divisionEn = $this->fm->validation($divisionEn);
        $divisionEn = mysqli_real_escape_string($this->db->link, $divisionEn);

        // Bangla
        $divisionBn = $this->fm->validation($divisionBn);
        $divisionBn = mysqli_real_escape_string($this->db->link, $divisionBn);

        // Checking already exist or not
        $sql = "SELECT * FROM tbl_division WHERE divisionEn = '{$divisionEn}' OR divisionBn = '{$divisionBn}' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($divisionEn) || empty($divisionBn)) {
            //$msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            $msg = "সবগুলো ঘর পূরণ করুন";
            return ['error', $msg];
        }
        elseif($isExist == 1){
            $msg = "বিভাগটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন";
            return ['error', $msg];
        }
        else {
            $sql = "INSERT INTO tbl_division (divisionEn, divisionBn) VALUES ('$divisionEn', '$divisionBn') ";
            $run = $this->db->insert($sql);
            if ($run) {
                //$msg = "<span class='success'>বিভাগ সফলভাবে তৈরি হয়েছে</span>";
                $msg = "বিভাগ সফলভাবে তৈরি হয়েছে";
                return ['success', $msg];
            }else{
                $msg = "Something went wrong";
                return ['error', $msg];
            }
        }
    }

    public function getDivisionList(){
        $sql = "SELECT * FROM tbl_division";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getDivisionById($id){
        $sql = "SELECT * FROM tbl_division WHERE id='$id' ";
        $run = $this->db->select($sql);
        return $run;
    }

    public function deleteDivision($id){
        $sql = "DELETE FROM tbl_division WHERE id='$id' ";
        $run = $this->db->delete($sql);

        if ($run) {
            $msg = "বিভাগ মুছে ফেলা হয়েছে";
            return ['success', $msg];
        } else {
            $msg = "Something went wrong";
            return ['error', $msg];
        }
    }

    public function updateDivision($id, $divisionBn, $divisionEn){
        $divisionEn = $this->fm->validation($divisionEn);
        $divisionEn = mysqli_real_escape_string($this->db->link, $divisionEn);

        $divisionBn = $this->fm->validation($divisionBn);
        $divisionBn = mysqli_real_escape_string($this->db->link, $divisionBn);

        $isExist = 0;

        $sql = "SELECT * FROM tbl_division WHERE divisionEn = '{$divisionEn}' AND divisionBn = '{$divisionBn}' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($divisionBn) || empty($divisionEn)) {
            $msg = "সবগুলো ঘর পূরণ করুন";
            return ['error', $msg];
        }
        elseif($isExist == 1){
            $msg = "বিভাগটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন";
            return ['error', $msg];
        }
        else{
            $sql = "UPDATE tbl_division SET divisionEn = '$divisionEn', divisionBn = '$divisionBn' WHERE id = '$id' ";
            $run = $this->db->update($sql);
            if ($run) {
                $msg = "বিভাগ সফলভাবে সংস্কার করা হয়েছে";
                return ['success', $msg];
            }else{
                $msg = "Something went wrong";
                return ['error', $msg];
            }
        }
    }
}