<?php
include "inc/header.php";
include "class/TranjectionClass.php";
$tran = new  Tranjection();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateDetails'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $updateAccountDetails = $user->userdetailsUpdate($userid, $username, $email, $address, $phone);
    // got user id from header
}
?>
<div class="container">
    <h3 class="py-3">আমার অ্যাকাউন্টঃ</h3>
    <?php
    $getUserDetails = $user->userDetails($userid);
    if ($getUserDetails) {
        while ($result = $getUserDetails->fetch_assoc()) { ?>

            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="my_account_section myshadow px-3 py-5">
                        <!-- show user name and logo -->
                        <div class="m-auto first_letter_logo"><?php echo $fm->get_first_charecter($result["username"]); ?></div>
                        <h2 class="text-center"><?php echo $result["username"]; ?></h2>
                        <!-- show user name and logo end -->

                        <!-- if user inoformation update then show this message-->
                        <h5 class="text-center">
                            <?php
                            if (isset($updateAccountDetails)) {
                                echo $updateAccountDetails;
                            }
                            ?>
                        </h5>
                        <!-- if user inoformation update then show this message end-->

                        <form method="post">
                            <div class="form-row align-items-center">
                                <div class="col-lg-4 offset-lg-1">
                                    <label class="m-0" for="username">ব্যবহারকারীর নাম</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" value="<?php echo $result['username']; ?>"
                                           placeholder="আপনার নাম লিখুন" id="username" name="username"
                                           class="style_input"/>
                                </div>
                            </div>

                            <div class="form-row pt-3 align-items-center">
                                <div class="col-lg-4 offset-lg-1">
                                    <label class="m-0" for="email">আপনার মেইল লিখুন</label>
                                </div>

                                <div class="col-lg-6">
                                    <input type="text" value="<?php echo $result['email']; ?>" placeholder="আপনার মেইল লিখুন" id="email" name="email" class="style_input"/>
                                </div>
                            </div>

                            <div class="form-row pt-3 align-items-center">
                                <div class="col-lg-4 offset-lg-1">
                                    <label class="m-0" for="address">আপনার ঠিকানা লিখুন</label>
                                </div>

                                <div class="col-lg-6">
                                    <input type="text" value="<?php echo $result['address']; ?>" placeholder="আপনার ঠিকানা লিখুন" id="address" name="address" class="style_input"/>
                                </div>
                            </div>

                            <div class="form-row pt-3 align-items-center">
                                <div class="col-lg-4 offset-lg-1">
                                    <label class="m-0" for="phone">আপনার ফোন নম্বর লিখুন</label>
                                </div>

                                <div class="col-lg-6">
                                    <input type="text" value="<?php echo (isset($result['phone'])) ? $result['phone'] : ""; ?>" placeholder="আপনার ফোন নম্বর লিখুন" id="phone" name="phone" class="style_input"/>
                                </div>
                            </div>

                            <div class="form-row pt-3 align-items-center">
                                <div class="col-lg-4 offset-lg-1">
                                    <label class="m-0" for="mode" class="text-right">রাতের মোড</label>
                                </div>
                                <div class="col-lg-6">
                                    <!-- বন্ধ <input type="checkbox" id="mode"> চালু -->
                                    কাজ চলছে
                                </div>
                            </div>

                            <!--  this is button section and link section  -->
                            <div class="form-row pt-3 align-items-center">
                                <div class="col-md-3 offset-lg-1">
                                    <input class="btn btn-primary" type="submit" name="updateDetails" value="অ্যাকাউন্ট আপডেট">
                                </div>

                                <div class="col">
                                    <a href="changepassword.php" class="text-decoration-none text-primary">পাসওয়ার্ড পরিবর্তন</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>    <!--col end-->

                <div class="col-lg-4 col-md-5">
                    <div class="balance_section bg-primary myshadow text-center p-4">
                        <h5>আপনার পদঃ- <?php echo $fm->typeOfUser($result["role"]); ?></h5>
                        <h5>আপনার বর্তমান ব্যালেন্স</h5>
                        <h1><?php echo $fm->engToBangla($result["point"]); ?>৳</h1>
                        <?php
                            if($user_role == 3){
                                echo '<h5><a href="user.php" class="text-white text-decoration-none">ব্যালেন্স যোগ করুন</a></h5>';
                            }else{
                                echo '<h5><a href="sendbalanceinfo.php" class="text-white text-decoration-none">ব্যালেন্স যোগ করুন</a></h5>';
                            }
                        ?>
                        
                    </div>

                    <div class="myshadow mt-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action active"><h4>আপনার লেনদেনের তালিকা</h4></li>
                            <?php
                                $tranListByUserId = $tran->tranListByUserId($userid);
                                if ($tranListByUserId){
                                    while ($result = $tranListByUserId->fetch_assoc()){
                                        $amount = $fm->engToBangla($result['amount']);
                                        $tran_date = $fm->engToBangla($fm->formatdate($result['tran_date']));
                                        echo "<li class='list-group-item list-group-item-action'>আপনি $tran_date তারিখে $amount টাকার লেনদেন করেছেন</li>";
                                    }
                                }else{
                                    echo "<li class='list-group-item list-group-item-action'>আপনি কোন লেনদেন করেন নি</li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div> <!-- row end -->
        <?php }
    } ?>
</div>
<?php include "inc/footer.php";?>
<script>
    $(document).ready(function () {
        $("#changepass_btn").on("click", function (e) {
            e.preventDefault();
            $(".chang_password_section").removeClass("d-none").fadeIn();
        });
    });
</script>