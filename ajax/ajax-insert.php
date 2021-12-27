<?php

$conn = mysqli_connect("localhost", "idzklkhr_udc", "N5CRFTEPQKmgD4a", "idzklkhr_udc") or die("Connection failed");
mysqli_set_charset($conn, "utf8");



//get all value from front-end using ajax

if ($_POST['type'] == "insertKho") {

    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];
    $mouja = $_POST['mouja'];
    $kho_type = $_POST["khotiyanType"];
    $kho_No = $_POST["khotiyanNo"];
    $daagNo = $_POST["daagNo"];
    $isEnter;


    $daag = preg_replace('/[ ,]+/', ',',$daagNo);  // replace whitespace from  data
    // echo $daag;
    $daag_array = explode(",", $daag);
    $daagNo = json_encode($daag_array);

    /// check this khotiyan allready have or not
    $sql = "SELECT khotiyan FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla AND mouja = $mouja AND $kho_type != '' AND khotiyan = $kho_No ";
    $run = mysqli_query($conn, $sql) or die("Query failed");
    if (mysqli_num_rows($run) > 0) {
        $isEnter = 1;
    }


    if (empty($division) || empty($zilla) || empty($upazilla) || empty($mouja) || empty($kho_type) || empty($kho_No) || empty($daagNo)) {
        echo 2;  // field must not be empty
    } elseif($isEnter == 1){
        echo 4;  // allready this khotiyan have on database
    }else {
        $sql = "INSERT INTO tbl_khotiyan ($kho_type, khotiyan, mouja, upazilla, zilla, division) VALUES ('$daagNo', '$kho_No', '$mouja', '$upazilla', '$zilla', '$division')";
        //if mysqli query run successfully then return 1

        if (mysqli_query($conn, $sql)) {
            echo 1;  //  খতিয়ান সফলভাবে সংযুক্ত করা হয়েছে
        } else {
            echo 0; // Something went wrong

        }

    }

}