<?php

include "inc/header.php";



// only admin can access this page

if ($user_role != 3) {

    header("Location: 404.php");

}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $upazillaNameBN = $_POST['upazillaBN'];

    $upazillaNameEN = $_POST['upazillaEN'];

    $zillaName = $_POST['zilla'];

    $addUpazilla = $upazilla->insertUpazilla($upazillaNameEN, $upazillaNameBN, $zillaName);

}



if (isset($_POST['back'])) {

    header("Location: upazilla.php");

}

?>

<div class="container">

    <h3 class="pt-3">উপজেলা তৈরি করুনঃ</h3>



    <?php

    if (isset($addUpazilla)) {

        echo $addUpazilla;

    }

    ?>



    <div class="row">

        <div class="col-md-7">

            <form method="post">



                <div class="form-input">

                    <label for="upazillaBN">উপজেলার নাম লিখুন</label>

                    <input type="text" placeholder="উপজেলার নাম লিখুন" id="upazillaBN" name="upazillaBN"

                           class="form-control"/>

                </div>



                <div class="form-input">

                    <label for="upazillaEN">Write upazilla name</label>

                    <input type="text" placeholder="Enter District name" id="upazillaEN" name="upazillaEN"

                           class="form-control"/>

                </div>





                <div class="form-input">

                    <label for="select-zilla">একটি জেলা নির্বাচন করুন</label>

                    <select name="zilla" class="form-control" id="select-zilla">

                        <option value="">একটি জেলা নির্বাচন করুন</option>

                        <?php

                        $getZillaList = $zilla->getZillaList2();

                        if ($getZillaList) {

                            while ($result = $getZillaList->fetch_assoc()) { ?>

                                <option value="<?php echo $result['id']; ?>"><?php echo $result['zillaBN']; ?></option>

                            <?php }

                        } ?>

                    </select>

                </div>
                <input class="btn btn-primary" type="submit" value="যোগ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">
            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>