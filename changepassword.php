<?php

include "inc/header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['changepass'])) {
    $pass = $_POST['pass'];
    $newpass = $_POST['newpass'];
    $retypepass = $_POST['retypepass'];
    $changeUserPass = $user->changeUserPass($userid, $pass, $newpass, $retypepass);

}



?>

<div class="container">

    <div class="row">

        <div class="col-lg-8 col-md-7">

            <div class="chang_password_section myshadow p-4 mt-4 ">

                <h3>পাসওয়ার্ড পরিবর্তন করুনঃ</h3>

                <?php

                if (isset($changeUserPass)) {

                    echo $changeUserPass;

                }

                ?>

                <form method="post">

                    <div class="form-group">

                        <label for="pass">পুরাতন পাসওয়ার্ড লিখুন</label>

                        <input type="password" placeholder="পুরাতন পাসওয়ার্ড লিখুন" id="pass" name="pass"

                               class="style_input"/>

                    </div>



                    <div class="form-group">

                        <label for="newpass">নতুন পাসওয়ার্ড লিখুন</label>

                        <input type="password" placeholder="নতুন পাসওয়ার্ড লিখুন" id="newpass" name="newpass"

                               class="style_input"/>

                    </div>



                    <div class="form-group">

                        <label for="retypepass">নতুন পাসওয়ার্ডটি পুনরায় লিখুন</label>

                        <input type="password" placeholder="নতুন পাসওয়ার্ডটি পুনরায় লিখুন" id="retypepass"

                               name="retypepass"

                               class="style_input"/>

                    </div>

                    <input class="btn btn-primary" type="submit" name="changepass" value="পাসওয়ার্ড পরিবর্তন করুন">

                </form>

            </div>

        </div>

    </div>

</div>

<?php include "inc/footer.php";?>