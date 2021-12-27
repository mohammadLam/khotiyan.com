<?php
include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $moujaEn = $_POST['moujaEn'];
    $moujaBn = $_POST['moujaBn'];
    $upazilla = $_POST['upazilla'];
    $zilla = $_POST['zilla'];
    $division = $_POST['division'];
    $addMouja = $mouja->insertMouja($moujaEn, $moujaBn, $upazilla, $zilla, $division);
}

if (isset($_POST['back'])) {
    header("Location: mouja.php");
}
?>
<div class="container">
    <h3 class="pt-3">মৌজা তৈরি করুনঃ</h3>
    <?php
    if (isset($addMouja)) {
        echo $addMouja;
    }
    ?>

    <div class="row">
        <div class="col-md-7">
            <form method="post">
                <div class="form-group">
                    <label for="moujaBn">মৌজার নাম লিখুন</label>
                    <input type="text" placeholder="মৌজার নাম লিখুন" id="moujaBn" name="moujaBn" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="moujaEn">Enter mouja name</label>
                    <input type="text" placeholder="Enter mouja name" id="moujaEn" name="moujaEn" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="select-division">বিভাগ বাছাই করুনঃ</label>
                    <select name="division" class="form-control" id="select-division"></select>
                </div>

                <div class="form-group">
                    <label for="select-zilla">জেলা বাছাই করুনঃ</label>
                    <select name="zilla" class="form-control" id="select-zilla">
                        <option value="">আগে বিভাগ নির্বাচন করুন</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="select-upazilla">উপজেলা বাছাই করুনঃ</label>
                    <select name="upazilla" class="form-control" id="select-upazilla">
                        <option value="">আগে জেলা নির্বাচন করুন</option>
                    </select>
                </div>

                <input class="btn btn-primary" type="submit" value="যোগ করুন">
                <input class="btn btn-dark" type="submit" value="ফিরে যান" name="back">
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            function load_division() {
                $.ajax({
                    url: "ajax/load.php",
                    type: "POST",
                    data: {
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
                $.ajax({
                    url: "ajax/load.php",
                    type: "POST",
                    data: {
                        division: divisionId,
                        type: 'zilla'
                    },
                    success: function (data) {
                        $("#select-zilla").html(data);
                    }
                });
            }

            function load_upazilla() {
                var divisionId = $("#select-division").val();
                var zillaId = $("#select-zilla").val();

                $.ajax({
                    url: "ajax/load.php",
                    type: "POST",
                    data: {
                        division: divisionId,
                        zilla: zillaId,
                        type: 'upazilla'
                    },
                    success: function (data) {
                        $("#select-upazilla").html(data);
                    }
                });
            }

            $("#select-division").on("change", function () {
                load_zilla();
                $('.zilla_op').show();
            });

            $("#select-zilla").on("change", function () {
                load_upazilla();
                $('.upazilla_op').show();
            });

            $("#select-upazilla").on("change", function () {
                load_mouja();
                $('.mouja_op').show();
            });
        });
    </script>
</div>
<?php include "inc/footer.php";?>