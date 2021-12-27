<?php

include "inc/header.php";



// only admin can access this page

if ($user_role != 3) {

    header("Location: 404.php");

}



//get union id from url

if (!empty($_GET['updateDivision']) || $_GET['updateDivision'] == '') {

    $id = $_GET['updateDivision'];

} else {

    header("Location: 404.php");

}



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['back'])) {

    header("Location: division.php");

}



//if clicked submit button

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $divisionEN = $_POST['divisionEN'];

    $divisionBN = $_POST['divisionBN'];

    $updateDivision = $div->updateDivision($id, $divisionEN, $divisionBN);

}

?>

<div class="container">

    <h3 class="pt-3">বিভাগ সংস্কার করুনঃ</h3>

    <?php

    if (isset($updateDivision)) {

        echo $updateDivision;

    }

    ?>

    <div class="row">

        <div class="col-md-7">

            <form method="post">

                <?php

                $getDivisionById = $div->getDivisionById($id);

                if ($getDivisionById) {

                    while ($result = $getDivisionById->fetch_assoc()) { ?>

                        <div class="form-group">

                            <label for="divisionBN">বিভাগের নাম লিখুন</label>

                            <input type="text" value="<?php echo $result['divisionBn']; ?>"
                                   placeholder="বিভাগের নাম লিখুন" id="divisionBN" name="divisionBN"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="divisionEN">Enter division name</label>
                            <input type="text" value="<?php echo $result['divisionEn']; ?>"
                                   placeholder="Enter division name" id="divisionEN" name="divisionEN"
                                   class="form-control"/>

                        </div>

                    <?php }

                } ?>
                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">
            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>