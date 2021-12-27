<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';

class Website
{
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function createMarquee($marqueeText){
        $marquee = mysqli_real_escape_string($this->db->link, $marqueeText);

        if (empty($marquee)){
            $msg = "<span class='error'>ঘরটি পূরণ করুন</span>";
            return $msg;
        }else{
            $sql = "INSERT INTO tbl_announcement(announcement) VALUE ('$marquee')";
            $run = $this->db->insert($sql);
            if ($run){
                $msg = "<span class='success'>আপনার বিজ্ঞপ্তি যোগ করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function deleteMarquee($id){
        $id = $this->fm->validation($id);
        $id = mysqli_real_escape_string($this->db->link, $id);

        $sql = "DELETE FROM tbl_announcement WHERE id = $id";
        $run = $this->db->delete($sql);
        if ($run){
            $msg = "<span class='success'>বিজ্ঞাপন সফলভাবে মুছে ফেলা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function playMarquee($id){
        $id = $this->fm->validation($id);
        $id = mysqli_real_escape_string($this->db->link, $id);

        $sql = "UPDATE tbl_announcement SET status = 1 WHERE id = $id";
        $run = $this->db->delete($sql);
        if ($run){
            $msg = "<span class='success'>বিজ্ঞাপন চালু করা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function pauseMarquee($id){
        $id = $this->fm->validation($id);
        $id = mysqli_real_escape_string($this->db->link, $id);

        $sql = "UPDATE tbl_announcement SET status = 0 WHERE id = $id";
        $run = $this->db->delete($sql);
        if ($run){
            $msg = "<span class='success'>বিজ্ঞাপন সাময়িকভাবে বন্ধ রাখা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function updateMarquee($id, $marquee){
        $id = $this->fm->validation($id);
        $id = mysqli_real_escape_string($this->db->link, $id);

        $marquee = $this->fm->validation($marquee);
        $marquee = mysqli_real_escape_string($this->db->link, $marquee);

        if (empty($marquee)){
            $msg = "<span class='error'>ঘরের মধ্য কিছু ম্যাসেজ লিখুন</span>";
            return $msg;
        }else{
            $sql = "UPDATE tbl_announcement SET announcement = '$marquee' WHERE id = $id";
            $run = $this->db->delete($sql);
            if ($run){
                $msg = "<span class='success'>বিজ্ঞাপন সফলভাবে সংস্কার করা হয়েছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function getMarquee($id){
        $id = mysqli_real_escape_string($this->db->link, $id);

        $sql = "SELECT * FROM tbl_announcement WHERE id = $id";
        $run = $this->db->select($sql);
        return $run;
    }

    public function websiteInfoUpdate($sitename, $copyright, $description){
        $sitename = mysqli_real_escape_string($this->db->link, $sitename);
        $sitename = $this->fm->validation($sitename);

        $copyright = mysqli_real_escape_string($this->db->link, $copyright);
        $copyright = $this->fm->validation($copyright);

        $description = mysqli_real_escape_string($this->db->link, $description);
        $copyright = $this->fm->validation($copyright);

        if (empty($sitename) && empty($copyright)){
            $msg = "<span class='error'>ওয়েবসাইটের নাম এবং কপিরাইটের ম্যাসেজ লিখুন</span>";
            return $msg;
        }else{
            $sql = "UPDATE tbl_websiteinfo SET websiteName='$sitename', copyright= '$copyright', description='$description' ";
            $run = $this->db->update($sql);
            if ($run){
                $msg = "<span class='success'>ওয়েবসাইটের তথ্যগুলো সঠিকভাবে সংস্করণ করা হয়েছে</span>";
                return $msg;
            }
        }
    }
}