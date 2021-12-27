<?php
    include "inc/header.php";
    include "class/messageClass.php";
    $msg = new Message();



    //get message id from url

    if (!empty($_GET['msgid']) || $_GET['msgid'] == '') {
        $msgid = $_GET['msgid'];
    } else {
        header("Location: 404.php");
    }



    $get_messageById = $msg->get_messageById($msgid);

    if ($get_messageById) {
        while ($result = $get_messageById->fetch_assoc()) {
            $userid = $result["userid"];
            $username = $result["username"];
            $usermail = $result["email"];
            $subject = $result["subject"];
            $message = $result["message"];

        }

    }

?>



<style>

    .msg_box{

        background: white;
        border-radius: 10px;
        padding: 10px 20px;
        box-shadow: 0px 0px 10px #e0e0e0;
    }

    .subject{
        display: block;
        font-size: 20px;
    }



    .msg_from{
        margin-top: 150px;
        text-align: right;
        bottom: 10px;
        right: 20px;
    }

</style>



<div class="container">

    <h3 class="pt-3">ইউজারের ম্যাসেজ</h3>

    <div class="row">

        <div class="col-md-8">

            <div class="msg_box">

                <span class="subject">বিষয়:&nbsp;<?php echo $subject?></span>

                <br>

                <?php echo $message;?>



                <div class="msg_from">

                    <div style="text-align: center; display: inline-block">

                        <span class="subject">পাঠিয়েছেন -</span>

                        <?php echo $username;?><br>

                    </div>

                </div>

            </div>

        </div><!--col finished-->



        <div class="col-md-4">
            <form action="post">
                <div class="msg_box">
                    <h3>মেইল পাঠান</h3>
                    <p class="success"></p>
                    <p class="error"></p>

                    <div class="form-group">
                        <label for="admin_mail">আপনার মেইল</label>
                        <input type="text" id="admin_mail" class="style_input" value="contact@khotiyan.com" disabled>
                    </div>



                    <div class="form-group">
                        <label for="usermail">ইউজারের মেইল</label>
                        <input type="text" id="usermail" class="style_input" value="<?php echo $usermail;?>" disabled>
                    </div>



                    <div class="form-group">
                        <label for="admin_sub">আপনার ম্যাসেজের বিষয়</label>
                        <input type="text" id="admin_sub" class="style_input">
                    </div>



                    <div class="form-group">
                        <label for="admin_message">আপনার ম্যাসেজ লিখুন</label>
                        <textarea class="style_input" id="admin_message" rows="10"></textarea>
                    </div>
                    <button class="btn btn-primary" id="submit"><i class="fa fa-mail-reply"></i>&numsp;পাঠিয়ে দিন</button>

            </form>

        </div><!--col finished-->



        </div><!--row finished-->

    </div>

</div>

<?php include "inc/footer.php";?>

<script>

    $(document).ready(function () {



        function sentMessageToUser(){
            var adminMail = $("#admin_mail").val();
            var userMail = $("#usermail").val();
            var subject = $("#admin_sub").val();
            var message = $("#admin_message").val();

            $.ajax({
                url: "ajax/ajax-message.php",
                type: "POST",
                data: {
                    type: 'sent_toUser',
                    admin_mail: adminMail,
                    user_mail: userMail,
                    subject: subject,
                    message: message
                },
                success: function (data) {
                    if(data == 1){
                        $(".error").slideUp();
                        $(".success").html("আপনার মেইল পাঠানো হয়েছে").slideDown();
                    }else if(data == 0){
                        $(".success").slideUp();
                        $(".error").html("সবগুলো ঘর পূরণ করুন").slideDown();
                    }else{
                        $(".success").slideUp();
                        $(".error").html(data).slideDown();
                    }
                }
            });
        }

        $("#submit").on("click", function (e) {
            e.preventDefault();
            sentMessageToUser();
        });
        console.log("hi");

    });

</script>