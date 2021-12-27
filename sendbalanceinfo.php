<?php
    include "inc/header.php";
    include "class/TranjectionClass.php";
    $tran = new  Tranjection();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $payment   = $_POST['payment'];
        $amont     = $_POST['amont'];
        $tran_id   = $_POST['tran_id'];
        $tran_date = $_POST['tran_date'];
        $account   = $_POST['account'];
        $tranjection = $tran->sendTranjectionInfo($userid, $payment, $amont, $tran_id, $tran_date, $account);
    }
?>

<div class="container">
    <h3 class="pt-3">আপনার টাকা পাঠানোর তথ্য এখানে দিনঃ</h3>
    <p class="mb-0">দয়া করে সকল তথ্য সঠিক দিবেন। এবং সব তথ্য ভালোভাবে চেক করে নিবেন</p>
    <?php
        if (isset($tranjection)){
            echo $tranjection;
        }
    ?>
    <div class="row">
        <div class="col-md-7">
            <form method="POST">
            <div class="form-group">
                <label for="payment">পেমেন্ট মেথড</label>
                <select class="style_input" name="payment" id="payment">
                    <option>একটি মেথড সিলেক্ট করুন</option>
                    <option value="bkash" selected>বিকাশ</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amontOfTaka">টাকার পরিমান</label>
                <input type="number" placeholder="টাকার পরিমাণ লিখুন" class="style_input" id="amontOfTaka" name="amont">
            </div>

            <div class="form-group">
                <label for="tranjectionId">ট্রানজেকশন আইডি</label>
                <input type="text" placeholder="ট্রানজেকশন আইডি লিখুন" class="style_input" id="tranjectionId" name="tran_id">
            </div>

            <div class="form-group">
                <label for="tranjectionDate">ট্রানজেকশনের তারিখ</label>
                <input type="date" placeholder="ট্রানজেকশনের তারিখ দিন" class="style_input" id="tranjectionDate" name="tran_date">
            </div>
            
            <div class="form-group">
                <label for="accountNo">আপনার অ্যাাকাউন্ট নাম্বার</label>
                <input type="text" placeholder="যে নাম্বার থেকে টাকা পাঠিয়েছেন, সেই নাম্বার লিখুন" class="style_input" id="accountNo" name="account">
            </div>
            <button class="btn btn-primary"><i class="fa fa-send-o"></i>&nbsp;&nbsp;পাঠিয়ে দিন</button>
            </form>
        </div>

        <div class="col-md-5 mt-md-0 mt-4">
            <h3>টাকা পাঠানোর নিয়ম</h3>
            <p>আমাদের কাছে টাকা পাঠানোর জন্য বর্তমান মাধ্যম বিকাশ। এছাড়া অন্যকোন মাধ্যম আপাতত নেই।</p>
            <p class="lead">আমাদের বিকাশ নাম্বারঃ ০১৭৫৩০২৬৭৩৬</p>
            <p class="lead mb-0">টাকা পাঠানোর পর যা যা করবেন</p>
            <ul class="pl-4">
                <li>আপনার টাকার পরিমাণ লিখুন</li>
                <li>আপনার ট্রানজেকশন আইডি লিখুন</li>
                <li>আপনার ট্রানজেকশনের তারিখ লিখুন</li>
                <li>আপনার মোবাইল নাম্বার লিখুন</li>
                <li>এরপর আপনার তথ্যগুলো পাঠিয়ে দিন</li>
            </ul>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>