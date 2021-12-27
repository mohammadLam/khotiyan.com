<?php

include "inc/header.php";



// only admin can access this page

if ($user_role != 3) {

    header("Location: 404.php");

}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST["role"];
    $createUser = $user->usersingup($_POST, $role, $type = "from_admin");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['back'])) {
    header("Location: user.php");
}

?>

<div class="container">
    <h3 class="pt-3">ইউজার তৈরি করুনঃ</h3>

    <?php
    if (isset($createUser)) {
        echo $createUser;
    } ?>

    <div class="row">
        <div class="col-md-7">
            <form method="post">

                <div class="form-group">
                    <label for="username">ইউজারের নাম লিখুন</label>
                    <input type="text" id="username" name="username" placeholder="ইউজারের নাম লিখুন" class="form-control"/>
                </div>



                <div class="form-group">
                    <label for="usermail">ইউজারের মেইল লিখুন</label>
                    <input type="text" id="usermail" name="usermail" placeholder="ইউজারের মেইল লিখুন" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="userpass">ইউজারের পাসওয়ার্ড লিখুন</label>
                    <input type="password" id="userpass" name="userpass" placeholder="ইউজারের পাসওয়ার্ড লিখুন" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="repass">পুনরায় পাসওয়ার্ড লিখুন</label>
                    <input type="password" id="repass" name="repass" placeholder="পুনরায় পাসওয়ার্ড লিখুন" class="form-control"/>
                </div>



                <div class="form-group">
                    <label for="role">ইউজারের পদ নির্বাচন করুন</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">ইউজারের পদ নির্বাচন করুন</option>
                        <option value="1">সাধারণ ইউজার</option>
                        <option value="2">ইডিটর</option>
                        <option value="3">অ্যাডমিন</option>
                    </select>
                </div>

                <input class="btn btn-primary" type="submit" value="ইউজার তৈরি করুন">

                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">

            </form>

        </div>

    </div>

</div>

<?php include "inc/footer.php";?>