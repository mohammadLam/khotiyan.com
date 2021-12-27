<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include($filepath . '/../lib/Database.php');
include($filepath . '/../lib/Cookie.php');
include($filepath . '/../helpers/format.php');
$fm = new format();
$db = new Database();
$output = "";

/* <===================== Get user id using md5 and for loop ======================> */
$userid = $_COOKIE['userid'];
for ($i = 1; $i < 100; $i++){
    if (md5($i) == $userid){
        $userid = $i;
        break;
    }
}

// ====================================== খতিয়ান নম্বর পাওয়ার লজিক শুরু ============================================/
if ($_POST['type'] == "getKhoByDaag") {
    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];
    $mouja = $_POST['mouja'];
    $kho_type = $_POST["khotiyanType"];
    $daagNo = $_POST["daagNo"];

    //check have point or not

    if ($userid) { // for registration user
        $sql = "SELECT point FROM table_user WHERE id = $userid";
        //get user id
        $run = $db->select($sql);
        if ($run) {
            while ($result = $run->fetch_assoc()) {
                $point = $result['point']; // store user point in $point variable
            }
        }
    } 
    
    else { // for new user
        $point = $_COOKIE["total_point"];  // store user point in $point variable
    }
    // finish store point in, $point variable

    if ($point <= 0) {
        echo 1; // if balance have insufficent then return this -------------------------
    } 
    
    else {
        // get data from mysql database
        $sql = "SELECT khotiyan, $kho_type FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla AND mouja = $mouja AND $kho_type != '' ";
        $run = $db->select($sql);
        $isEnter = false;
        if ($run) {
            $output = "<table class='table-list' style='margin-top: 15px'><tr><th>ক্রমিক নং</th><th>দাগ নং</th><th>খতিয়ান নম্বর</th></tr>";
            $i = 0;
            while ($result = $run->fetch_assoc()) {
                $temp = json_decode($result["$kho_type"], true);  // decode json data to array

                if (in_array($daagNo, $temp)) { // if user define daag no, available on $temp array then statement is true
                    $isEnter = true; // this is enter variable
                    $i++;
                    $counter = $fm->engToBangla($i);
                    $daag = $fm->engToBangla($daagNo);
                    $khotiyan = $fm->engToBangla($result['khotiyan']);
                    $output .= "<tr><td>$counter</td><td>$daag</td><td>$khotiyan</td></tr>";
                }
            }
            $output .= "</table>";
        }

        // if enter this statement then point should be minus
        if ($isEnter) {
            if ($userid) {  // minus registration user balance
                $sql = "UPDATE table_user SET point = point - 10 WHERE id = '$userid' ";
                $run = $db->update($sql);

            } else { // minus new user balance
                setcookie('total_point', $point - 10);
            }
            echo $output; // show khotiayn no -----------
        } else {
            echo 0; // not found any khoriyan data........................................
        }
    }
}
// ====================================== খতিয়ান নম্বর পাওয়ার লজিক শেষ ============================================//


// ====================================== দাগ নম্বর পাওয়ার লজিক শুরু ============================================//

if ($_POST['type'] == "getDaagByKho") {
    // get all value from front end page using ajax
    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];
    $mouja = $_POST['mouja'];
    $kho_type = $_POST["khotiyanType"];
    $khotiyan = $_POST["khotiyanNo"];

    // get full rs/cs/sa/ khotiyan list where
    $sql = "SELECT $kho_type FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla AND mouja = $mouja AND khotiyan = $khotiyan AND $kho_type != '' ";
    $run = $db->select($sql);

    if ($run) {
        $output = "<table class='table-list' style='margin-top: 15px'><tr><th>ক্রমিক নং</th><th>খতিয়ান নং</th><th>দাগ নম্বর</th></tr>";
        $i = 0;
        while ($result = $run->fetch_assoc()) {
            $i++;
            $daag = $fm->unserializeData($result["$kho_type"]);
            $counter = $fm->engToBangla($i);
            $khotiyan = $fm->engToBangla($khotiyan);
            $output .= "<tr><td>$counter</td><td>$khotiyan</td><td>$daag</td></tr>";
        }

        $output .= "</table>";
        echo $output;   // show data from mysql database------------------------------

    } else {
        echo 0;   // not found any khoriyan data........................................
    }
}

// ====================================== দাগ নম্বর পাওয়ার লজিক শেষ ============================================ //


// ====================================== লোড সব ============================================ //
if ($_POST['type'] == "load_upazilla_for_update_mouja") {
    $mouja = $_POST['mouja'];

    $sql = "SELECT * FROM tbl_mouja WHERE id = $mouja";
    $run = $db->select($sql);
    $output = "";

    if ($run) {
        while ($result = $run->fetch_assoc()) {
            $upazilla = $result["upazilla"];
            $zilla = $result["zilla"];
            $division = $result["division"];
        }

        $sql = "SELECT * FROM tbl_upazilla WHERE id = $upazilla";
        $run = $db->select($sql);
        while ($result = $run->fetch_assoc()) {
            $output .= "";
        }
    }
}