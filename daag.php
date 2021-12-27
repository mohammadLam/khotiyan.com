<?php

include "inc/header.php";

?>



<div class="container">

    <h3 class="pt-3">দাগ নাম্বার খুজুনঃ</h3>

    <div class="row">

        <div class="col-md-7">

            <p class="success"></p>

            <p class="error"></p>



            <form>

                <div class="form-group">

                    <label for="select-division">বিভাগ নির্বাচন করুনঃ</label>

                    <select name="division" class="style_input" id="select-division"></select>

                </div>



                <div class="form-group">

                    <label for="select-zilla">জেলা নির্বাচন করুনঃ</label>

                    <select name="zilla" class="style_input" id="select-zilla">

                        <option value="">আগে বিভাগ নির্বাচন করুন</option>

                    </select>

                </div>



                <div class="form-group">

                    <label for="select-upazilla">উপজেলা নির্বাচন করুনঃ</label>

                    <select name="upazilla" class="style_input" id="select-upazilla">

                        <option value="">আগে জেলা নির্বাচন করুন</option>

                    </select>

                </div>



                <div class="form-group">

                    <label for="select-mouja">মৌজা নির্বাচন করুনঃ</label>

                    <select name="mouja" class="js-example-basic-single style_input" id="select-mouja">

                        <option value="">আগে উপজেলা নির্বাচন করুন</option>

                    </select>

                </div>



                <div class="form-group">
                    <label for="cs">খতিয়ানের ধরণঃ</label><br>
                    <input type="radio" value="cs" id="cs" name="khotiyan_type"/>&nbsp;&nbsp;<label for="cs">সি এস</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="sa" id="sa" name="khotiyan_type"/>&nbsp;&nbsp;<label for="sa">এস এ</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="rs" id="rs" name="khotiyan_type"/>&nbsp;&nbsp;<label for="rs">আর এস</label>&nbsp;&nbsp;&nbsp;
                </div>



                <div class="form-group">
                    <label for="khotiyan">খতিয়ান নম্বর লিখুনঃ</label>
                    <input type="search" id="khotiyan" name="khotiyan" class="style_input" onkeyup="numbersOnly(this)">
                </div>

                <button class="btn btn-primary" id="submit"><i class="fa fa-search"></i>&numsp;দাগ নম্বর খুজুন</button>

            </form>

        </div> <!-- ==========col end============= -->

    </div>  <!-- ==========row end============= -->



    <table class="table table-sm table-striped table-borderless text-center table-hover bg-light shadow" style="margin-top: 15px"></table>
    <div class="notfound"></div>

</div>

<?php include "inc/footer.php";?>

<script>

    function numbersOnly(input) {

        var regex = /[^০-৯]/gi;

        input.value = input.value.replace(regex, "");

    }



    $(document).ready(function () {
        $('.js-example-basic-single').select2();

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



        function load_mouja() {

            var divisionId = $("#select-division").val();

            var zillaId = $("#select-zilla").val();

            var upazillaId = $("#select-upazilla").val();

            $.ajax({

                url: "ajax/load.php",

                type: "POST",

                data: {

                    division: divisionId,

                    zilla: zillaId,

                    upazilla: upazillaId,

                    type: 'mouja'

                },

                success: function (data) {

                    $("#select-mouja").html(data);

                }

            });

        }



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



        function searchDaag() {

            var divisionId = $("#select-division").val();

            var zillaId = $("#select-zilla").val();

            var upazillaId = $("#select-upazilla").val();

            var moujaId = $("#select-mouja").val();

            var type = $('input[name="khotiyan_type"]:checked').val();

            var khotiyan = replaceNumbers($("#khotiyan").val());



            if (divisionId == "" || zillaId == "" || upazillaId == "" || (moujaId == undefined || moujaId == null || moujaId == "") || type == undefined || khotiyan == "") {

                $(".success").slideUp();

                $(".table-list").fadeOut();

                $(".error").html("সবগুলো ঘর পূরণ করুন").slideDown();

            } else {

                $.ajax({

                    url: "ajax/ajax-load.php",

                    type: "POST",

                    data: {

                        division: divisionId,

                        zilla: zillaId,

                        upazilla: upazillaId,

                        mouja: moujaId,

                        khotiyanType: type,

                        khotiyanNo: khotiyan,

                        type: 'getDaagByKho'

                    },

                    success: function (data) {

                        if (data == 0) {

                            $(".error").slideUp();

                            $(".table").hide();

                            $(".notfound").html("<h3>কোন তথ্য পাওয়া যায়নি</h3>").slideDown();

                        }else {

                            $(".error").slideUp();

                            $(".notfound").hide();

                            $(".table").html(data).slideDown();

                        }

                    }

                });

            }

        }



        $("#submit").on("click", function (e) {

            e.preventDefault();

            searchDaag();

        });



        $("#khotiyan").on("input", function () {

            var hi = $(this).val();

            $(this).val(replaceEngToBanNumbers(hi));

        });



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

