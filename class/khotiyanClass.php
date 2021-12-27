<?php

class khotiyan {

    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function getKhotiyanList($division, $zilla, $upazilla, $mouja, $kho_type) {
        if (empty($division) || empty($zilla) || empty($upazilla) || empty($mouja) || empty($kho_type)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            //return array(0, $msg);
            return $msg;
        } else {
            $sql = "SELECT id, $kho_type, khotiyan FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla AND mouja = $mouja AND $kho_type != '' ORDER BY khotiyan";
            $run = $this->db->select($sql);
            //return array(1, $run);
            return $run;
        }
    }

    public function getKhotiyanByDaag($division, $zilla, $upazilla, $mouja, $kho_type, $daagNo) {
        $kho_type = $this->fm->validation($kho_type);
        $kho_type = mysqli_real_escape_string($this->db->link, $kho_type);

        $daagNo = $this->fm->validation($daagNo);
        $daagNo = mysqli_real_escape_string($this->db->link, $daagNo);

        if (empty($division) || empty($zilla) || empty($upazilla) || empty($mouja) || empty($kho_type) || empty($daagNo)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return array(0, $msg);
        }
        else {
            $sql = "SELECT khotiyan, $kho_type FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla AND mouja = $mouja AND $kho_type != '' ";
            $run = $this->db->select($sql);
            if ($run) {
                while ($result = $run->fetch_assoc()) {
                    $temp = json_decode($result["$kho_type"]);
                    if (in_array($daagNo, $temp)) {
                        return array(1, $result);
                    }
                }
                $msg = "<h3 class='error'>কোন তথ্য পাওয়া যায়নি</h3>";
                return array(0, $msg);
            } else {
                $msg = "<h3 class='error'>কোন তথ্য পাওয়া যায়নি</h3>";
                return array(0, $msg);
            }
        }
    }

    public function insertNewData($division, $zilla, $upazilla, $mouja, $kho_type, $kho_No, $daagNo) {

        $daag_array = explode(", ", $daagNo);
        $daagNo = json_encode($daag_array);

        if (empty($division) || empty($zilla) || empty($upazilla) || empty($mouja) || empty($kho_type) || empty($kho_No) || empty($daagNo)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        } else {
            $sql = "INSERT INTO tbl_khotiyan ($kho_type, khotiyan, mouja, upazilla, zilla, division) VALUES ('$daagNo', '$kho_No', '$mouja', '$upazilla', '$zilla', '$division')";
            $run = $this->db->insert($sql);

            if ($run) {
                $msg = "<span class='success'>খতিয়ান যোগ করা হয়েছে</span>";
                return $msg;
            } else {
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function getActualData($division, $zilla, $upazilla, $mouja) {
        if (empty($division) || empty($zilla) || empty($upazilla) || empty($mouja)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return array(0, $msg);
        } else {
            $sql = "SELECT divisionBn, zillaBN, upazillaBN, moujaBn FROM tbl_division, tbl_zilla, tbl_upazilla, tbl_mouja WHERE tbl_division.id = $division AND tbl_zilla.id = $zilla AND tbl_upazilla.id = $upazilla AND tbl_mouja.id = $mouja";
            $run = $this->db->select($sql);
            return array(1, $run);
        }
    }

    public function deleteKhotiyan($id) {
        $sql = "DELETE FROM tbl_khotiyan WHERE id = $id";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "খতিয়ান অপসারণ করা হয়েছে";
            return ['success', $msg];
        }
    }

    public function getKhoById($id) {
        $sql = "SELECT * FROM tbl_khotiyan WHERE id = $id";
        $run = $this->db->select($sql);
        return $run;
    }

    public function updateKhoById($id, $khotiyan, $daag, $type) {

        if (empty($type) || empty($khotiyan) || empty($daag)) {
            $msg = "সবগুলো ঘর পূরণ করুন";
            return ['error', $msg];
        }

        else{
            $khotiyan = $khotiyan;
            $daag_array = explode(", ", $daag);
            $daag = json_encode($daag_array);

            $sql = "UPDATE tbl_khotiyan SET $type = '$daag', khotiyan = '$khotiyan' WHERE id = '$id'";
            $run = $this->db->delete($sql);
            if ($run) {
                $msg = "খতিয়ান সংস্করণ করা হয়েছে";
                return ['success', $msg];
            } else {
                $msg = "Something went wrong";
                return ['error', $msg];
            }
        }
    }

}
