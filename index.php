<?php




    include "inc/header.php";
    $total_point = $_COOKIE['total_point'];
    $userid = $_COOKIE['userid'];
    $role = $_COOKIE['role'];
?>

<?php
    $announcement = "";
    $sql = "SELECT announcement FROM tbl_announcement WHERE status = 1";
    $run = $db->select($sql);
    if ($run){
        while ($result = $run->fetch_assoc()){
            $announcement .= $result['announcement']."&nbsp;&nbsp;*&nbsp;&nbsp;";
        }
        echo "<marquee class='announcement'><p class='mb-0'>$announcement</p></marquee>";
    }
?>

<div class="container">
    <h3 class="mt-2 mb-2">খতিয়ান খুজুনঃ</h3>
    <div class="row">
        <div class="col-md-7">
            <p class="success mb-0"></p>
            <p class="error mb-0"></p>
            <form>
                <div class="form-group">
                    <label for="select-division">বিভাগ নির্বাচন করুনঃ</label>
                    <select name="division" class="style_input" id="select-division"></select>
                </div>

                <div class="form-group">
                    <label for="select-zilla">জেলা বাছাই করুনঃ</label>
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
                    <input type="radio" value="cs" id="cs" name="khotiyan_type" />&nbsp;&nbsp;<label for="cs">সি এস</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="sa" id="sa" name="khotiyan_type" />&nbsp;&nbsp;<label for="sa">এস এ</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" value="rs" id="rs" name="khotiyan_type" />&nbsp;&nbsp;<label for="rs">আর এস</label>&nbsp;&nbsp;&nbsp;
                </div>

                <div class="form-group">
                    <label for="daag">দাগ নম্বর লিখুনঃ</label>
                    <input type="search" id="daag" name="daagNo" class="style_input" onkeyup="numbersOnly(this)">
                </div>

                <button class="btn btn-primary" id="submit"><i class="fa fa-search"></i>&numsp;খতিয়ান নম্বর খুজুন</button>
                <a href="daag.php" class="d-block pt-2">দাগ নম্বর খুঁজতে এখানে ক্লিক করুন</a>
            </form>
        </div> <!-- ==========col end============= -->
        
        <?php
            if($role == 1){
            $sql = "SELECT * FROM table_user WHERE id = $userid";
            $run = $db->select($sql);
            if($run){   while($result = $run->fetch_assoc()){?>

        <div class="col-lg-4 col-md-5">
            <div class="balance_section bg-primary myshadow text-center p-4">
                <h5>আপনার পদঃ- <?php echo $fm->typeOfUser($result["role"]); ?></h5>
                <h5>আপনার বর্তমান ব্যালেন্স</h5>
                <h1 class="balance"><?php echo $fm->engToBangla($result["point"]); ?>৳</h1>
                <h5><a href="sendbalanceinfo.php" class="text-white text-decoration-none">ব্যালেন্স যোগ করুন</a></h5>
            </div>
        </div> <!-- ==========col end============= -->

        <?php   }   }   }?>

    </div> <!-- ==========row end============= -->

    <table class="table table-sm table-striped table-borderless text-center table-hover bg-light shadow" style="margin-top: 15px"></table>
    <div class="notfound"></div>

</div>

<?php include "inc/footer.php";?>
<script type="text/javascript">

function numbersOnly(input) {
    var regex = /[^০-৯]/gi;
    input.value = input.value.replace(regex, "");
}


$(document).ready(function() {
    $('.js-example-basic-single').select2();

    function load_division() {

        $.ajax({
            url: "ajax/load.php",
            type: "POST",
            data: {
                type: 'division'
            },

            success: function(data) {
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

            success: function(data) {
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

            success: function(data) {
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
            success: function(data) {
                $("#select-mouja").html(data);
            }
        });
    }


    function searchKhotian() {
        var divisionId = $("#select-division").val();
        var zillaId = $("#select-zilla").val();
        var upazillaId = $("#select-upazilla").val();
        var moujaId = $("#select-mouja").val();
        var type = $('input[name="khotiyan_type"]:checked').val();
        var daag = replaceNumbers($("#daag").val());

        if (divisionId == "" || zillaId == "" || upazillaId == "" || (moujaId == undefined || moujaId == null ||
                moujaId == "") || type == undefined || daag == "") {
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
                    daagNo: daag,
                    type: 'getKhoByDaag'
                },
                success: function(data) {
                    if (data == 0) {
                        $(".error").slideUp();
                        $(".table").hide();
                        $(".notfound").html("<h3>কোন তথ্য পাওয়া যায়নি</h3>").slideDown();
                    } else if (data == 1) {
                        $(".error").slideUp();
                        $(".table").hide();
                        $(".notfound").html("<h3>আপনার পয়েন্ট শেষ হয়ে গেছে। রিচার্জ করুন</h3>").slideDown();
                    } else {
                        $(".error").slideUp();
                        $(".notfound").hide();
                        $(".table").html(data).slideDown();  // data found successfully
                    }
                }

            });
        }
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

    $("#submit").on("click", function(e) {
        e.preventDefault();
        searchKhotian();
    });

    $("#daag").on("input", function() {
        var hi = $(this).val();
        $(this).val(replaceEngToBanNumbers(hi));
    });

    $("#select-division").on("change", function() {
        load_zilla();
    });

    $("#select-zilla").on("change", function() {
        load_upazilla();
    });

    $("#select-upazilla").on("change", function() {
        load_mouja();
    });

});
</script>