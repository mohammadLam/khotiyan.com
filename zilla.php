<?php
include "inc/header.php";

if (isset($_GET['deleteZilla'])) {
    $id = $_GET['deleteZilla'];
    $deleteZilla = $zilla->deleteZilla($id);
}

if ($user_role != 3) {
    header("Location: index.php");
}

?>

<div class="container">
    <h3 class="pt-3">জেলার তালিকাঃ</h3>
    <?php
    if (isset($deleteZilla)) {
        echo $deleteZilla;
    }

    ?>

    <div class="row">
        <div class="col">
            <form method="post">
                <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">
                    <tr class="bg-dark text-white">
                        <th>নং</th>
                        <th>জেলার নাম</th>
                        <th>জেলার নাম (ইংরেজী)</th>
                        <th>বিভাগ</th>
                        <th>অ্যাকশন</th>
                    </tr>

                    <?php

                    $getZillaList = $zilla->getZillaList();
                    if ($getZillaList) {
                        $i = 0;
                        while ($result = $getZillaList->fetch_assoc()) {
                            $i++;

                            ?>
                            <tr>
                                <td><?php echo $fm->engToBangla($i); ?></td>
                                <td><?php echo $result['zillaBN']; ?></td>
                                <td><?php echo $result['zillaEN']; ?></td>
                                <td><?php echo $result['divisionBN']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-primary btn-sm" href="updateZilla.php?updateZilla=<?php echo $result['id']; ?>"><i class="fa fa-refresh"></i></a>
                                        <a class="btn btn-danger btn-sm" href="?deleteZilla=<?php echo $result['id']; ?>"><i class="fa fa-remove"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </table>
            </form>
        </div>  <!--col end-->
    </div> <!--row end-->



    <a href="zillaInsert.php">
        <div class="plus_btn">জেলা তৈরি করুন</div>
    </a>
</div>

<?php include "inc/footer.php"; ?>