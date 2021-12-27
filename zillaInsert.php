<?php

include "inc/header.php";
// only admin can access this page

if ($user_role != 3) {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $zillaNameBN = $_POST['zillaBN'];
    $zillaNameEN = $_POST['zillaEN'];
    $division = $_POST['division'];
    $addZilla = $zilla->addZilla($zillaNameEN, $zillaNameBN, $division);
}

if (isset($_POST['back'])) {
    header("Location: zilla.php");
}
?>

<div class="container">
    <h3 class="pt-3">জেলা তৈরি করুনঃ</h3>
    <?php
    if (isset($addZilla)) {
        echo $addZilla;
    }
    ?>

    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <div class="form-group">
                    <label for="zillaBN">জেলার নাম লিখুন</label>
                    <input type="text" placeholder="জেলার নাম লিখুন" id="zillaBN" name="zillaBN" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="zillaEN">Enter District name</label>
                    <input type="text" placeholder="Enter District name" id="zillaEN" name="zillaEN" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="select-division">একটি বিভাগ নির্বাচন করুন</label>
                    <select name="division" class="form-control" id="select-division">
                        <option value="">একটি বিভাগ নির্বাচন করুন</option>
                        <?php
                        $getDivisionList = $div->getDivisionList();
                        if ($getDivisionList) {
                            while ($result = $getDivisionList->fetch_assoc()) { ?>
                                <option value="<?php echo $result['id']; ?>"><?php echo $result['divisionBn']; ?></option>
                            <?php   }   }?>
                    </select>
                </div>

                <input class="btn btn-primary" type="submit" value="যোগ করুন" class="form-control">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" class="form-control" name="back">
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>