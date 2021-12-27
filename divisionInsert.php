<?php

include "inc/header.php";



// only admin can access this page

if ($user_role != 3) {
    header("Location: 404.php");
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $divisionNameBN = $_POST['divisionBN'];
    $divisionNameEN = $_POST['divisionEN'];
    $addDivision = $div->addDivision($divisionNameEN, $divisionNameBN);
}



if (isset($_POST['back'])) {
    header("Location: division.php");
}

?>

<div class="container">
    <h3 class="pt-3">বিভাগ তৈরি করুনঃ</h3>
    <?php
    if (isset($addDivision)) {
        echo $addDivision;
    }
    ?>

    <div class="row">
        <div class="col-md-7">
            <form method="post">

                <div class="form-group">
                    <label for="divisionBN">বিভাগের নাম লিখুন</label>
                    <input type="text" placeholder="বিভাগের নাম লিখুন" id="divisionBN" name="divisionBN" class="form-control"/>
                </div>



                <div class="form-group">
                    <label for="divisionEN">Enter division name</label>
                    <input type="text" placeholder="Enter division name" id="divisionEN" name="divisionEN" class="form-control"/>
                </div>

                <input class="btn btn-primary" type="submit" value="যোগ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>