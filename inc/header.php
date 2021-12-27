<?php
ob_start();

// Set cookie
if (!isset($_COOKIE["total_point"])) {
    date_default_timezone_set("Asia/Dhaka");
    setcookie("total_point", 100, time()+(60*60));
}

include "lib/Database.php";
include "lib/session.php";
// include "lib/Cookie.php";
include "helpers/format.php";
include "class/khotiyanClass.php";
include "class/divisionClass.php";
include "class/zillaClass.php";
include "class/moujaClass.php";
include "class/upazillaClass.php";
include "class/User.php";

// define class object

$db = new Database();
$fm = new format();
$kho = new khotiyan();
$div = new Division();
$zilla = new Zilla();
$upazilla = new Upazilla();
$mouja = new Mouja();
$user = new User();

// get user role
if (isset($_COOKIE["role"])) {
    $user_role = $_COOKIE["role"];
}

/* <===================== Created cookie value ======================> */
$normalUser = 'c4ca4238a0b923820dcc509a6f75849b';
$ediorUser  = 'c81e728d9d4c2f636f067f89cc14862c';
$adminUser  = 'eccbc87e4b5ce2fe28308fd9f2a7baf3';
$adminlogin = 'b326b5062b2f0e69046810717534cb09';

/* <===================== Set user role ======================> */
$getUserRole = $_COOKIE['role']; // get user role

if ($getUserRole === $adminUser){
    $user_role = 3;
}elseif ($getUserRole === $ediorUser){
    $user_role = 2;
}elseif ($getUserRole === $normalUser){
    $user_role = 1;
}else{
    $user_role = NULL;
}

/* <===================== Get user id using md5 and for loop ======================> */
$userid = $_COOKIE['userid'];
for ($i = 1; $i < 100; $i++){
    if (md5($i) == $userid){
        $userid = $i;
        break;
    }
}

/* <===================== if user login is not true ======================> */
if ($_COOKIE['adminlogin'] != $adminlogin || $_COOKIE['userid'] != md5($userid) || $_COOKIE['role'] != md5($user_role)){
    setcookie('userid', false, 1);
    setcookie('role', false, 1);
    setcookie('adminlogin', false, 1);
    header("Location: login.php");
}

/* <===================== User logout logic ======================> */
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    header("Location: login.php");
    setcookie('userid', false, 1);
    setcookie('role', false, 1);
    setcookie('adminlogin', false, 1);
}

/* <===================== Set point cookie ======================> */
if (!isset($_COOKIE["total_point"])) {
    setcookie('total_point', 100);
}

/* <===================== get website details ======================> */
$siteinfoQuery = "SELECT * FROM tbl_websiteinfo WHERE id = 1";
$runQuery = $db->select($siteinfoQuery);
if ($runQuery){
    while ($result = $runQuery->fetch_assoc()){
        $sitename = $result['websiteName'];
        $description = $result['description'];
        $copyright = $result['copyright'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta content="<?php echo $description;?>" name="description"/>
    <meta content="harunur rashid | হারুনুর রশীদ" name="author"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <title><?php echo $fm->dynamicTitle() ?></title>

    <link rel="shortcut icon" type="image/jpg" href="image/favicon.png"/>

    <!-- select2 extension css -->
    <link href="css/select2.min.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> -->

    <!--    css file attach-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/messagelist.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/animation.css">

    <!-- font file -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!--    javascript file attach-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.bootstrap-growl.min.js"></script>

    <!-- select2 extension jquery -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<body>

    <!--this is animation section-->
    <div class="anim">
        <div class="box">
            <div class="hero-anim-bottom-left"></div>
            <div class="hero-anim-middle"></div>
            <div class="hero-anim-top-right"></div>
        </div>
    </div>

    <!--this is header section-->
    <nav class="navbar navbar-expand-md position-sticky sticky-top p-0">
        <a class="navbar-brand pl-sm-5 pl-3 text-dark" href="index.php"><?php echo $sitename;?></a>
        <button class="navbar-toggler pr-sm-5 pr-3" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="fa fa-caret-down text-dark"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                $path = $_SERVER['SCRIPT_FILENAME'];
                $title = basename($path, '.php');



                if ($user_role == 1 || $user_role == 2 || $user_role == 3 || $user_role == 4){
                    echo "<li class='nav-item'><a class='nav-link' href='index.php'>হোম</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='myaccount.php'>অ্যাকাউন্ট</a></li>";
    
                    if ($user_role == 3){  //for admin
                        echo "<li class='nav-item'><a class='nav-link' href='dashboard.php'>ড্যাশবোর্ড</a></li>";
                    }
                    elseif ($user_role == 2){ // for editor
                        echo "<li class='nav-item'><a class='nav-link' href='khotiyan.php'>খতিয়ান</a></li>";
                    }
    
                    if ($user_role != 3){  // not for admin
                        echo "<li class='nav-item'><a class='nav-link' href='contact.php'>যোগাযোগ</a></li>";
                    }
    
                    echo "<li class='nav-item pr-5'><a class='nav-link login' href='?logout=1'>লগআউট</a></li>";
                }
                else{
                    echo "<li class='nav-item pr-5'><a class='nav-link login' href='login.php'>লগইন</a></li>";
                }

                ?>

            </ul>
        </div>
    </nav>