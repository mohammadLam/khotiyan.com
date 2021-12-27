<?php
	include_once 'lib/Database.php';
	include_once 'helpers/format.php';

class Zilla{
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function addZilla($zillaEN, $zillaBN, $division){
        $isExist = 0;

        // English
        $zillaNameEN = $this->fm->validation($zillaEN);
        $zillaNameEN = mysqli_real_escape_string($this->db->link, $zillaNameEN);

        // Bangla
        $zillaNameBN = $this->fm->validation($zillaBN);
        $zillaNameBN = mysqli_real_escape_string($this->db->link, $zillaNameBN);
		
		// Division
        $division = $this->fm->validation($division);
        $division = mysqli_real_escape_string($this->db->link, $division);

        // Checking already exist or not
        $sql = "SELECT * FROM tbl_zilla WHERE zillaEN = '{$zillaNameEN}' AND zillaBN = '{$zillaNameBN}' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($zillaNameEN) || empty($zillaNameBN) || empty($division)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }elseif($isExist == 1){
            $msg = "<span class='error'>বিভাগটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন</span>";
            return $msg;
        }else {
            $sql = "INSERT INTO `tbl_zilla` (`zillaEn`, `zillaBn`, `division`) VALUES ('$zillaNameEN', '$zillaNameBN', '$division')";
            $run = $this->db->insert($sql);
            if ($run) {
                $msg = "<span class='success'>জেলা সফলভাবে তৈরি করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function getZillaList(){
        $sql = "SELECT tbl_zilla.id, zillaBN, zillaEN, divisionBN FROM tbl_zilla, tbl_division WHERE tbl_zilla.division = tbl_division.id ORDER BY division";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getZillaList2(){
        $sql = "SELECT * FROM tbl_zilla";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getZillaById($id){
        $sql = "SELECT * FROM tbl_zilla WHERE id='$id' ";
        $run = $this->db->select($sql);
        return $run;
    }

    public function deleteZilla($id){
        $sql = "DELETE FROM tbl_zilla WHERE id='$id' ";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "<span class='success'>জেলা মুছে ফেলা হয়েছে</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Zilla can not be delete</span>";
            return $msg;
        }
    }

    public function updateZilla($id, $zillaEN, $zillaBN, $division){
        $isExist = 0;

        $zillaNameEN = $this->fm->validation($zillaEN);
        $zillaNameEN = mysqli_real_escape_string($this->db->link, $zillaNameEN);

        $zillaNameBN = $this->fm->validation($zillaBN);
        $zillaNameBN = mysqli_real_escape_string($this->db->link, $zillaNameBN);

        $division = $this->fm->validation($division);
        $division = mysqli_real_escape_string($this->db->link, $division);

        $sql = "SELECT * FROM tbl_zilla WHERE zillaEN = '{$zillaNameEN}' AND zillaBN = '{$zillaNameBN}' AND division = $division";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($zillaNameEN) || empty($zillaNameBN)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }elseif($isExist == 1){
            $msg = "<span class='error'>জেলাটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন</span>";
            return $msg;
        }else{
            $sql = "UPDATE tbl_zilla SET zillaEN = '$zillaNameEN', zillaBN = '$zillaNameBN', division = '$division' WHERE id = '$id' ";
            $run = $this->db->update($sql);
            if ($run) {
                $msg = "<span class='success'>জেলা সফলভাবে সংস্কার করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }
}