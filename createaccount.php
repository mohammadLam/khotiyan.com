<?php 
include 'class/adminlogin.php';
include 'class/User.php';
$adlogin = new adminlogin();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usersingup = $user->usersingup($_POST);
}

?>
<html>
<head>
    <title>অ্যাকাউন্ট খুলুন</title>
    <meta content="আমাদের এই সাইটটি মূলত একটি ব্যাবসায়িক সাইট। আপনি এখানে আপনার জমির দাগ নম্বর, খতিয়ান নাম্বার দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আবার আপনার জমির খতিয়ান নাম্বার, দাগ নম্বর দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আপনি আমাদের সাইটে লগইন করলেই ১০টি খতিয়ান নম্বর ফ্রীতে বের করতে পারবেন। এরপর আপনাকে ১০ টাকা করে রিচার্জ করতে হবে একটি খতিয়ানের জন্য" name="description"/>
    <meta content="harunur rashid | হারুনুর রশীদ" name="author"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/jpg" href="image/favicon.png"/>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/login.css">

</head>
<body>
    <div class="login">
        <form action="" method="POST" enctype="multipart/form-data">
            <img src="image/avatar.png" width="100px"><br>
            <?php 
            if (isset($usersingup)) {
                echo $usersingup;
            }?>
            <input type="text" class="inputext" name="username" placeholder="আপনার নাম লিখুন" required /><br>
            <input type="text" class="inputext" name="phone" placeholder="আপনার ফোন নম্বর লিখুন" required/><br>
            <input type="text" class="inputext" name="address" placeholder="আপনার ঠিকানা লিখুন" required/><br>
            <input type="mail" class="inputext" name="usermail" placeholder="আপনার মেইল লিখুন" required/><br>
            <input type="password" class="inputext" name="userpass" placeholder="একটি পাসওয়ার্ড লিখুন" required /><br>
            <input type="password" class="inputext" name="repass" placeholder="পাসওয়ার্ড পুণরায় লিখুন" required /><br>
            <input type="submit" class="inputbtn" name="submit" value="অ্যাকাউন্ট তৈরি করুন" />
            <p style="color: red;"><a href="login.php">আপনার আক্যাউন্ট আছে? <span style="font-weight: bold">লগইন করুন</span></a></p>
        </form>
    </div>
</body>
</html>