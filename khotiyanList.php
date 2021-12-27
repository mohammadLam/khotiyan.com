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
    $mouja = $_POST['mouja'];
    $kho_type = $_POST['khotiyan_type'];
    $getKhotiyanList = $kho->getKhotiyanList($division, $zilla, $upazilla, $mouja, $kho_type);

    if ($kho_type == "rs") {
        $type = "আর এস";
    } elseif ($kho_type == "cs") {
        $type = "সি এস";
    } else {
        $type = "এস এ";
    }
} else {
    header("Location: 404.php");
}
?>

<div class="container">

    <h4 class="pt-3">
        <?php
        $getActualData = $kho->getActualData($division, $zilla, $upazilla, $mouja);
        if ($getActualData[0] == 1) {
            $getActualData = $getActualData[1];
            while ($result = $getActualData->fetch_assoc()) {
                printf("%s বিভাগের, %s জেলার %s উপজেলায় অন্তর্গত %s মৌজার %s খতিয়ানের লিস্টঃ", $result['divisionBn'], $result['zillaBN'], $result['upazillaBN'], $result['moujaBn'], $type);
            }
        }
        ?>
    </h4>

    <div class="row">
        <div class="col">
            <?php
            $khotiyanList = $getKhotiyanList[1];
            if ($getKhotiyanList[0] != 0 && $khotiyanList) {
            ?>

                <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light shadow">
                    <tr class="bg-dark text-white">
                        <th width="10%">খতিয়ান নং</th>
                        <th width="75%">দাগ নং</th>
                        <th width="5%">নং</th>
                        <th width="10%">অ্যাকশন</th>
                    </tr>
                    <?php
                    $i = 0;
                    if ($khotiyanList) {
                        while ($result = $khotiyanList->fetch_assoc()) {
                            $i++; ?>

                            <tr>
                                <td><?php echo $fm->engToBangla($result['khotiyan']); ?></td>
                                <td><?php echo $fm->unserializeData($result["$kho_type"]); ?></td>
                                <td><?php echo $fm->engToBangla($i); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href='updateKhotiyan.php?updateKhotiyan=<?php echo $result["id"]; ?>&type=<?php echo $kho_type; ?>'><i class="fa fa-refresh"></i></a>
                                        <button class="btn btn-sm btn-danger" data-id="<?php echo $result['id']; ?>" class="anchorBtn"><i class="fa fa-remove"></i></button>
                                    </div>
                                </td>
                            </tr>
                <?php
                        }

                        echo "</table>";
                    }
                } elseif ($getKhotiyanList[0] == 0) {
                    echo $getKhotiyanList[1];
                } else {
                    echo "<div class='notfound'><h3 class='error'>এই ঠিকানার তত্বাবধানে কোন খতিয়ান খুঁজে পাওয়া যায়নি</h3></div>";
                }

                ?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>

<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-danger", function() {
            if (confirm("আপনি কী এই খতিয়ায়ন মুছে ফেলতে চান ?")) {

                var khotiayanId = $(this).data("id");
                var element = this;
                $.ajax({
                    url: "ajax/ajax-delete.php",
                    type: "POST",
                    data: {
                        type: "deleteKhotiyan",
                        id: khotiayanId
                    },
                    success: function(data) {
                        if (data == 1) { // if this statement are true, then delete the khotiyan
                            $(element).closest("tr").fadeOut();
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>