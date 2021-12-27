<?php


class Tranjection
{
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function sendTranjectionInfo($userid, $payment, $amontOfTaka, $tranjectionId, $tranjectionDate, $accountNo){
        $userid = mysqli_real_escape_string($this->db->link, $userid);
        $payment = mysqli_real_escape_string($this->db->link, $payment);
        $amontOfTaka = mysqli_real_escape_string($this->db->link, $amontOfTaka);
        $tranjectionId = mysqli_real_escape_string($this->db->link, $tranjectionId);
        $tranjectionDate = mysqli_real_escape_string($this->db->link, $tranjectionDate);
        $accountNo = mysqli_real_escape_string($this->db->link, $accountNo);

        if (empty($payment) || empty($amontOfTaka) ||empty($tranjectionId) ||empty($tranjectionDate) ||empty($accountNo)){
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }else{
            $sql = "INSERT INTO tbl_tranjection(userid, payment_method, amount, tran_id, tran_date, account_no) VALUES ('$userid', '$payment', '$amontOfTaka', '$tranjectionId', '$tranjectionDate', '$accountNo')";
            $run = $this->db->insert($sql);
            if ($run){
                $msg = "<span class='success'>আপনার তথ্য পাঠানো হয়েছে। কিছুক্ষণ অপেক্ষা করুন</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function tranListByUserId($userid){
        $sql = "SELECT * FROM tbl_tranjection WHERE userid = $userid ORDER BY tran_date DESC";
        $run = $this->db->select($sql);
        return $run;
    }

    public function deleteTranDetailById($id){
        $sql = "DELETE FROM tbl_tranjection WHERE id='$id' ";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "<span class='success'>ট্রানজেকশানের বিবরণ মুছে ফেলা হয়েছে</span>";
            return $msg;
        } else {
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function getTranList(){
        $sql = "SELECT tbl_tranjection.id, username, tran_date, amount, account_no FROM tbl_tranjection, table_user WHERE tbl_tranjection.userid = table_user.id AND tbl_tranjection.operation = 0 ORDER BY tran_date DESC";
        $run = $this->db->select($sql);
        return $run;
    }

    public function addUserBalanceById($userid, $amount, $tranId){
        $userid = mysqli_real_escape_string($this->db->link, $userid);
        $amount = mysqli_real_escape_string($this->db->link, $amount);
        $tranId = mysqli_real_escape_string($this->db->link, $tranId);

        $sql = "UPDATE table_user SET point = point+$amount WHERE id = $userid";
        $run = $this->db->update($sql);

        $query = "UPDATE tbl_tranjection SET operation = 2 WHERE id = $tranId";
        $runQuery = $this->db->update($query);

        if ($run && $runQuery) {
            $msg = "<span class='success'>ইউজারের টাকা যোগ করা হয়েছে</span>"; 
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>"; 
            return $msg;
        }
    }

}