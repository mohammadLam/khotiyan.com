<?php
include "inc/header.php";

// only admin can access this page
if($user_role == 2) {
    header("Location: khotiyanInsert.php");
}else if ($user_role == 3) {

}else{
    header("Location: 404.php");

}
?>

<div class="container">
    <h3 class="pt-2 my-2">খতিয়ানের তালিকা পেতে নিচের ঘর গুলো পুরণ করুন:</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="mb-0" for="select-division">বিভাগ নির্বাচন করুনঃ</label>
                <select name="division" class="style_input" id="select-division"></select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="mb-0" for="select-zilla">জেলা নির্বাচন করুনঃ</label>
                <select name="zilla" class="style_input" id="select-zilla">
                    <option value="0">আগে বিভাগ নির্বাচন করুন</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="mb-0" for="select-upazilla">উপজেলা নির্বাচন করুনঃ</label>
                <select name="upazilla" class="style_input" id="select-upazilla">
                    <option value="0">আগে জেলা নির্বাচন করুন</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label class="mb-0" for="select-mouja">মৌজা নির্বাচন করুনঃ</label>
                <select name="mouja" class="style_input  js-example-basic-single" id="select-mouja">
                    <option value="0">আগে উপজেলা নির্বাচন করুন</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="mb-0" for="khotiyan_type">খতিয়ানের ধরণ নির্বাচন করুনঃ</label>
                <select name="khotiyan_type" class="style_input" id="khotiyan_type">
                    <option value="0">খতিয়ানের ধরণ নির্বাচন করুন</option>
                    <option value="cs">সি এস</option>
                    <option value="sa">এস এ</option>
                    <option value="rs">আর এস</option>
                </select>
            </div>
        </div>
    </div>

    <h3 class="d-none text-center error mt-5 nodata">কোন তথ্য পাওয়া যায়নি</h3>

    <div class="row">
        <div class="col">
            <div class="text-center">
                <img src="image/ajax-loader.gif" alt="ajax loader" class='d-none ajaxloader text-center img-fluid' width='100px'>
            </div>
            <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light myshadow" id="tbl_khotiyan"></table>
        </div>
    </div>

    <a href="khotiyanInsert.php">
        <div class="plus_btn">খতিয়ান তৈরি করুন</div>
    </a>
</div>

<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">খতিয়ান আপডেট করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editModalData">

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    // খতিয়ানের তথ্য পাওয়া ও মোডাল লোড জাভাস্ক্রিপ্ট ফাংশান
    // Get khotiyan information and load modal function
    getKhotiyanInfo = (id) => {
        $('.modal-title').html('খতিয়ান সংস্কার করুন')

        $.ajax({
            url: "ajax/ajax-khotiyan.php",
            type: "POST",
            data: {
                type: 'getKhotiyanById',
                kho_type: $("#khotiyan_type").val(),
                id: id
            },
            success: function (data) {
                $('#editModalData').html(data)
                $('#modelId').modal('show')
            }
        })
    }

    // খতিয়ান সংস্কার করার জাভাস্ক্রিপ্ট ফাংশান
    // Update khotiyan function javascript
    updateKhotiyan = (id) => {
        let element = $('[onclick="getKhotiyanInfo('+id+')"]').first().closest("tr").first()
        let kho_inp = $(element).children().eq(0)
        let daag_inp = $(element).children().eq(1)

        let khotiyanInfo = {
            khotiyan : $("input[name=khotiyan]").val(),
            daag     : $("textarea[name=daag]").val(),
            kho_type : $("#khotiyan_type").val()
        }

        $.ajax({
            url: "ajax/ajax-khotiyan.php",
            type: "POST",
            data: {
                khotiyan: khotiyanInfo,
                type: 'updateKhotiyan',
                id: id
            },
            success: function (data) {
                data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                if (data.startsWith('1')) { // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য
                    $('#modelId').modal('hide')
                    $(kho_inp).html(khotiyanInfo.khotiyan)
                    $(daag_inp).html(khotiyanInfo.daag)
                    showalert(data.substr(1), 'success')
                } else{
                    showalert(data.substr(1), 'danger')
                }
            }
        })
    }

    // খতিয়ান ডিলিট করার জাভাস্ক্রিপ্ট ফাংশান
    // Delete khotiyan function
    deleteKhotiyan = (id) => {
        let element = $('[onclick="deleteKhotiyan('+id+')"]').first()
        if (confirm("আপনি কী এই খতিয়ান সংখ্যা মুছে ফেলতে চান?")) {
            $.ajax({
                url: "ajax/ajax-khotiyan.php",
                type: "POST",
                data: {type: 'deleteKhotiyan', khotiyanId: id},
                success: function (data) {
                    data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                    if (data.startsWith('1')){ // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য
                        showalert(data.substr(1), 'success')
                        $(element).closest("tr").fadeOut();
                    }
                    else {
                        showalert(data.substr(1), 'danger')
                    }
                }
            })
        }
    }

    // পিডিএফ আপলোড করার জাভাস্ক্রিপ্ট ফাংশান
    // Insert pdf file (javascript function)
    insertPdf = (id) => {
        console.log(id)
    }

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

    // অটো লোড হবে এই ফাংশান গুলো | Auto load function
    $('.js-example-basic-single').select2();
    load_division();

    $("#select-division").on("change", function () {
        load_zilla();
    })

    $("#select-zilla").on("change", function () {
        load_upazilla()
    })

    $("#select-upazilla").on("change", function () {
        load_mouja()
    })

    $("#select-mouja").on("change", function () {
        tbl_khotiyan()
    })

    $("#khotiyan_type").on("change", function () {
        tbl_khotiyan()
    })

    // কাষ্টম অ্যালার্ট ফাংশান
    function showalert(msg, alertype){
        $(".bootstrap-growl").remove()
        $.bootstrapGrowl(msg,{
            type: alertype,
            width: 300,
            offset: {from: 'top', amount: '50'},
            align: 'right',
            delay: 2000,
            allow_dismiss: true,
            stackup_spacing: 10
        })
    }
});

function tbl_khotiyan() {
    let khotiyan = {
        division: $('#select-division').val(),
        zilla   : $('#select-zilla').val(),
        upazilla: $('#select-upazilla').val(),
        mouja   : $('#select-mouja').val(),
        kho_type: $('#khotiyan_type').val()
    }

    if (khotiyan.division == 0|| khotiyan.zilla == 0 || khotiyan.upazilla == 0 || khotiyan.mouja == 0 || khotiyan.kho_type == 0){
        $("#khotiyan-info").html("আগে সকল তথ্য দিন")
    }
    else {
        $.ajax({
            url: "ajax/ajax-khotiyan.php",
            type: "POST",
            data: {
                type: 'tbl_khotiyan',
                list: khotiyan
            },
            beforeSend: function() {
                $('.ajaxloader').removeClass('d-none')
            },
            success: function (data) {
                if (data == 0){  // কোন তথ্য না পাওয়া গেলে condition সত্য
                    $('.nodata').removeClass('d-none')
                    $("#tbl_khotiyan").hide()
                }
                else {
                    $("#tbl_khotiyan").show()
                    $('.nodata').addClass('d-none')
                    $('.ajaxloader').addClass('d-none')
                    $("#tbl_khotiyan").html(data)
                }
            }
        })
    }
}
</script>