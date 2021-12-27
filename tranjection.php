<?php
    include "inc/header.php";
    include "class/TranjectionClass.php";
    $tran = new  Tranjection();

    // only admin can access this page
    if ($user_role != 3) {
        header("Location: 404.php");
    }


    if (isset($_GET['tranid'])) {
        $id = $_GET['tranid'];
        $deleteTranDetailById = $tran->deleteTranDetailById($id);
    }
?>
<div class="container">
    <h3 class="pt-3">ট্র্যানজেকশনের তালিকাঃ</h3>
    <div class="row">
        <div class="col">
            <form method="post">

                <?php
                    if (isset($deleteTranDetailById)){
                        echo $deleteTranDetailById;
                    }

                    // get tranjection details from database
                    $getTranList = $tran->getTranList();
                    if ($getTranList) {
                        $i = 0; 
                ?>

                <table class="table table-sm table-responsive-sm table-striped table-borderless text-center table-hover bg-light shadow">
                    <tr class="bg-dark text-white">
                        <th>নং</th>
                        <th>ব্যাবহারকারীর নাম</th>
                        <th>টাকার পরিমান</th>
                        <th>অ্যাকাউন্ট নাম্বার</th>
                        <th>তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                    <tbody>

                <?php
                    while ($result = $getTranList->fetch_assoc()) {
                    $i++; 
                ?>
                    <tr>
                        <td><?php echo $fm->engToBangla($i); ?></td>
                        <td><?php echo $fm->engToBangla($result['username']) ?></td>
                        <td><?php echo $fm->engToBangla($result['amount']) ?></td>
                        <td><?php echo $fm->engToBangla($result['account_no']) ?></td>
                        <td><?php echo $fm->engToBangla($result['tran_date']); ?></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary btn-sm" href="adduserbalance.php?tranid=<?php echo $result['id'];?>"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-danger btn-sm" href="?tranid=<?php echo $result['id'];?>"><i class="fa fa-remove"></i></a>
                            </div>
                        </td>
                    </tr>
                
                <?php   } ?> 
                <!-- finish loop is here -->
                        </tbody>
                    </table>

                <?php
                    }else{
                        echo "<h3 class='pt-5 text-center'>কোন তথ্য নেই</h3>";
                    }
                ?>
            </form>
        </div>
    </div>

</div>
<?php include "inc/footer.php";?>