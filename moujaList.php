<?php
include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

// default load
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $division = $_POST['division'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];
    $getMoujaListByParentValue = $mouja->getMoujaListByParentValue($division, $zilla, $upazilla);
} else {
    header("Location: 404.php");
}

?>

<div class="container">
    <h3 class="pt-3">মৌজার তালিকাঃ</h3>
    <?php
    if (isset($deleteUpazilla)) {
        echo $deleteUpazilla;
    }
    ?>

    <div class="row">
        <div class="col">
            <?php
            if ($getMoujaListByParentValue) {
                $i = 0;
                echo '<table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">
                        <tr class="bg-dark text-white py-2"><th>নং</th><th>মৌজা</th><th>সি এস</th><th>এস এ</th><th>আর এস</th><th>উপজেলা</th><th>জেলা</th><th>বিভাগ</th><th>অ্যাকশন</th></tr>';
                while ($result = $getMoujaListByParentValue->fetch_assoc()) {
                    $i++;
                    $moujaid = $result['id'];
                    $sql = "SELECT COUNT(rs) as rs, COUNT(cs) as cs, COUNT(sa) as sa,id FROM `tbl_khotiyan` WHERE division = {$division} AND zilla = {$zilla} AND upazilla = {$upazilla} AND mouja = {$moujaid}";
                    $runquery = $db->select($sql);
                    if($runquery){
                        $getrow = $runquery->fetch_assoc();
                        $RS_ROW = $getrow["rs"];
                        $CS_ROW = $getrow["cs"];
                        $SA_ROW = $getrow["sa"];
                    }
                    ?>
                    <tr>
                        <td><?php echo $fm->engToBangla($i); ?></td>
                        <td><?php echo $result['moujaBn']; ?></td>
                        <td><?php echo $fm->engToBangla($CS_ROW);?> টি</td>
                        <td><?php echo $fm->engToBangla($SA_ROW);?> টি</td>
                        <td><?php echo $fm->engToBangla($RS_ROW);?> টি</td>
                        <td><?php echo $result['upazillaBN'];?></td>
                        <td><?php echo $result['zillaBN'];?></td>
                        <td><?php echo $result['divisionBN'];?></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary btn-sm" href="updateMouja.php?mouja=<?php echo $result['id']; ?>"><i class="fa fa-refresh"></i></a>
                                <button class="btn btn-sm btn-danger" data-id="<?php echo $result['id']; ?>"><i class="fa fa-remove"></i></button>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                $sql = "SELECT COUNT(rs) as total_rs, COUNT(cs) as total_cs, COUNT(sa) as total_sa,id FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla ";
                $runQuery = $db->select($sql);
                if ($runQuery) {
                    $total = $runQuery->fetch_assoc();
                    $total_rs = $fm->engToBangla($total['total_rs']);
                    $total_cs = $fm->engToBangla($total['total_cs']);
                    $total_sa = $fm->engToBangla($total['total_sa']);

                    echo "<tr>
                    <td colspan='2' class='text-center'>মোট:</td>
                    <td>$total_cs টি</td>
                    <td>$total_sa টি</td>
                    <td>$total_rs টি</td>
                    <td colspan='4'></td>
                    </tr>";
                }
            }else{
                echo "<h4 class='text-center mt-4 text-danger'>আপনার দেওয়া তথ্যের ভেতরে কোন মৌজা নেই। মৌজা তৈরি করতে এখানে ক্লিক করুন</h4>";
            }
            ?>
        </table>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("click", ".btn-danger", function () {
            if (confirm("আপনি কী এই মৌজা মুছে ফেলতে চান?")) {
                var moujaid = $(this).data("id");
                var element = this;
                $.ajax({
                    url: "ajax/ajax-delete.php",
                    type: "POST",
                    data: {type: 'deleteMouja', id: moujaid},
                    success: function (data) {
                        if (data == 1) {  // যদি এই শর্তটি সত্য হয়, তাহলে মৌজা ডিলিট হয়ে যাবে
                            $(element).closest("tr").fadeOut();
                        }
                    }
                });
            }else{
                var moujaid = $(this).data("id")
                alert('Your message is '+moujaid)
            }
        });
    });
</script>
