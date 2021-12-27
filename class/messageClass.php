<?php
include_once "lib/Database.php";
include_once "helpers/format.php";

class Message
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();

    }

    public function sendMessage($userid, $subject, $message, $from = "contact@khotiyan.com"){

        // get user details -----------------------
        $sql = "SELECT * FROM table_user WHERE id = $userid ";
        $run = $this->db->select($sql);

        if ($run){
            while ($result = $run->fetch_assoc()){
                $username = $result["username"];
                $usermail = $result["email"];

            }
        }

        // validation user data ====================
        $subject = $this->fm->validation($subject);
        $subject = mysqli_real_escape_string($this->db->link, $subject);

        $message = $this->fm->validation($message);
        $message = mysqli_real_escape_string($this->db->link, $message);


        if (empty($username) || empty($usermail) || empty($subject) || empty($message)) {
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;

        }else{

            $sql = "INSERT INTO tbl_message (userid, subject, message) VALUES ('$userid', '$subject', '$message') ";
            $run = $this->db->insert($sql);
            $sendmail = mail($from, $subject, $message, $usermail);

            if ($sendmail && $run){
                $msg = "<span class='success'>আপনার বার্তাটি আমাদের কাছে পৌছে গেছে</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }

    }



    public function messagelist(){
        $sql = "SELECT tbl_message.id, username, email, subject, message, date FROM  table_user, tbl_message WHERE tbl_message.userid = table_user.id";
        $run = $this->db->select($sql);
        return $run;
    }

    public function delete_msg($id){
        $sql = "DELETE FROM tbl_message WHERE id='$id' ";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "<span class='success'>ম্যাসেজ মুছে ফেলা হয়েছে</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function get_messageById($msgid){
        $sql = "SELECT tbl_message.id, table_user.id AS userid, username, email, subject, message FROM  table_user, tbl_message WHERE tbl_message.userid = table_user.id AND tbl_message.id = $msgid ";
        $run = $this->db->select($sql);
        return $run;
    }

}