<?php

include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}


if ($user_role == 3 && isset($_GET['deleteUpazilla'])) {
    $id = $_GET['deleteUpazilla'];
    $deleteUpazilla = $upazilla->deleteUpazilla($id);
}

?>

<div class="container">

    <h3 class="pt-3">উপজেলার তালিকাঃ</h3>

    <?php
    if (isset($deleteUpazilla)) {
        echo $deleteUpazilla;
    }
    ?>

    <div class="row">

        <div class="col">

            <form method="post">

                <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">

                    <tr class="bg-dark text-white">
                        <th>নং</th>
                        <th>উপজেলা</th>
                        <th>জেলা</th>
                        <th>বিভাগ</th>
                        <th>অ্যাকশন</th>
                    </tr>

                    <?php

                    $getUpazillaListAd = $upazilla->getUpazillaListAd();

                    if ($getUpazillaListAd) {
                        $i = 0;
                        while ($result = $getUpazillaListAd->fetch_assoc()) {$i++;?>

                        <tr>
                            <td><?php echo $fm->engToBangla($i); ?></td>
                            <td><?php echo $result['upazillaBN']; ?></td>
                            <td><?php echo $result['zillaBN']; ?></td>
                            <td><?php echo $result['divisionBN']; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="updateUpazilla.php?updateUpazilla=<?php echo $result['id']; ?>"><i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-danger btn-sm" href="?deleteUpazilla=<?php echo $result['id']; ?>"><i class="fa fa-remove"></i></a>
                                </div>
                            </td>
                        </tr>

                    <?php   }   }?>

                </table>

            </form>

        </div>

    </div>



    <a href="upazillaInsert.php">
        <div class="plus_btn">উপজেলা তৈরি করুন</div>
    </a>
</div>
<?php include "inc/footer.php";?>