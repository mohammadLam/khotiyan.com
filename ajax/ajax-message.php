<?php
$filepath = realpath(dirname(__FILE__));
include($filepath . '/../lib/Database.php');
include($filepath . '/../helpers/format.php');
$fm = new format();
$db = new Database();

// sent message from admin

if ($_POST['type'] == "sent_toUser") {
    $adminmail = $_POST['admin_mail'];
    $usermail = $_POST['user_mail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $subject = $fm->validation($subject);
    $subject = mysqli_real_escape_string($db->link, $subject);

    $message = $fm->validation($message);
    $message = mysqli_real_escape_string($db->link, $message);

    if (empty($adminmail) || empty($usermail) || empty($subject) || empty($message)) {
        echo 0; // field is empty
    }else{
        $sendmail = mail($adminmail, $subject, $message, $usermail);
        if ($sendmail){
            echo 1; // message sent successfully
        }else{
            echo $sendmail;
        }
    }

}