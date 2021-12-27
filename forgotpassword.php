<?php include 'class/User.php'; ?>
<?php
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $forgotpass = $user->forgotPassword($email);
}
?>
<html>
<head>
    <title>পাসয়ার্ড ভুলে গেছেন - খতিয়ান.কম</title>
    <meta content="আমাদের এই সাইটটি মূলত একটি ব্যাবসায়িক সাইট। আপনি এখানে আপনার জমির দাগ নম্বর, খতিয়ান নাম্বার দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আবার আপনার জমির খতিয়ান নাম্বার, দাগ নম্বর দিয়ে ১০ সেকেন্ডের মধ্য বের করতে পারবেন। আপনি আমাদের সাইটে লগইন করলেই ১০টি খতিয়ান নম্বর ফ্রীতে বের করতে পারবেন। এরপর আপনাকে ১০ টাকা করে রিচার্জ করতে হবে একটি খতিয়ানের জন্য" name="description"/>
    <meta content="harunur rashid | হারুনুর রশীদ" name="author"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/jpg" href="image/favicon.png"/>
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login">
    <form action="" method="POST">
        <img src="image/avatar.png" width="100px"><br>
        <?php
            if (isset($forgotpass)){
                echo $forgotpass;
            }
        ?>
        <input type="mail" class="inputext" name="email" placeholder="আপনার ইমেইল লিখুন" required /><br>
        <input type="submit" class="inputbtn" name="submit" value="আমার পাসওয়ার্ড মেইল করুন"/>
        <p style="color: red;"><a href="login.php">লগইন করুন</a></p>
        <p style="color: royalblue;"><a href="createaccount.php">নতুন অ্যাকাউন্ট খুলুন</a></p>
    </form>
</div>
</body>
</html>