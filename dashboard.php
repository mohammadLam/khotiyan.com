<?php


include "inc/header.php";
// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="section-heading">ড্যাশবোর্ড</h2>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="websiteDetails.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-text-width"></i>
                <h3>ওয়েবসাইটের তথ্য</h3>
                <p>আপনি এইখান থেকে ওয়েবসাইটের তথ্য পরিচালনা করতে পারবেন। যেমনঃ ওয়েবসাইটের নাম, ওয়েবসাইটের লোগো, এবং সোশ্যাল লিংক পরিবর্বত করতে পারবেন</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="useroption.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-users"></i>
                <h3>ইউজারের তথ্য</h3>
                <p>আপনি এইখান থেকে ইউজারের তথ্য পরিচালনা করতে পারবেন। যেমনঃ ইউজার তৈরি করা, ইউজার ডিলিট করা, ইউজারের পয়েন্ট যোগ করা ও ইউজারের পদ নির্বাচন করা</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="tranjection.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-credit-card"></i>
                <h3>ট্র্যানজেকশনের তথ্য</h3>
                <p>আপনি এইখান থেকে ইউজারের তথ্য পরিচালনা করতে পারবেন। যেমনঃ ইউজার তৈরি করা, ইউজার ডিলিট করা, ইউজারের পয়েন্ট যোগ করা ও ইউজারের পদ নির্বাচন করা</p>
            </div>
            </a>
        </div>



        <div class="col-sm-6 col-md-4">
            <a href="khotiyan.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-newspaper-o"></i>
                <h3>খতিয়ানের তথ্য</h3>
                <p>আপনি এইখান থেকে খতিয়ানের তথ্য পরিচালনা করতে পারবেন। যেমনঃ খতিয়ান তৈরি করা, খতিয়ান ডিলিট করা, এবং খতিয়ানের লিস্ট পাওয়া</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="division.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-deviantart"></i>
                <h3>বিভাগের তথ্য</h3>
                <p>আপনি এইখান থেকে বিভাগের তথ্য পরিচালনা করতে পারবেন। যেমনঃ বিভাগ তৈরি করা, বিভাগ ডিলিট করা, এবং বিভাগের লিস্ট পাওয়া</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="zilla.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-building"></i>
                <h3>জেলার তথ্য</h3>
                <p>আপনি এইখান থেকে জেলার তথ্য পরিচালনা করতে পারবেন। যেমনঃ জেলা তৈরি করা, জেলা ডিলিট করা, এবং জেলার লিস্ট পাওয়া</p>
            </div>
            </a>
        </div>



        <div class="col-sm-6 col-md-4">
            <a href="upazilla.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-connectdevelop"></i>
                <h3>উপজেলার তথ্য</h3>
                <p>আপনি এইখান থেকে উপজেলার তথ্য পরিচালনা করতে পারবেন। যেমনঃ উপজেলা তৈরি করা, উপজেলা ডিলিট করা, এবং উপজেলার লিস্ট পাওয়া</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="mouja.php" class="text-decoration-none text-dark">
            <div class="service-box">
                <i class="fa fa-home"></i>
                <h3>মৌজার তথ্য</h3>
                <p>আপনি এইখান থেকে মৌজার তথ্য পরিচালনা করতে পারবেন। যেমনঃ মৌজার তৈরি করা, মৌজার ডিলিট করা, এবং মৌজার লিস্ট পাওয়া</p>
            </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <a href="message.php" class="text-decoration-none text-dark">
                <div class="service-box">
                    <i class="fa fa-envelope"></i>
                    <h3>অভিযোগ, মতামত</h3>
                    <p>আপনি এইখান থেকে ইউজারের অভিযোগ, মতামত ও অন্যান্য বিষয়ে বার্তাগুলো দেখতে পারবেন। যেমনঃ মতামত পড়া, মতামত ডিলিট করা, মতামতের উত্তর দেওয়া ইত্যাদি</p>
                </div>
            </a>
        </div>
    </div>

</div>

<?php include "inc/footer.php";?>