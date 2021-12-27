<?php
include "inc/header.php";
include "class/messageClass.php";
$msg = new Message();

$sql = "SELECT * FROM table_user WHERE id = $userid ";
$run = $db->select($sql);
if ($run){
    while ($result = $run->fetch_assoc()){
        $username = $result["username"];
        $usermail = $result["email"];
    }
}

// ----------------------------------



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $sendmessage = $msg->sendMessage($userid, $subject, $message);
    // got user id from header
}

?>



<div class="container">
    <h3 class="pt-3">আপনার অভিযোগ, মতামত আমাদের জানানঃ</h3>
    <?php
    if (isset($sendmessage)){
        echo $sendmessage;
    }

    ?>

    <div class="row">

        <div class="col-md-7">

            <form method="post">

                <div class="form-group">

                    <label for="username">আপনার নাম</label>

                    <input type="text" id="username" value="<?php echo $username;?>" name="username" class="form-control" readonly/>

                </div>



                <div class="form-group">
                    <label for="usermail">আপনার মেইল</label>
                    <input type="text" id="usermail" value="<?php echo $usermail;?>" name="usermail" class="form-control" readonly/>
                </div>



                <div class="form-group">
                    <label for="subject">আপনার মতামতের বিষয়</label>
                    <input type="text" id="subject" name="subject" class="form-control"/>
                </div>



                <div class="form-group">
                    <label for="message">আপনার মতামত</label>
                    <textarea class="form-control" name="message" id="message" cols="30" rows="10"></textarea>
                </div>

                <button class="btn btn-primary" id="submit"><i class="fa fa-mail-reply"></i>&numsp;পাঠিয়ে দিন</button>

            </form>

        </div>

    </div>

</div>

<?php include "inc/footer.php";?>