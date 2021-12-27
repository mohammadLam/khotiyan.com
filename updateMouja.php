<?php

include "inc/header.php";



// only admin can access this pag
if ($user_role != 3) {
    header("Location: 404.php");
}

//get union id from url
if (!empty($_GET['mouja']) || $_GET['mouja'] == '') {
    $id = $_GET['mouja'];
} else {
    header("Location: 404.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $moujaBn = $_POST['moujaBn'];
    $moujaEn = $_POST['moujaEn'];
    $upazilla = $_POST['upazilla'];
    $zilla = $_POST['zilla'];
    $division = $_POST['division'];
    $updateMoujaById = $mouja->updateMoujaById($id, $moujaBn, $moujaEn, $upazilla, $zilla, $division);
}



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['back'])) {
    header("Location: mouja.php");
}
?>

<div class="container">
    <h3 class="pt-3">মৌজা সংস্করণ করুনঃ</h3>
    <?php

    if (isset($updateMoujaById)) {

        echo($updateMoujaById);

    }

    ?>



    <div class="row">

        <div class="col-md-7">

            <form method="post">

                <?php

                $getMoujaById = $mouja->getMoujaById($id);

                if ($getMoujaById) {

                    while ($result = $getMoujaById->fetch_assoc()) {

                        $division = $result['division'];

                        $zilla = $result['zilla'];

                        $upazilla = $result['upazilla'];

                        ?>



                        <div class="form-group">

                            <label for="moujaBn">মৌজার নাম লিখুন</label>

                            <input type="text" value="<?php echo $result['moujaBn']; ?>" placeholder="মৌজার নাম লিখুন"

                                   id="moujaBn" name="moujaBn" class="form-control"/>

                        </div>



                        <div class="form-group">

                            <label for="moujaEn">Write mouja name</label>

                            <input type="text" value="<?php echo $result['moujaEn']; ?>" placeholder="Write mouja name"

                                   id="moujaEn" name="moujaEn" class="form-control"/>

                        </div>

                    <?php }

                } ?>





                <div class="form-group">

                    <label for="select-division">বিভাগ বাছাই করুনঃ</label>

                    <select name="division" class="form-control" id="select-division"></select>

                </div>



                <div class="form-group">

                    <label for="select-zilla">জেলা বাছাই করুনঃ</label>

                    <select name="zilla" class="form-control" id="select-zilla">

                        <option value="">একটি জেলা নির্বাচন করুন</option>

                    </select>

                </div>



                <div class="form-group">

                    <label for="select-upazilla">উপজেলা বাছাই করুনঃ</label>

                    <select name="upazilla" class="form-control" id="select-upazilla">

                        <option value="">একটি উপজেলা নির্বাচন করুন</option>

                    </select>

                </div>



                <input class="btn btn-primary" type="submit" value="সংস্করণ করুন">
                <a href="javascript:history.go(-1)" class="btn btn-dark"><i class="fa fa-reply"></i>&nbsp;&nbsp;ফিরে যান</a>

            </form>

        </div>

    </div>



</div>

<?php include "inc/footer.php";?>

<script type="text/javascript" src="jquery.min.js"></script>

<script>

    function autocom() {

        alert("This is working");

    }



    function load_division() {

        $.ajax({

            url: "ajax/load.php",

            type: "POST",

            data: {

                division: <?php echo $division; ?>,

                type: 'division'

            },

            success: function (data) {

                $("#select-division").html(data);

            }

        });

    }



    load_division();



    function load_zilla() {



        var divisionId = $("#select-division").val();

        if (divisionId == null) {

            divisionId = <?php echo $division; ?>;

        }

        $.ajax({

            url: "ajax/load.php",

            type: "POST",

            data: {

                zilla: <?php echo $zilla; ?>,

                division: divisionId,

                type: 'zilla'

            },

            success: function (data) {

                $("#select-zilla").html(data);

            }

        });

    }



    load_zilla();



    function load_upazilla() {

        var divisionId = $("#select-division").val();

        if (divisionId == null) {

            divisionId = <?php echo $division; ?>;

        }



        var zillaId = $("#select-zilla").val();

        if (zillaId == "") {

            zillaId = <?php echo $zilla; ?>;

        }



        $.ajax({

            url: "ajax/load.php",

            type: "POST",

            data: {

                division: divisionId,

                zilla: zillaId,

                upazilla:  <?php echo $upazilla; ?>,

                type: 'upazilla'

            },

            success: function (data) {

                $("#select-upazilla").html(data);

            }

        });

    }



    load_upazilla();



    $("#select-division").on("change", function () {

        load_zilla();

    });



    $("#select-zilla").on("change", function () {

        load_upazilla();

    });



    $("#select-upazilla").on("change", function () {

        load_mouja();

    });

</script>