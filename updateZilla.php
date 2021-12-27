<?php

include "inc/header.php";



//only admin can access this page

if ($user_role != 3) {

    header("Location: index.php");

}



//get zilla id from url

if (!empty($_GET['updateZilla']) || $_GET['updateZilla'] == '') {

    $id = $_GET['updateZilla'];

} else {

    header("Location: 404.php");

}



if (isset($_POST['back'])) {

    header("Location: zilla.php");

}



//if clicked submit button

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $zillaBN = $_POST['zillaNameBN'];

    $zillaEN = $_POST['zillaNameEN'];

    $division = $_POST['division'];

    $updateZilla = $zilla->updateZilla($id, $zillaEN, $zillaBN, $division);

    // header("Location: zilla.php");

}



// This is for check

$checkDivision = 0;

?>

<div class="container">

    <h3 class="pt-3">জেলা সংস্করণ করুন</h3>

    <?php

    if (isset($updateZilla)) {

        echo $updateZilla;

    }

    ?>

    <div class="row">

        <div class="col-md-7">

            <form method="post" action="">



                <?php

                $getZillaById = $zilla->getZillaById($id);

                if ($getZillaById) {

                    while ($result = $getZillaById->fetch_assoc()) {

                        $checkDivision = $result['division'];

                        ?>

                        <div class="form-input">

                            <label for="zillaNameBN">জেলার নাম লিখুন</label>

                            <input type="text" value="<?php echo $result['zillaBN']; ?>" placeholder="জেলার নাম লিখুন"

                                   id="zillaNameBN" name="zillaNameBN" class="form-control"/>

                        </div>



                        <div class="form-input">

                            <label for="zillaNameEN">Enter zilla name</label>

                            <input type="text" value="<?php echo $result['zillaEN']; ?>" placeholder="Enter zilla name"

                                   id="zillaNameEN" name="zillaNameEN" class="form-control"/>

                        </div>

                    <?php }

                } ?>



                <div class="form-input">

                    <label for="select-division">যে বিভাগের অন্তর্ভুক্ত</label>

                    <select name="division" class="form-control" id="select-division">

                        <?php

                        $getDivisionList = $div->getDivisionList();

                        if ($getDivisionList) {

                            while ($result = $getDivisionList->fetch_assoc()) {

                                ?>

                                <option value="<?php echo $result['id']; ?>" <?php if ($result['id'] == $checkDivision) {

                                    echo 'selected';

                                } ?>><?php echo $result['divisionBn']; ?></option>

                            <?php }

                        } ?>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন" class="form-control">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" class="form-control" name="back">
            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>