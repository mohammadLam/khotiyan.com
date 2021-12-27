<?php
if ($_POST['type'] == "deleteKhotiyan") {
    $khotiyanId = $_POST["id"];
    $conn = mysqli_connect("localhost", "idzklkhr_udc", "N5CRFTEPQKmgD4a", "idzklkhr_udc") or die("Connection failed");
    mysqli_set_charset($conn, "utf8");
    $sql = "DELETE FROM tbl_khotiyan WHERE id = {$khotiyanId}";
    if(mysqli_query($conn, $sql)){
        echo 1;
    }else{
        echo 0;
    }
}
if ($_POST['type'] == "deleteMouja") {
    $moujaId = $_POST["id"];
    $conn = mysqli_connect("localhost", "idzklkhr_udc", "N5CRFTEPQKmgD4a", "idzklkhr_udc") or die("Connection failed");
    mysqli_set_charset($conn, "utf8");
    $sql = "DELETE FROM tbl_mouja WHERE id = {$moujaId}";
    if(mysqli_query($conn, $sql)){
        echo 1;
    }else{
        echo 0;
    }
}
