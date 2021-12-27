<?php
include "inc/header.php";
include "class/websiteClass.php";

$web = new Website();

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

$sql = "SELECT * FROM tbl_websiteinfo WHERE id = 1";
$run = $db->select($sql);
if ($run){
    while ($result = $run->fetch_assoc()){
        $sitename = $result['websiteName'];
        $description = $result['description'];
        $copytight = $result['copyright'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['button'] == "marquee"){
    $marqueeText = $_POST['marquee'];
    $addmarquee = $web->createMarquee($marqueeText);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['button'] == "updateWebDetails"){
    $sitename = $_POST['website-name'];
    $copytight = $_POST['copyright'];
    $description = $_POST['description'];
    $updatesite = $web->websiteInfoUpdate($sitename, $copytight, $description);
}

if (isset($_GET['delete']) && $_GET['delete'] != '') {
    $id = $_GET['delete'];
    $respons_marquee = $web->deleteMarquee($id);
}

if (isset($_GET['pause']) && $_GET['pause'] != '') {
    $id = $_GET['pause'];
    $respons_marquee = $web->pauseMarquee($id);
}

if (isset($_GET['play']) && $_GET['play'] != '') {
    $id = $_GET['play'];
    $respons_marquee = $web->playMarquee($id);
}
?>

<div class="container">
    <h2 class="section-heading">ওয়েবসাইটের তথ্য সম্পাদন করুন</h2>
    <?php
        if (isset($updatesite)){
            echo $updatesite;
        }
    ?>
    <div class="row">
        <div class="col-md-6">
            <form method="post">

                <div class="form-group">
                    <label for="website-name">ওয়েবসাইটের নাম পরিবর্তন করুন</label>
                    <input type="text" placeholder="ওয়েবসাইটের নাম লিখুন" id="website-name" name="website-name" class="style_input" value="<?php echo $sitename;?>"/>
                </div>

                <div class="form-group">
                    <label for="copyright">কপিরাইট ম্যাসেজটি পরিবর্তন করুন</label>
                    <input type="text" placeholder="কপিরাইট ম্যাসেজটি লিখুন" id="copyright" name="copyright" class="style_input" value="<?php echo $copytight;?>"/>
                </div>

                <div class="form-group">
                    <label for="description">ওয়েবসাইটের তথ্য (Description) পরিবর্তন করুন</label>
                    <textarea rows="7" name="description" id="description" placeholder="ওয়েবসাইটের তথ্য লিখুন" class="style_input"><?php echo $description;?></textarea>
                </div>
                <button class="btn btn-secondary" name="button" value="updateWebDetails">তথ্য পরিবর্তন করুন</button>
            </form>
        </div>

        <div class="col-md-6">
            <form method="post">
                <?php
                if (isset($addmarquee)){
                    echo $addmarquee;
                }
                ?>
                <div class="form-group">

                    <label for="marquee">ওয়েবসাইটে নির্দেশিকা, ঘোষণা, অফারের বিজ্ঞপ্তি দিন</label>
                    <textarea class="style_input" name="marquee" id="marquee" placeholder="ওয়েবসাইটের বিজ্ঞপ্তি দিন" rows="10"></textarea>
                </div>
                <button class="btn btn-primary" name="button" value="marquee">বিজ্ঞপ্তি যোগ করুন</button>

                <h4 class="mt-3 mb-1">আপনার বিজ্ঞপ্তিগুলোর তালিকা</h4>
                <?php
                    if (isset($respons_marquee)){
                        echo $respons_marquee;
                    }
                ?>
                <ul class="list-group">
                    <?php
                        $sql = "SELECT * FROM tbl_announcement ORDER BY tbl_announcement.status DESC";
                        $run = $db->select($sql);
                        if ($run){
                            while ($result = $run->fetch_assoc()){
                                if ($result['status'] == 1){
                                    $id = $result['id'];
                                    $marquee = $result['announcement'];
                                    echo "<li class='list-group-item'>
                                            <marquee>$marquee</marquee>
                                            <a href='?pause=$id' class='btn btn-sm btn-success'><i class='fa fa-pause'></i>&nbsp;&nbsp;বন্ধ রাখুন</a>
                                            <a href='updateAnnouncement.php?update=$id' class='btn btn-sm btn-primary'><i class='fa fa-refresh'></i>&nbsp;&nbsp;সংস্করণ করুন</a>
                                            <a href='?delete=$id' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i>&nbsp;&nbsp;মুছে ফেলুন</a>
                                        </li>";
                                }else{
                                    $id = $result['id'];
                                    $marquee = $result['announcement'];
                                    echo "<li class='list-group-item'>
                                            <p>$marquee</p>
                                            <a href='?play=$id' class='btn btn-sm btn-warning'><i class='fa fa-pause'></i>&nbsp;&nbsp;চালু করুন</a>
                                            <a href='updateAnnouncement.php?update=$id' class='btn btn-sm btn-primary'><i class='fa fa-refresh'></i>&nbsp;&nbsp;সংস্করণ করুন</a>
                                            <a href='?delete=$id' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i>&nbsp;&nbsp;মুছে ফেলুন</a>
                                        </li>";
                                }
                            }
                        }else{
                            echo "<li class='list-group-item'>কোন বিজ্ঞাপন নাই। বিজ্ঞাপন তৈরি করুন</li>";
                        }

                    ?>

                </ul>
            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>