<?php

include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

//get khotiyan id from url
if (!empty($_GET['updateKhotiyan']) && !empty($_GET['type'])) {
    $id = $_GET['updateKhotiyan'];
    $type = $_GET['type'];
} else {
    header("Location: 404.php");
}

// When click submit button

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $khotiyan = $fm->bangToEnglish($_POST['khotiyan']);
    $daag = $fm->bangToEnglish($_POST['daag']);
    $updateKhoById = $kho->updateKhoById($id, $khotiyan, $daag, $type);

}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['back'])) {
    header("Location: khotiyanList.php");

}

?>

<div class="container">
    <h3 class="pt-3">খতিয়ান সংস্করণ করুনঃ</h3>
</div>

<div class="container">
    <?php

    if (isset($updateKhoById)) {
        echo($updateKhoById);
    }

    ?>

    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <?php

                $getKhoById = $kho->getKhoById($id);
                if ($getKhoById) {
                    while ($result = $getKhoById->fetch_assoc()) {?>

                        <div class="form-input">
                            <label for="khotiyan">খতিয়ান নং লিখুন</label>
                            <input type="text" value="<?php echo $fm->engToBangla($result['khotiyan']); ?>" placeholder="খতিয়ান নং লিখুন" id="khotiyan" name="khotiyan" class="form-control"/>
                        </div>

                        <div class="form-input">
                            <label for="daag">দাগ নং লিখুন</label>
                            <input type="text" value="<?php echo $fm->unserializeData($result["$type"]); ?>" placeholder="দাগ নং লিখুন" id="daag" name="daag" class="form-control"/>
                        </div>

                    <?php   }   }?>

                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন">
                <a href="javascript:history.go(-1)" class="btn btn-dark"><i class="fa fa-reply"></i>&nbsp;&nbsp;ফিরে যান</a>

            </form>
        </div>
    </div>
</div>
<?php include "inc/footer.php";?>
<script type="text/javascript" src="jquery.min.js"></script>
<script>


    function replaceEngToBanNumbers(input) {
        var numbers = {
            0: '০',
            1: '১',
            2: '২',
            3: '৩',
            4: '৪',
            5: '৫',
            6: '৬',
            7: '৭',
            8: '৮',
            9: '৯'

        };

        //console.log("replaceNumbers", input);

        var output = [];
        for (var i = 0; i < input.length; i++) {
            if (numbers.hasOwnProperty(input[i])) {
                output.push(numbers[input[i]]);
            } else {
                output.push(input[i]);
            }
        }
        return output.join('').toString();

    }

    $("#khotiyan").on("input", function () {
        var hi = $(this).val();
        $(this).val(replaceEngToBanNumbers(hi));
    });

    $("#daag").on("input", function () {
        var hi = $(this).val();
        $(this).val(replaceEngToBanNumbers(hi));

    });
</script>