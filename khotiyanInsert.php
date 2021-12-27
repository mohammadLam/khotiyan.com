<?php
include "inc/header.php";

// only admin and editor can access this page

if ($user_role != 3 && $user_role != 2) {
    header("Location: 404.php");
}

if (isset($_POST['back'])) {
    header("Location: khotiyan.php");
}
?>

<div class="container">
    <h3 class="pt-3">খতিয়ান তৈরি করুনঃ</h3>
    <?php
    if (isset($insertNewData)) {
        echo $insertNewData;
    }
    ?>
    <p class="success"></p>
    <p class="error"></p>
    <form method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="select-division">বিভাগ বাছাই করুন</label>
                    <select name="division" class="style_input" id="select-division"></select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="select-zilla">জেলা বাছাই করুন</label>
                    <select name="zilla" class="style_input" id="select-zilla">
                        <option value="">একটি জেলা নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="select-upazilla">উপজেলা বাছাই করুন</label>
                    <select name="upazilla" class="style_input" id="select-upazilla">
                        <option value="">একটি উপজেলা নির্বাচন করুন</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="select-mouja">মৌজা বাছাই করুন</label>
                    <select name="mouja" class="js-example-basic-single style_input" id="select-mouja">
                        <option value="">একটি মৌজা নির্বাচন করুন</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="cs">খতিয়ানের ধরণঃ</label><br>
            <input type="radio" value="cs" id="cs" name="khotiyan_type"/>&nbsp;&nbsp;<label for="cs">সি এস</label>&nbsp;&nbsp;&nbsp;
            <input type="radio" value="sa" id="sa" name="khotiyan_type"/>&nbsp;&nbsp;<label for="sa">এস এ</label>&nbsp;&nbsp;&nbsp;
            <input type="radio" value="rs" id="rs" name="khotiyan_type"/>&nbsp;&nbsp;<label for="rs">আর এস</label>&nbsp;&nbsp;&nbsp;
        </div>

        <div class="form-group">
            <label for="khotiyanNo">খতিয়ান নম্বর লিখুন</label>
            <input type="text" placeholder="খতিয়ান নম্বর লিখুন" id="khotiyanNo" name="khotiyanNo" class="style_input"/>
        </div>

        <div class="form-group">
            <label for="daag">দাগ নম্বর লিখুন</label>
            <input type="text" placeholder="দাগ নম্বর লিখুন" id="daag" name="daag" class="style_input"/>
        </div>

        <input class="btn btn-primary" type="submit" value="যোগ করুন" class="style_input">
        <input class="btn btn-dark" type="submit" value="ফিরে যান" class="style_input" name="back">
    </form>
</div>

<?php include "inc/footer.php";?>
    <script type="text/javascript">

        $(document).ready(function () {
            $('.js-example-basic-single').select2();

            function load_division() {
                $.ajax({
                    url: "ajax/load.php",

                    type: "POST",

                    data: {type: 'division'},

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

                    data: {division: divisionId, type: 'zilla'},

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

                    data: {division: divisionId, zilla: zillaId, type: 'upazilla'},

                    success: function (data) {

                        $("#select-upazilla").html(data);

                    }

                });

            }



            function load_mouja() {

                var divisionId = $("#select-division").val();
                var zillaId = $("#select-zilla").val();
                var upazillaId = $("#select-upazilla").val();

                $.ajax({
                    url: "ajax/load.php",
                    type: "POST",
                    data: {division: divisionId, zilla: zillaId, upazilla: upazillaId, type: 'mouja'},
                    success: function (data) {
                        $("#select-mouja").html(data);
                    }
                });
            }

            function submitKhotiyan() {

                var divisionId = $("#select-division").val();
                var zillaId = $("#select-zilla").val();
                var upazillaId = $("#select-upazilla").val();
                var moujaId = $("#select-mouja").val();
                var type = $('input[name="khotiyan_type"]:checked').val();
                var khotiyan = replaceNumbers($("#khotiyanNo").val());
                var daag = replaceNumbers($("#daag").val());

                if (divisionId == "" || zillaId == "" || upazillaId == "" || moujaId == "" || type == undefined || khotiyan == "" || daag == "") {
                    $(".success").slideUp();
                    $(".error").html("সবগুলো ঘর পূরণ করুন").slideDown();

                } else {
                    $.ajax({
                        url: "ajax/ajax-insert.php",
                        type: "POST",
                        data: {

                            division: divisionId,
                            zilla: zillaId,
                            upazilla: upazillaId,
                            mouja: moujaId,
                            khotiyanType: type,
                            khotiyanNo: khotiyan,
                            daagNo: daag,
                            type: 'insertKho'

                        },

                        success: function (data) {
                            if (data == 1) {
                                $(".error").slideUp();
                                $(".success").slideUp();
                                $(".success").html("খতিয়ান সফলভাবে সংযুক্ত করা হয়েছে").slideDown();
                            } else if(data == 4){
                                $(".error").slideUp();
                                $(".success").slideUp();
                                $(".error").html("খতিয়ানটি ইতিমধ্যে ডাটাবেজে রয়েছে").slideDown();
                            }else {
                                $(".success").slideUp();
                                $(".error").html(data).slideDown();
                            }
                        }
                    });
                }
            }



            $("#khotiyanNo").on("input", function () {
                var hi = $(this).val();
                $(this).val(replaceEngToBanNumbers(hi));
            });



            $("#daag").on("input", function () {
                var hi = $(this).val();
                $(this).val(replaceEngToBanNumbers(hi));
            });



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



            function replaceNumbers(input) {
                var numbers = {
                    '০': 0,
                    '১': 1,
                    '২': 2,
                    '৩': 3,
                    '৪': 4,
                    '৫': 5,
                    '৬': 6,
                    '৭': 7,
                    '৮': 8,
                    '৯': 9
                };

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

            $(".btn-primary").on("click", function (e) {
                e.preventDefault();
                submitKhotiyan();
            })

            $("#select-division").on("change", function () {
                load_zilla();
            });

            $("#select-zilla").on("change", function () {
                load_upazilla();
            });

            $("#select-upazilla").on("change", function () {
                load_mouja();
            });

        });

    </script>

</div>