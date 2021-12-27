<?php
include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

//get upazilla id from url
if (!empty($_GET['updateUpazilla']) || $_GET['updateUpazilla'] == '') {
    $id = $_GET['updateUpazilla'];
} else {
    header("Location: 404.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $upazillaNameBN = $_POST['upazillaNameBN'];
    $upazillaNameEN = $_POST['upazillaNameEN'];
    $zillaName = $_POST['zillaName'];
    $updateUpazillaById = $upazilla->updateUpazillaById($id, $upazillaNameEN, $upazillaNameBN, $zillaName);
}

if (isset($_POST['back'])) {
    header("Location: upazilla.php");
}
?>
<div class="container">
    <h3 class="pt-3">উপজেলা সংস্করণ করুন</h3>
    <?php
    if (isset($updateUpazillaById)) {
        echo($updateUpazillaById);
    }
    ?>
    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <?php
                $getUpazillaById = $upazilla->getUpazillaById($id);
                if ($getUpazillaById) {
                    while ($result = $getUpazillaById->fetch_assoc()) {
                        $checkZilla = $result['zilla'];
                        ?>
                        <div class="form-input">
                            <label for="upazillaNameBN">উপজেলার নাম লিখুন</label>
                            <input type="text" value="<?php echo $result['upazillaBN']; ?>"
                                   placeholder="উপজেলার নাম লিখুন"
                                   id="upazillaNameBN" name="upazillaNameBN" class="form-control"/>
                        </div>

                        <div class="form-input">
                            <label for="upazillaNameEN">Enter upazilla name</label>
                            <input type="text" value="<?php echo $result['upazillaEN']; ?>"
                                   placeholder="Write upazilla name"
                                   id="upazillaNameEN" name="upazillaNameEN" class="form-control"/>
                        </div>
                    <?php }
                } ?>

                <div class="form-input">
                    <label for="select-zilla">যে জেলার অন্তর্ভুক্ত</label>
                    <select name="zillaName" class="form-control" id="select-zilla">
                        <?php
                        $getZillaList = $zilla->getZillaList2();
                        if ($getZillaList) {
                            while ($result = $getZillaList->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $result['id']; ?>" <?php if ($result['id'] == $checkZilla) {
                                    echo 'selected';
                                } ?>><?php echo $result['zillaBN']; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">
            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>