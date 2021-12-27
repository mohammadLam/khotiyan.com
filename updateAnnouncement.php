<?php
include "inc/header.php";
include "class/websiteClass.php";

$web = new Website();

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

//get union id from url
if (!empty($_GET['update']) || $_GET['update'] == '') {
    $id = $_GET['update'];
} else {
    header("Location: 404.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['back'])) {
    header("Location: websiteDetails.php");
}

//if clicked submit button
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $announcement = $_POST['announcement'];
    $update = $web->updateMarquee($id, $announcement);
}
?>

<div class="container">
    <h3 class="pt-3">বিজ্ঞপ্তি ম্যাসেজ সংস্কার করুনঃ</h3>
    <?php
    if (isset($update)) {
        echo $update;
    }
    ?>
    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <?php
                $getMarquee = $web->getMarquee($id);
                if ($getMarquee) {
                    while ($result = $getMarquee->fetch_assoc()) { ?>
                        <textarea class="style_input mb-2" name="announcement" rows="10"><?php echo $result['announcement'];?></textarea>
                    <?php }
                } ?>

                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">

            </form>
        </div>
    </div>
<?php include "inc/footer.php";?>
