<?php



$conn = mysqli_connect("localhost", "idzklkhr_udc", "N5CRFTEPQKmgD4a", "idzklkhr_udc") or die("Connection failed");
mysqli_set_charset($conn, "utf8");


if ($_POST['type'] == 'division') {

    $id = $_POST['divisionId'];

    $sql = "SELECT * FROM tbl_division WHERE id = $id";

    $result = mysqli_query($conn, $sql) or die("Query failed");



    $output = "";



    if (mysqli_num_rows($result) > 0) {

        $output = "<select id='select-division'><option>একটি বিভাগ নির্বাচন করুন</option>";

        while ($row = mysqli_fetch_assoc($result)) {

            if($row['id'] == $id){

                $output .= "<option value='{$row["id"]}' selected>{$row['divisionBn']}</option>";

            }else{

                $output .= "<option value='{$row["id"]}'>{$row['divisionBn']}</option>";

            }

        }

        $output .= "</select>";



        mysqli_close($conn);



        echo $output;

    }else{

        echo "<h2>বিভাগ খুজে পাওয়া যায়নি</h2>";

    }

}



if ($_POST['type'] == "update_amount"){

    $userid = $_POST['id'];

    $amount = $_POST['bdt'];



    if (empty($userid) || empty($amount)){

        echo 0;

    }else{

        $sql = "UPDATE table_user SET point = '$amount' WHERE id = '$userid' ";

        $result = mysqli_query($conn, $sql) or die("Query failed");



        if ($result){

            echo 1;

        }else{

            echo $result;

        }

    }



}