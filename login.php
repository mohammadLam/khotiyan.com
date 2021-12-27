<?php

include 'class/adminlogin.php'; 
$adlogin = new adminlogin();

$adminlogin = $_COOKIE["adminlogin"];
if($adminlogin == 1){
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['userpass']);
    $remember = $_POST['remember'];
    $logincheck = $adlogin->adminlogin($username, $password, $remember);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>খতিয়ান.কম</title>
        <meta content="আমাদের এই সাইটটি মূলত একটি ব্যাবসায়িক সাইট। আপনি এখানে আপনার জমির দাগ নম্বর, খতিয়ান নাম্বার দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আবার আপনার জমির খতিয়ান নাম্বার, দাগ নম্বর দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আপনি আমাদের সাইটে লগইন করলেই ১০টি খতিয়ান নম্বর ফ্রীতে বের করতে পারবেন। এরপর আপনাকে ১০ টাকা করে রিচার্জ করতে হবে একটি খতিয়ানের জন্য" name="description"/>
        <meta content="harunur rashid | হারুনুর রশীদ" name="author"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" type="image/jpg" href="image/favicon.png"/>
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div class="login">
            <form action="login.php" method="POST">
                <img src="image/logo.png" width="100px"><br>
                <?php if (isset($logincheck)) { ?>
                    <p style="color: red;"><?php echo $logincheck; ?></p>

                <?php } ?>
                <input type="text" class="inputext" name="username" placeholder="আপনার নাম অথবা ইমেইল লিখুন" required /><br>
                <input type="password" class="inputext" name="userpass" placeholder="আপনার পাসওয়ার্ড লিখুন" required /><br>
                <div class="remember">
                    <input type="checkbox" value="1" name="remember" id="remember">
                    <label for="remember">&numsp;&numsp;আমাকে মনে রাখুন</label><br>
                </div>
                <input type="submit" class="inputbtn" name="submit" value="লগইন করুন"/>
                <p style="color: red;"><a href="forgotpassword.php">পাসওয়ার্ড ভুলে গেছেন?</a></p>
                <p style="color: royalblue;"><a href="createaccount.php">নতুন অ্যাকাউন্ট খুলুন</a></p>
            </form>
        </div>
    </body>
</html>