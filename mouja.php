<?php
include "inc/header.php";

//only admin can access this page
if ($user_role == 2) { // if user is editor then he can access
    header("Location: khotiyanInsert.php");
}elseif ($user_role == 3){

}else{
    header("Location: 404.php");
}
?>
<div class="container">
    <h3 class="pt-3">মৌজার তালিকা পেতে নিচের ঘর গুলো পুরণ করুন:</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="select-division">বিভাগ বাছাই করুনঃ</label>
                <select name="division" class="style_input" id="select-division" required></select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="select-zilla">জেলা বাছাই করুনঃ</label>
                <select name="zilla" class="style_input" id="select-zilla" required>
                    <option value="0">আগে বিভাগ নির্বাচন করুন</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="select-upazilla">উপজেলা বাছাই করুনঃ</label>
                <select name="upazilla" class="style_input" id="select-upazilla" required>
                    <option value="0">আগে জেলা নির্বাচন করুন</option>
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

            <table class="table table-sm table-striped table-borderless text-center table-responsive-sm table-hover bg-light myshadow" id="tbl_mouja"></table>
        </div>
    </div>

    <div class="plus_btn" onclick="loadMoujaModal()">মৌজা তৈরি করুন</div>
</div>

<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">মৌজা আপডেট করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editModalData">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">

// মৌজা মোডাল লোড করার ফাংশান
loadMoujaModal = () => {
    $('.modal-title').html("মৌজা তৈরি করুন")
    $.ajax({
        url: "ajax/ajax-mouja.php",
        type: "POST",
        data: {
            type: 'loadMoujaModal'
        },
        success: function (data) {
            $('#editModalData').html(data)
            $('#modelId').modal('show')
        }
    })
}

// মৌজা তৈরি করার ফাংশান
createMouja = () => {
    let mouja = {
        moujaBn  : $("input[name=moujaBn]").val(),
        moujaEn  : $("input[name=moujaEn]").val(),
        division : $("#division option:selected").val(),
        zilla    : $("#zilla option:selected").val(),
        upazilla : $("#upazilla option:selected").val()
    }

    if(mouja.moujaBn == '' || mouja.moujaEn == '' || mouja.division == '' || mouja.zilla == '' || mouja.upazilla == ''){
        showalert('আগে সকল তথ্য পূরণ করুন', 'danger') // (danger message)
    }else {
        $.ajax({
            url: "ajax/ajax-mouja.php",
            type: "POST",
            beforeSend: function () {
                $('.ajaxloader').removeClass('d-none')
            },
            data: {
                moujaInfo: mouja,
                type: 'createMouja'
            },
            success: function (data) {
                data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                if (data.startsWith('1')) { // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য (success message)
                    $('#modelId').modal('hide')
                    showalert(data.substr(1), 'success')
                    $('.ajaxloader').addClass('d-none') // Ajax loader image
                    // tbl_mouja()
                } else {
                    showalert(data.substr(1), 'danger') // (danger message)
                    $('.ajaxloader').addClass('d-none') // Ajax loader image
                }
            }
        })
    }
}

// মৌজার তথ্য ডাটাবেজ থেকে নিয়ে আসা
getMoujaInfo = (id) => {
    $.ajax({
        url: "ajax/ajax-mouja.php",
        type: "POST",
        data: {
            type: 'getMoujaInfo',
            id: id
        },
        success: function (data) {
            $('#editModalData').html(data)
            $('#modelId').modal('show')
        }
    })
}

// মৌজার তথ্য সংস্কার করা
updateMouja = (id) => {
    let element = $('[onclick="getMoujaInfo('+id+')"]').first().closest("tr").first()
    let moujaBn_inp = $(element).children().eq(1)

    let info = {
        moujaBn  : $("input[name=moujaBn]").val(),
        moujaEn  : $("input[name=moujaEn]").val(),
        division : $("#division option:selected").val(),
        zilla    : $("#zilla option:selected").val(),
        upazilla : $("#upazilla option:selected").val(),
        id    : id
    }

    $.ajax({
        url: "ajax/ajax-mouja.php",
        type: "POST",
        data: {
            mouja : info,
            type  : 'updateMouja'
        },
        success: function (data) {
            data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

            if (data.startsWith('1')){ // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য (success message)
                $('#modelId').modal('hide')
                $(moujaBn_inp).html(info.moujaBn)
                showalert(data.substr(1), 'success')
            }else if(data.startsWith('2')){ // যদি বার্তাটি 2 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য (warning message)
                showalert(data.substr(1), 'warning')
            }else{
                showalert(data.substr(1), 'danger') // (danger message)
            }
        }
    })
}

// মৌজার তথ্য ডিলিট করা
deleteMouja = (id) => {
    let element = $('[onclick="deleteMouja('+id+')"]')
    if (confirm("আপনি কী এই মৌজাটি মুছে ফেলতে চান?")) {
        $.ajax({
            url: 'ajax/ajax-mouja.php',
            type: 'POST',
            data: {
                type: 'deleteMouja',
                id: id
            },
            success: function (data) {
                data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                if (data.startsWith('1')) { // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য (success message)
                    $('#modelId').modal('hide')
                    showalert(data.substr(1), 'success')
                    $(element).closest("tr").fadeOut();
                } else {
                    showalert(data.substr(1), 'danger') // (danger message)
                }
            }
        })
    }
}

// মৌজা টেবিল লোড করার ফাংশান (ডাটাবেজ থেকে)
tbl_mouja = () => {
    let mouja = {
        division: $('#select-division').val(),
        zilla   : $('#select-zilla').val(),
        upazilla: $('#select-upazilla').val()
    }

    if (mouja.division == 0|| mouja.zilla == 0 || mouja.upazilla == 0){
        $(".nodata").html("আগে সকল তথ্য দিন")
        $('.nodata').removeClass('d-none')
        $("#tbl_mouja").hide()
    }
    else {
        $.ajax({
            url: "ajax/ajax-mouja.php",
            type: "POST",
            data: {
                type: 'tbl_mouja',
                list: mouja
            },
            beforeSend: function() {
                $('.ajaxloader').removeClass('d-none')
            },
            success: function (data) {
                if (data == 0){  // কোন তথ্য না পাওয়া গেলে condition সত্য
                $('.ajaxloader').removeClass('d-none')
                    $("#tbl_mouja").hide()
                }
                else {
                    $("#tbl_mouja").show()
                    $('.ajaxloader').addClass('d-none')
                    $('.nodata').addClass('d-none')
                    $("#tbl_mouja").html(data)
                }
            }
        })
    }
}

// অটো রান ফাংশান
load_division()

$("#select-division").on("change", function () {
    load_zilla();
})

$("#select-zilla").on("change", function () {
    load_upazilla();
})

$("#select-upazilla").on("change", function () {
    tbl_mouja();
})
</script>