<?php
include "inc/header.php";
// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}



?>

<div class="container">
    
    <h3 class="pt-3">একটি বক্স সিলেক্ট করুনঃ</h3>
    <div class="row">
        <div class="col-sm-6">
            <a href="requestuser.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-user-plus"></i>
                <h3>রিকোয়েস্ট ইউজার</h3>
                <p>আপনি এইখান থেকে ওয়েবসাইটের তথ্য পরিচালনা করতে পারবেন। যেমনঃ ওয়েবসাইটের নাম, ওয়েবসাইটের লোগো, এবং সোশ্যাল লিংক পরিবর্বত করতে পারবেন</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6">
            <a href="user.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-users"></i>
                <h3>টাকা যোগ করুন</h3>
                <p>আপনি এইখান থেকে ওয়েবসাইটের তথ্য পরিচালনা করতে পারবেন। যেমনঃ ওয়েবসাইটের নাম, ওয়েবসাইটের লোগো, এবং সোশ্যাল লিংক পরিবর্বত করতে পারবেন</p>
            </div>
            </a>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>