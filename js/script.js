function load_division() {
    $.ajax({
        url: "ajax/load.php",
        type: "POST",
        data: {type: 'division'},
        success: function (data) {
            $("#select-division").html(data)
        }
    });
}

function load_zilla() {
    var divisionId = $("#select-division").val()
    $.ajax({
        url: "ajax/load.php",
        type: "POST",
        data: {division: divisionId, type: 'zilla'},
        success: function (data) {
            $("#select-zilla").html(data)
        }
    });
}

function load_upazilla() {
    var divisionId = $("#select-division").val()
    var zillaId    = $("#select-zilla").val()

    $.ajax({
        url: "ajax/load.php",
        type: "POST",
        data: {division: divisionId, zilla: zillaId, type: 'upazilla'},
        success: function (data) {
            $("#select-upazilla").html(data)
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