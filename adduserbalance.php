<?php
include "inc/header.php";
// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

include "class/TranjectionClass.php";
$tran = new  Tranjection();

// get tranjection id from url
if (!empty($_GET['tranid']) || $_GET['tranid'] == '') {
    $tranId = $_GET["tranid"];
    $sql = "SELECT table_user.id AS userid, tbl_tranjection.id, username, email, role, amount, tran_id, tran_date, account_no FROM table_user, tbl_tranjection WHERE table_user.id = tbl_tranjection.userid AND tbl_tranjection.id = $tranId";
    $run = $db->select($sql);

    if ($run) {
        while($result = $run->fetch_assoc()){
            $userid   = $result['userid'];
            $tranId   = $result['id']; // this is auto increament id on mysql database
            $username = $result['username'];
            $usermail = $result['email'];
            $userRole = $fm->typeOfUser($result['role']);
            $amountof = $fm->engToBangla($result['amount']);
            $tran_id  = $result['tran_id'];
            $tran_date = $fm->formatdate($result['tran_date']);
            $account = $fm->engToBangla($result['account_no']);
        }
    }
}else{
    header("Location: 404.php");
}

// if clicked submit button
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $amount = $fm->bangToEnglish($amountof);
    $addUserBalanceById = $tran->addUserBalanceById($userid, $amount, $tranId);
}
?>

<div class="container">
    <h3 class="pt-3">ইউজারের ব্যালেন্স যোগ করুনঃ</h3>
    <?php
        if(isset($addUserBalanceById)){
            echo $addUserBalanceById;
        }
    ?>
    <div class="row">
        <div class="col-md-7">
        <form method="post">
            <div class="form-group">
                <label for="username">ইউজারের নাম</label>
                <input type="text" class="style_input" name="username" id="username" value="<?php echo $username;?>" readonly>
            </div>

            <div class="form-group">
                <label for="usermail">ইউজারের মেইল</label>
                <input type="text" class="style_input" name="usermail" id="usermail" value="<?php echo $usermail;?>" readonly>
            </div>

            <div class="form-group">
                <label for="userRole">ইউজারের পদ</label>
                <input type="text" class="style_input" name="userRole" id="userRole" value="<?php echo $userRole;?>" readonly>
            </div>

            <div class="form-group">
                <label for="amountof">টাকার পরিমাণ</label>
                <input type="text" class="style_input" name="amountof" id="amountof" value="<?php echo $amountof;?>" readonly>
            </div>

            <div class="form-group">
                <label for="tran_id">ট্রানজেকশান আইডি</label>
                <input type="text" class="style_input" name="tran_id" id="tran_id" value="<?php echo $tran_id;?>" readonly>
            </div>

            <div class="form-group">
                <label for="tran_date">ট্রানজেকশানের তারিখ</label>
                <input type="text" class="style_input" name="tran_date" id="tran_date" value="<?php echo $tran_date;?>" readonly>
            </div>

            <div class="form-group">
                <label for="account">অ্যাকাউন্ট নাম্বার</label>
                <input type="text" class="style_input" name="account" id="account" value="<?php echo $account;?>" readonly>
            </div>

            <button class="btn btn-primary"><i class="fa fa-money"></i>&nbsp;&nbsp;টাকা যোগ করুন</button>
            <a href="tranjection.php" class="btn btn-dark"><i class="fa fa-reply"></i>&nbsp;&nbsp;ফিরে যান</a>
        </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>