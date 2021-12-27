<?php
include "inc/header.php";

// only admin can access this page
if ($user_role != 3) {
    header("Location: 404.php");
}
?>
<div class="container">
    <h3 class="pt-3">বিভাগের তালিকাঃ</h3>

    <div class="row">
        <div class="col">
            <table class="table table-sm table-striped table-borderless text-center table-hover bg-light myshadow" id="tbl_divison">
                <!--বিভাগ টেবিল লোড হচ্ছে-->
            </table>
            <div class="text-center">
                <img src="image/ajax-loader.gif" alt="ajax loader" class='d-none ajaxloader text-center img-fluid' width='100px'>
            </div>
        </div>
    </div>

    <div class="plus_btn" onclick="loadDivisionModal()">বিভাগ তৈরি করুন</div>
</div>

<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">বিভাগ আপডেট করুন</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editModalData">

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function () {
    tbl_divison = () => {
        $.ajax({
            url: "ajax/ajax-division.php",
            type: "POST",
            data: {type: 'tbl_divison'},
            beforeSend: function() {
                $('.ajaxloader').removeClass('d-none')
            },
            success: function (data) {
                if (data) {
                    $('.ajaxloader').addClass('d-none')
                    $('#tbl_divison').html(data)
                }
            }
        })
    }

    // অটো লোড হবে এই ফাংশান গুলো | Auto load function
    tbl_divison();

    // বিভাগ ডিলিট করার জাভাস্ক্রিপ্ট ফাংশান
    // Delete division function
    deleteDivision = (id) => {
        let element = $('[onclick="deleteDivision('+id+')"]').first()
        if (confirm("আপনি কী এই বিভাগটি মুছে ফেলতে চান?")) {
            $.ajax({
                url: "ajax/ajax-division.php",
                type: "POST",
                data: {type: 'deleteDivision', divisionId: id},
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

    // বিভাগ মোডাল লোড করার জাভাস্ক্রিপ্ট ফাংশান
    // load Division function
    loadDivisionModal = () => {
        $('.modal-title').html('বিভাগ তৈরি করুন')

        $.ajax({
            url: "ajax/ajax-division.php",
            type: "POST",
            data: {
                type: 'loadDivisionModal'
            },
            success: function (data) {
                $('#editModalData').html(data)
                $('#modelId').modal('show')
            }
        })
    }


    // বিভাগ তৈরি করার জাভাস্ক্রিপ্ট ফাংশান
    // create Division function
    createDivision = () => {
        let divisionInfo = {
            divisionBn  : $("input[name=divisionBn]").val(),
            divisionEn  : $("input[name=divisionEn]").val()
        }

        $.ajax({
            url: "ajax/ajax-division.php",
            type: "POST",
            data: {
                division : divisionInfo,
                type: 'createDivision'
            },

            success: function (data) {
                data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                if (data.startsWith('1')){
                    $('#modelId').modal('hide')
                    showalert(data.substr(1), 'success')
                    tbl_divison()
                }
                else{
                    showalert(data.substr(1), 'danger')
                }
            }
        })
    }

    // বিভাগের তথ্য পাওয়া ও মোডাল লোড জাভাস্ক্রিপ্ট ফাংশান
    // Get capital information and load modal function
    getDivisionInfo = (id) => {
        $('.modal-title').html('বিভাগ সংস্কার করুন')

        $.ajax({
            url: "ajax/ajax-division.php",
            type: "POST",
            data: {
                type: 'getDivisionById',
                id: id
            },
            success: function (data) {
                $('#editModalData').html(data)
                $('#modelId').modal('show')
            }
        })
    }


    // বিভাগ সংস্কার করার জাভাস্ক্রিপ্ট ফাংশান
    // Update Division function javascript
    updateDivision = (id) => {
        let element = $('[onclick="getDivisionInfo('+id+')"]').first().closest("tr").first()
        let bn = $(element).children().eq(1)
        let en = $(element).children().eq(2)

        let divisionInfo = {
            divisionBn  : $("input[name=divisionBn]").val(),
            divisionEn  : $("input[name=divisionEn]").val()
        }

        $.ajax({
            url: "ajax/ajax-division.php",
            type: "POST",
            data: {
                division : divisionInfo,
                type: 'updateDivision',
                id: id
            },
            success: function (data) {
                data = data.replace(/\r?\n|\r/g, "") // যে বার্তা রিটার্ন আসবে, সেই বার্তার (newline, space) রিমুভ করবে

                if (data.startsWith('1')){ // যদি বার্তাটি 1 দিয়ে শুরু হয়, তাহলে কন্ডিশন সত্য
                    $('#modelId').modal('hide')
                    $(bn).html(divisionInfo.divisionBn)
                    $(en).html(divisionInfo.divisionEn)
                    showalert(data.substr(1), 'success')
                }
                else{
                    showalert(data.substr(1), 'danger')
                }
            }
        })
    }

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
</script>