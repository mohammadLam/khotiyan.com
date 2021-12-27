<?php
$conn = mysqli_connect("localhost", "idzklkhr_udc", "N5CRFTEPQKmgD4a", "idzklkhr_udc") or die("Connection failed");
mysqli_set_charset($conn, "utf8");

if ($_POST['type'] == 'division') {
    $sql = "SELECT * FROM tbl_division";
    $result = mysqli_query($conn, $sql) or die("Query failed");
    $output = "";

    if (mysqli_num_rows($result) > 0) {
        $output = "<select id='select-division'><option value='0'>একটি বিভাগ নির্বাচন করুন</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($_POST['division']) && $row['id'] == $_POST['division']) {
                $output .= "<option value='{$row["id"]}' selected='selected' >{$row['divisionBn']}</option>";
                continue;
            }
            $output .= "<option value='{$row["id"]}'>{$row['divisionBn']}</option>";
        }

        $output .= "</select>";
        mysqli_close($conn);
        echo $output;
    } else {
        echo "<h2>কোন বিভাগ খুজে পাওয়া যায়নি</h2>";
    }
} elseif ($_POST['type'] == 'zilla') {
    $division = $_POST['division'];
    $sql = "SELECT * FROM tbl_zilla WHERE division = $division";
    $result = mysqli_query($conn, $sql) or die("Query failed");
    $output = "";

    if (mysqli_num_rows($result) > 0) {
        $output = "<select id='select-zilla'><option value='0'>একটি জেলা নির্বাচন করুন</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($_POST['zilla']) && $row['id'] == $_POST['zilla']) {
                $output .= "<option value='{$row["id"]}' selected >{$row['zillaBN']}</option>";
                continue;
            }
            $output .= "<option value='{$row["id"]}'>{$row['zillaBN']}</option>";
        }
        $output .= "</select>";
        mysqli_close($conn);
        echo $output;
    } else {
        echo "<option>কোন জেলা খুজে পাওয়া যায়নি</option>";
    }

} elseif ($_POST['type'] == 'upazilla') {
    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $sql = "SELECT * FROM tbl_upazilla WHERE division = $division AND zilla = $zilla";
    $result = mysqli_query($conn, $sql) or die("Query failed");
    $output = "";

    if (mysqli_num_rows($result) > 0) {
        $output = "<select id='select-zilla'><option value=''>একটি উপজেলা নির্বাচন করুন</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($_POST['upazilla']) && $row['id'] == $_POST['upazilla']) {
                $output .= "<option value='{$row["id"]}' selected >{$row['upazillaBN']}</option>";
                continue;
            }
            $output .= "<option value='{$row["id"]}'>{$row['upazillaBN']}</option>";
        }
        $output .= "</select>";
        mysqli_close($conn);
        echo $output;
    } else {
        echo "<option>কোন উপজেলা খুজে পাওয়া যায়নি</option>";
    }

} elseif ($_POST['type'] == 'mouja') {

    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];

    $sql = "SELECT * FROM tbl_mouja WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla ORDER BY moujaEn ASC";
    $result = mysqli_query($conn, $sql) or die("Query failed");
    $output = "";

    if (mysqli_num_rows($result) > 0) {
        $output = "<select id='select-zilla'><option value=''>একটি মৌজা নির্বাচন করুন</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<option value='{$row["id"]}'>{$row['moujaBn']}</option>";
        }
        $output .= "</select>";
        mysqli_close($conn);
        echo $output;
    } else {
        echo "<option>কোন মৌজা খুজে পাওয়া যায়নি</option>";
    }
}