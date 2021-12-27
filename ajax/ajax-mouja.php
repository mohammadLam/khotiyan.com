<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../class/moujaClass.php');
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/format.php');

$fm = new format();
$db = new Database();
$mouja = new Mouja();

// মৌজা টেবিল লোড করার ফাংশান (ডাটাবেজ থেকে)
if (isset($_POST['type']) && $_POST['type'] == 'tbl_mouja'){

    $moujaInfo = $_POST["list"];
    $output = '';

    $division = $moujaInfo["division"];
    $zilla    = $moujaInfo["zilla"];
    $upazilla = $moujaInfo["upazilla"];

    $moujaList = $mouja->getMoujaListByParentValue($division, $zilla, $upazilla);
    $i = 0;
    if ($moujaList) {
        $output ='<table>
        <thead>
            <tr class="bg-dark text-white">
                <th>নং</th>
                <th>মৌজা</th>
                <th>সি এস</th>
                <th>এস এ</th>
                <th>আর এস</th>
                <th>উপজেলা</th>
                <th>জেলা</th>
                <th>বিভাগ</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>';
        $output .= "<tbody>";

        while ($result = $moujaList->fetch_assoc()) {
            $i++;
            $moujaid = $result['id'];
            $sql = "SELECT COUNT(rs) as rs, COUNT(cs) as cs, COUNT(sa) as sa,id FROM `tbl_khotiyan` WHERE division = {$division} AND zilla = {$zilla} AND upazilla = {$upazilla} AND mouja = {$moujaid}";
            $runquery = $db->select($sql);

            if ($runquery) {
                $getrow = $runquery->fetch_assoc();
                $RS_ROW = $getrow["rs"];
                $CS_ROW = $getrow["cs"];
                $SA_ROW = $getrow["sa"];

                $output .= '
                <tr>
                    <td>' . $fm->engToBangla($i) . '</td>
                    <td>' . $result["moujaBn"] . '</td>
                    <td>' . $fm->engToBangla($CS_ROW) . 'টি</td>
                    <td>' . $fm->engToBangla($SA_ROW) . 'টি</td>
                    <td>' . $fm->engToBangla($RS_ROW) . 'টি</td>
                    <td>' . $result["upazillaBN"] . '</td>
                    <td>' . $result["zillaBN"] . '</td>
                    <td>' . $result["divisionBN"] . '</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" onclick="getMoujaInfo(' . $result["id"] . ')"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteMouja(' . $result["id"] . ')"><i class="fa fa-remove"></i></button>
                        </div>
                    </td>
                </tr>';
            }

        }

        $sql = "SELECT COUNT(rs) as total_rs, COUNT(cs) as total_cs, COUNT(sa) as total_sa,id FROM tbl_khotiyan WHERE division = $division AND zilla = $zilla AND upazilla = $upazilla ";
        $runQuery = $db->select($sql);

        if ($runQuery) {
            $total = $runQuery->fetch_assoc();
            $total_rs = $fm->engToBangla($total['total_rs']);
            $total_cs = $fm->engToBangla($total['total_cs']);
            $total_sa = $fm->engToBangla($total['total_sa']);

            $output .= "<tr>
            <td colspan='2' class='text-center'>মোট:</td>
            <td colspan='2'>সি এস $total_cs টি</td>
            <td colspan='2'>এস এ $total_sa টি</td>
            <td colspan='2'>আর এস $total_rs টি</td>
            <td colspan='1'></td>
            </tr></tbody></table>";
        }

        echo $output;
    }
    else{
        echo 0;
    }
}

// মৌজা মোডাল লোড করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'loadMoujaModal'){
    $output = '
        <div class="form-group">
            <label for="moujaBn">মৌজার নাম লিখুন</label>
            <input type="text" placeholder="মৌজার নাম লিখুন" id="moujaBn" name="moujaBn" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="moujaEn">Enter mouja name</label>
            <input type="text" placeholder="Enter mouja name" id="moujaEn" name="moujaEn" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="division">বিভাগ বাছাই করুনঃ</label>
            <select name="division" class="form-control" id="division"></select>
        </div>

        <div class="form-group">
            <label for="zilla">জেলা বাছাই করুনঃ</label>
            <select name="zilla" class="form-control" id="zilla">
                <option value="">আগে বিভাগ নির্বাচন করুন</option>
            </select>
        </div>

        <div class="form-group">
            <label for="upazilla">উপজেলা বাছাই করুনঃ</label>
            <select name="upazilla" class="form-control" id="upazilla">
                <option value="">আগে জেলা নির্বাচন করুন</option>
            </select>
        </div>

        <button class="btn btn-primary btn-sm" onclick="createMouja()">যোগ করুন</button>
        <img class="ajaxloader d-none" src="image/ajax-loader.gif" alt="ajax loader" width="45px">';

    $output .= '<script>
    function load_division() {
        $.ajax({
            url: "ajax/load.php",
            type: "POST",
            data: {
                type: "division"
            },
            success: function (data) {
                $("#division").html(data);
            }
        });
    }

    load_division();

    function load_zilla() {
        var divisionId = $("#division").val();
        $.ajax({
            url: "ajax/load.php",
            type: "POST",
            data: {
                division: divisionId,
                type: "zilla"
            },
            success: function (data) {
                $("#zilla").html(data);
            }
        });
    }

    function load_upazilla() {
        var divisionId = $("#division").val();
        var zillaId = $("#zilla").val();

        $.ajax({
            url: "ajax/load.php",
            type: "POST",
            data: {
                division: divisionId,
                zilla: zillaId,
                type: "upazilla"
            },
            success: function (data) {
                $("#upazilla").html(data);
            }
        });
    }

    $("#division").on("change", function () {
        load_zilla();
    })

    $("#zilla").on("change", function () {
        load_upazilla();
    })
            
    </script>';

    echo $output;
}

// মৌজা তৈরি করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'createMouja') {
    $moujaInfo = $_POST['moujaInfo'];

    $moujaBn  = $moujaInfo['moujaBn'];
    $moujaEn  = $moujaInfo['moujaEn'];
    $division = $moujaInfo['division'];
    $zilla    = $moujaInfo['zilla'];
    $upazilla = $moujaInfo['upazilla'];
    $createMouja = $mouja->insertMouja($moujaBn, $moujaEn, $upazilla, $zilla, $division);

    sleep(3);
    if ($createMouja[0] == 'success'){  // যদি createMouja এর 0 নাম্বার ইনডেক্স success হয়, তাহলে কন্ডিশান সত্য
        echo "1".$createMouja[1];  // 1 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
    }else{
        echo "0".$createMouja[1];
    }
}

// মৌজার তথ্য ডাটাবেজ থেকে নিয়ে আসা
if (isset($_POST['type']) && $_POST['type'] == 'getMoujaInfo') {
    $id = $_POST['id'];
    $output = "";

    // $getMoujaById = (new Mouja())->getMoujaById($id);
    $getMoujaById = $mouja->getMoujaById($id);

    if ($getMoujaById) {
        $result   = $getMoujaById->fetch_assoc();
        $moujaBn  = $result['moujaBn'];
        $moujaEn  = $result['moujaEn'];
        $division = $result['division'];
        $zilla    = $result['zilla'];
        $upazilla = $result['upazilla'];

        $output = '
        <div class="form-group">
            <label for="moujaBn">মৌজার নাম লিখুন</label>
            <input type="text" value="'.$moujaBn.'" placeholder="মৌজার নাম লিখুন" id="moujaBn" name="moujaBn" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="moujaEn">Write mouja name</label>
            <input type="text" value="'.$moujaEn.'" placeholder="Write mouja name" id="moujaEn" name="moujaEn" class="form-control"/>
        </div>
        
        <div class="form-group">
            <label for="select-upazilla">উপজেলা বাছাই করুনঃ</label>
            <select name="upazilla" class="form-control" id="upazilla">
                <option value="">একটি উপজেলা নির্বাচন করুন</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="select-zilla">জেলা বাছাই করুনঃ</label>
            <select name="zilla" class="form-control" id="zilla">
                <option value="">একটি জেলা নির্বাচন করুন</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="select-division">বিভাগ বাছাই করুনঃ</label>
            <select name="division" class="form-control" id="division"></select>
        </div>
        
        <button type="submit" onclick="updateMouja('.$id.')" class="btn btn-sm btn-primary" ><i class="fa fa-refresh"></i>&nbsp;&nbsp;সংস্কার করুন</button>';

        $output .= '<script>
        
        function load_division() {
            $.ajax({
                url: "ajax/load.php",
                type: "POST",
                data: {
                    division: "'.$division.'",
                    type: "division"
                },
                success: function (data) {
                    $("#division").html(data);
                }
            });
        }
    
        load_division();
    
        function load_zilla() {
    
            var divisionId = $("#division").val();
            if (divisionId == null) {
                divisionId = "'.$division.'"
            }
            $.ajax({
                url: "ajax/load.php",
                type: "POST",
                data: {
                    zilla: "'.$zilla.'",
                    division: divisionId,
                    type: "zilla"
                },
                success: function (data) {
                    $("#zilla").html(data)
                }
            });
        }
    
        load_zilla();
    
        function load_upazilla() {
            var divisionId = $("#division").val()
            if (divisionId == null) {
                divisionId = "'.$division.'"
            }
    
            var zillaId = $("#zilla").val();
            if (zillaId == "") {
                zillaId = "'.$zilla.'"
            }
    
            $.ajax({
                url: "ajax/load.php",
                type: "POST",
                data: {
                    division: divisionId,
                    zilla: zillaId,
                    upazilla:  "'.$upazilla.'",
                    type: "upazilla"
                },
                success: function (data) {
                    $("#upazilla").html(data)
                }
            })
        }
    
        load_upazilla();
    
        $("#division").on("change", function () {
            load_zilla();
        });
    
        $("#zilla").on("change", function () {
            load_upazilla();
        });
    
        $("#upazilla").on("change", function () {})
        </script>';

        echo $output;
    }
}

// মৌজার তথ্য সংস্কার করা
if (isset($_POST['type']) && $_POST['type'] == 'updateMouja'){
    $moujainfo = $_POST['mouja'];

    $id       = $moujainfo['id'];
    $moujaBn  = $moujainfo['moujaBn'];
    $moujaEn  = $moujainfo['moujaEn'];
    $upazilla = $moujainfo['upazilla'];
    $zilla    = $moujainfo['zilla'];
    $division = $moujainfo['division'];
    $updateMoujaById = $mouja->updateMoujaById($id, $moujaBn, $moujaEn, $upazilla, $zilla, $division);

    if ($updateMoujaById[0] == 'success'){  // যদি updateMoujaById এর 0 নাম্বার ইনডেক্স success হয়, তাহলে কন্ডিশান সত্য
        echo "1".$updateMoujaById[1];  // 1 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
    }elseif($updateMoujaById[0] == 'warning'){
        echo "2".$updateMoujaById[1];  // 2 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
    }else{
        echo "0".$updateMoujaById[1];
    }
}

// মৌজার তথ্য ডিলিট করা
if (isset($_POST['type']) && $_POST['type'] == 'deleteMouja') {
    $id = $_POST['id'];

    $deleteById = $mouja->deleteMouja($id);
    if ($deleteById) {
        echo "1".$deleteById[1];  // 1 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
    } elseif($deleteById[0] == 'warning') {
        echo "2".$deleteById[1];  // 2 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
    } else {
        echo "0".$deleteById[1];
    }
}