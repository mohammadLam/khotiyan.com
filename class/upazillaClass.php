<?php
	include_once 'lib/Database.php';
	include_once 'helpers/format.php';

class Upazilla{
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function insertUpazilla($upazillaEN, $upazillaBN, $zilla){
        $isExist = 0;

        // English
        $upazillaNameEN = $this->fm->validation($upazillaEN);
        $upazillaNameEN = mysqli_real_escape_string($this->db->link, $upazillaNameEN);

        // Bangla
        $upazillaNameBN = $this->fm->validation($upazillaBN);
        $upazillaNameBN = mysqli_real_escape_string($this->db->link, $upazillaNameBN);
		
		// zilla
        $zilla = $this->fm->validation($zilla);
        $zilla = mysqli_real_escape_string($this->db->link, $zilla);

        // Checking already exist or not
        $sql = "SELECT * FROM tbl_upazilla WHERE upazillaEN = '{$upazillaNameEN}' AND upazillaBN = '{$upazillaNameBN}' ";
        $run = $this->db->select($sql);
        if ($run) {
            $isExist = 1;
        }

        if (empty($upazillaNameEN) || empty($upazillaNameBN) || empty($zilla)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }elseif($isExist == 1){
            $msg = "<span class='error'>উপজেলাটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন</span>";
            return $msg;
        }else {
            
            $queryfordiv = "SELECT division FROM tbl_zilla WHERE id = '$zilla' ";
            $run = $this->db->insert($queryfordiv);
            $output = $run->fetch_assoc();
            $zilla_division = $output['division'];

            $sql = "INSERT INTO `tbl_upazilla` (`upazillaEN`, `upazillaBN`, `zilla`, `division`) VALUES ('$upazillaNameEN', '$upazillaNameBN', '$zilla', '$zilla_division')";
            $run = $this->db->insert($sql);
            if ($run) {
                $msg = "<span class='success'>উপজেলা সফলভাবে তৈরি করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }
    public function getUpazillaList(){
        $sql = "SELECT * FROM tbl_upazilla";
        $run = $this->db->select($sql);
        return $run;
    }

    public function getUpazillaListAd(){
        $sql = "SELECT tbl_upazilla.id, upazillaBN, upazillaEN, zillaBN, divisionBN FROM tbl_upazilla, tbl_zilla, tbl_division WHERE tbl_upazilla.zilla = tbl_zilla.id AND tbl_upazilla.division = tbl_division.id ORDER BY divisionBN";
        $run = $this->db->select($sql);
        return $run;
    }
    
    public function deleteUpazilla($id) {
        $sql = "DELETE FROM tbl_upazilla WHERE id= '$id' ";
        $run = $this->db->delete($sql);
        if($run){
            $msg = "<span class='success'>উপজেলা মুছে ফেলা হয়েছে</span>";
            return $msg;
        }
        else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }
    
    public function getUpazillaById($id) {
        $sql = "SELECT * FROM tbl_upazilla WHERE id='$id' ";
        $run = $this->db->delete($sql);
        return $run;
    }
    
    public function updateUpazillaById($id, $upazillaEN, $upazillaBN, $zilla) {
        $isExist = 0;

        $upazillaNameEN = $this->fm->validation($upazillaEN);
        $upazillaNameEN = mysqli_real_escape_string($this->db->link, $upazillaNameEN);

        $upazillaNameBN = $this->fm->validation($upazillaBN);
        $upazillaNameBN = mysqli_real_escape_string($this->db->link, $upazillaNameBN);

        $zilla = $this->fm->validation($zilla);
        $zilla = mysqli_real_escape_string($this->db->link, $zilla);
        
        //checking if already have this upazilla
        $checkUpazilla = "SELECT * FROM tbl_upazilla WHERE upazillaEN = '{$upazillaNameEN}' AND upazillaBN = '{$upazillaNameBN}' AND zilla = $zilla";
        $runCheckUpazilla = $this->db->select($checkUpazilla);
        if ($runCheckUpazilla) {
            $isExist = 1;
            
        }
        
        // Set currect zilla from user input
        $checkZilla = "SELECT * FROM tbl_zilla WHERE id = $zilla ";
        $runCheckZilla = $this->db->select($checkZilla);
        if ($runCheckZilla) {
            $fetchReturnResult = $runCheckZilla->fetch_assoc();
            $division = $fetchReturnResult['division'];
        }

        if (empty($upazillaNameEN) || empty($upazillaNameBN)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }elseif($isExist == 1){
            $msg = "<span class='error'>উপজেলাটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন</span>";
            return $msg;
        }else{
            $sql = "UPDATE tbl_upazilla SET upazillaEN = '$upazillaNameEN', upazillaBN = '$upazillaNameBN', zilla = $zilla, division = $division WHERE id = '$id' ";
            $run = $this->db->update($sql);
            if ($run) {
                $msg = "<span class='success'>উপজেলা সফলভাবে সংস্কার করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }
}