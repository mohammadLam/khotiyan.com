<?php
    include_once "lib/Database.php";
    include_once "helpers/format.php";

class User{

    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function userDetails($userid){
        $sql = "SELECT * FROM table_user WHERE id = $userid";
        $run = $this->db->select($sql);
        return $run;
    }

    public function usersingup($user, $userRole = 1){
        $username     = mysqli_real_escape_string($this->db->link, $user['username']) ;
        $usermail     = mysqli_real_escape_string($this->db->link, $user['usermail']) ;
        $userphone    = mysqli_real_escape_string($this->db->link, $user['phone']) ;
        $address      = mysqli_real_escape_string($this->db->link, $user['address']) ;
        $userpass     = mysqli_real_escape_string($this->db->link, md5($user['userpass'])) ;
        $repass       = mysqli_real_escape_string($this->db->link, md5($user['repass'])) ;
        $sani         = filter_input(INPUT_POST, 'usermail', FILTER_VALIDATE_EMAIL);
        $status = 0;  // admin approve

        $sql = "SELECT username from table_user WHERE username = '$username' AND email = '$usermail'";
        $isUserHere = $this->db->select($sql);

        if(empty($username) || empty($usermail) || empty($address) || empty($userpass) || empty($repass)){
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }
        
        elseif (!$sani){
            $msg = "<span class='error'>আপনার মেইল ঠিক হয়নি</span>";
            return $msg;
        }
        
        else{
            if($isUserHere){
                $msg = "<span class='error'>ইউজারটির নাম ইতিমধ্যে ডাটাবেজে রয়েছে, অন্য নাম দিয়ে চেষ্টা করুন</span>";
                return $msg;
            }
            
            elseif($userpass != $repass){
                $msg = "<span class='error'>পাসওয়ার্ড মিলেনি</span>";
                return $msg;
            }
            
            else{
                $sql = "INSERT INTO table_user(username, password, email, address, phone, role, status) 
                VALUES('$username', '$userpass', '$usermail', '$address', '$userphone', $userRole, $status)";
                $run = $this->db->insert($sql);

                if($run){
                    $msg = "<span class='success'>আপনার অ্যাকাউন্টের তথ্যগুলো আমরা পেয়েছি। অ্যাডমিন অ্যাপ্রুভ করলেই আপনার অ্যাকাউন্টে আপনি লগইন করতে পারবেন</span>";
                    return $msg;
                }
                
                else {
                    $msg = "<span class='error'>Something went wrong</span>";
                    return $msg;
                }
            }
        }
    }

    public function userdetailsUpdate($userid, $username, $usermail, $address, $phone){
        $userid   = mysqli_real_escape_string($this->db->link, $userid);
        $username = mysqli_real_escape_string($this->db->link, $username);
        $usermail = mysqli_real_escape_string($this->db->link, $usermail);
        $address  = mysqli_real_escape_string($this->db->link, $address);
        $phone    = mysqli_real_escape_string($this->db->link, $phone);

        if(empty($username) || empty($usermail)){
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }
        
        else{
            $sql = "UPDATE table_user SET username = '$username', email = '$usermail', address = '$address', phone = '$phone' WHERE id = $userid ";
            $run = $this->db->update($sql);

            if ($run) {
                $msg = "<span class='success'>ইউজারের তথ্য সংস্করণ সফল হয়েছে</span>";
                return $msg;
            } 
            
            else {
                $msg = "<span class='error'>Something went wrong</span>";
                return $msg;
            }
        }
    }

    public function changeUserPass($userid, $oldpass, $newpass, $repass){
        $oldpassword = mysqli_real_escape_string($this->db->link, $oldpass);
        $newpassword = mysqli_real_escape_string($this->db->link, $newpass);
        $repassword  = mysqli_real_escape_string($this->db->link, $repass);
        $validpass = md5($newpass);

        $sql = "SELECT password FROM table_user WHERE id= '$userid' ";
        $run = $this->db->select($sql);
        $checkpass = $run->fetch_assoc();

        if(empty($oldpassword) || empty($newpassword) || empty($repassword)){
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        }
        
        elseif($checkpass['password'] != md5($oldpassword)){
            $msg = "<span class='error'>পুরাতন পাসয়ার্ড ভুল</span>";
            return $msg;
        }
        
        elseif($newpassword != $repassword){
            $msg = "<span class='error'>Retype password not matching</span>";
            return $msg;
        }
        
        else{
            $sql = "UPDATE table_user SET password = '$validpass' WHERE id = '$userid' ";
            $run = $this->db->update($sql);
            if($run){
                $msg = "<span class='success'>পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে</span>";
                return $msg;
            }
        }
    }

    public function getUserList(){
        $sql = "SELECT * FROM table_user WHERE status = 1 AND role ORDER BY role DESC";
        $run = $this->db->select($sql);
        return $run;
    }

    public function deleteuserById($userid){
        $userid = mysqli_real_escape_string($this->db->link, $userid);
        $sql = "DELETE FROM table_user WHERE id = '$userid' ";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "<span class='success'>ইউজার মুছে ফেলা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function getRequestUser(){
        $sql = "SELECT * FROM table_user WHERE status = 0";
        $run = $this->db->select($sql);
        return $run;
    }

    public function confirmUser($userid){
        $userid = mysqli_real_escape_string($this->db->link, $userid);
        $sql = "UPDATE table_user SET status=1 WHERE id = '$userid'";
        $run = $this->db->update($sql);
        if($run){
            $msg = "<span class='success'>ইউজারকে ওয়েবসাইটে অনুমোদন করা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function declineRequest($userid){
        $userid = mysqli_real_escape_string($this->db->link, $userid);
        $sql = "DELETE FROM table_user WHERE id = '$userid'";
        $run = $this->db->delete($sql);
        if ($run) {
            $msg = "<span class='success'>ইউজারের তথ্য মুছে ফেলা হয়েছে</span>";
            return $msg;
        }else{
            $msg = "<span class='error'>Something went wrong</span>";
            return $msg;
        }
    }

    public function forgotPassword($email){

        $email= mysqli_real_escape_string($this->db->link, $email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // এটি মেইলকে সঠিকভাবে সাজাবে
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);  // মেইলটি সঠিক কী না চেক করবে

        if (!$email){
            $msg = "<p class='error'>আপনার মেইলটি সঠিক হয়নি</p>";
            return $msg;
        }else{
            $sql = "SELECT email FROM table_user WHERE email = '$email' ";
            $run = $this->db->select($sql);
            if (!$run){
                $msg = "<p class='error'>আপনার মেইল দিয়ে তৈরি করা কোন অ্যাকাউন্ট নেই</p>";
                return $msg;
            } else{
                $from = "contact@khotiyan.com";
                $to = $email;

                $subject = 'আপনার মেইলের পাসওয়ার্ড পরিবর্তন করুন';

                $expFormat = mktime( date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
                $expDate   = date("Y-m-d H:i:s",$expFormat);
                $key = md5($email);
                $addKey = substr(md5(uniqid(rand(),1)),3,10);
                $key = $key . $addKey;

                $sql = "INSERT INTO `tbl_temp-pass` (`email`, `temp_key`, `expDate`) VALUES ('$email', '$key', '$expDate')";
                $run = $this->db->insert($sql);
                
                // Create email headers
                $headers .= 'From: '.$from."\r\n".'Reply-To: '.$to."\r\n" .'X-Mailer: PHP/' . phpversion();
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                // Compose a simple HTML email message
                $message = '<!doctype html>
                <html lang="en-US">

                <head>
                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                    <title>Reset Password Email Template</title>
                    <meta name="description" content="Reset Password Email Template.">
                    <style type="text/css">
                        a:hover {text-decoration: underline !important;}
                    </style>
                </head>

                <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
                    <!--100% body table-->
                    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
                        <tr>
                            <td>
                                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                                    align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="height:80px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                        <a href="https://khotiyan.com" title="logo" target="_blank"><h2>খতিয়ান.কম</h2></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:20px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                                <tr>
                                                    <td style="height:40px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0 35px;">
                                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;">আপনি পাসওয়ার্ড পরিবর্তনের জন্য আবেদন করছেন</h1>
                                                        <span
                                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                            We cannot simply send you your old password. A unique link to reset your
                                                            password has been generated for you. To reset your password, click the
                                                            following link and follow the instructions.
                                                        </p>
                                                        <a href="https://khotiyan.com/changeforgotpass.php?tokenKey='.$key.'&email='.$email.'"
                                                            style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">পাসওয়ার্ড পরিবর্তন করুন</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:40px;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    <tr>
                                        <td style="height:20px;">&nbsp;</td>
                                    </tr>
                                    <tr></tr>
                                    <tr>
                                        <td style="height:80px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>

                </html>';

                $sendmail = mail($to, $subject, $message, $headers);

                if ($sendmail && $run) {
                    $msg = '<p class="success">আপনাকে একটি মেইল পাঠানো হয়েছে। ২৪ ঘন্টার মধ্যে ভিজিট করুন</p>';
                    return $msg;
                }
            }
        }

    }

    public function resetpassword($userReset){
        $tokenKey = mysqli_real_escape_string($this->db->link, $userReset['token']);
        $password = mysqli_real_escape_string($this->db->link, $userReset['password']);
        $repass   = mysqli_real_escape_string($this->db->link, $userReset['repass']);
        $email    = mysqli_real_escape_string($this->db->link, $userReset['email']);

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);  // এটি মেইলকে সঠিকভাবে সাজাবে
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);  // মেইলটি সঠিক কী না চেক করবে

        if (empty($tokenKey) || empty($email) || empty($password) || empty($repass)){
            $msg = "<span class='error'>সবগুলো ঘর পূরণ করুন</span>";
            return $msg;
        } else {
            $checkToken = "SELECT * FROM `tbl_temp-pass` WHERE temp_key = '$tokenKey' ";
            $runCheckToken = $this->db->select($checkToken);

            if (!$runCheckToken) {
                $msg = "<p class='error'>আপনার টোকেনের তারিখ শেষ হয়ে গিয়েছে <br> অথবা টোকেনটি সঠিক নয়</p>";
                return $msg;
            }

            elseif (!$email){
                $msg = "<p class='error'>আপনার মেইলটি সঠিক হয়নি</p>";
                return $msg;
            }

            elseif ($password != $repass){
                $msg = "<p class='error'>আপনার দেওয়া পাসয়ার্ডগুলো মেলেনি</p>";
                return $msg;
            }

            else {
                $password = md5($password);
                $sql = "UPDATE table_user SET password = '$password' WHERE email = '$email' ";
                $run = $this->db->update($sql);

                $deleteToken    = "DELETE FROM `tbl_temp-pass` WHERE email = '$email' ";
                $runDeleteToken = $this->db->delete($deleteToken);

                if($run && $runDeleteToken){
                    $msg = "<span class='success'>পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে</span>";
                    return $msg;
                }
            }

        }
    }

}