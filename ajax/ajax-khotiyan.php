<!-- Recreated on 10 April 2021 -->
<?php

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../class/khotiyanClass.php');
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/format.php');

$fm = new format();
$db = new Database();
$khotiyan = new khotiyan();

// Load khotiyan table
if (isset($_POST['type']) && $_POST['type'] == 'tbl_khotiyan'){

    $khotiyanInfo = $_POST["list"];
    $output = '';

    $division = $khotiyanInfo["division"];
    $zilla    = $khotiyanInfo["zilla"];
    $upazilla = $khotiyanInfo["upazilla"];
    $mouja    = $khotiyanInfo["mouja"];
    $khotiyanType = $khotiyanInfo["kho_type"];

    $khotiyanList = $khotiyan->getKhotiyanList($division, $zilla, $upazilla, $mouja, $khotiyanType);
    $i = 0;
    if ($khotiyanList) {
        $output ='<table>
        <thead>
            <tr class="bg-dark text-white">
                <th>খতিয়ান নং</th>
                <th>দাগ নং</th>
                <th>ক্রমিক নং</th>
                <th>পিডিএফ</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>';
        $output .= "<tbody>";

        while ($result = $khotiyanList->fetch_assoc()) {
            $i++;

            $output .= '
            <tr>
                <td>' . $fm->engToBangla($result["khotiyan"]) . '</td>
                <td>' . $fm->unserializeData($result[$khotiyanType]) . '</td>
                <td>' . $fm->engToBangla($i) . '</td>
                <td><button class="btn btn-sm btn-secondary" onclick="insertPdf(' . $result["id"] . ')"><i class="fa fa-refresh"></i>&nbsp; ফাইল যোগ করুন</button></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary" onclick="getKhotiyanInfo(' . $result["id"] . ')"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteKhotiyan(' . $result["id"] . ')"><i class="fa fa-remove"></i></button>
                    </div>
                </td>
            </tr>';

        }

        echo $output;
    }
    else{
        echo 0;
    }
}

// Load khotiyan update modal
if (isset($_POST['type']) && $_POST['type'] == 'getKhotiyanById') {
    $id = $_POST['id'];
    $kho_type = $_POST['kho_type'];
    $getKhoById = $khotiyan->getKhoById($id);

    if ($getKhoById) {
        $getKhoById = $getKhoById->fetch_assoc();
        var_dump($getKhoById);

        $khotiyan = $fm->engToBangla($getKhoById["khotiyan"]);
        $daag = join(", ", $getKhoById[$kho_type]);

        $output = '
        <div class="form-group">
            <label for="khotiyan">খতিয়ান নং লিখুন</label>
            <input type="text" placeholder="খতিয়ান নং লিখুন" value='.$khotiyan.' id="khotiyan" name="khotiyan" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="daag">দাগ নং লিখুন</label>
            <input type="text" placeholder="দাগ নং লিখুন" id="daag" value='.$daag.' name="daag" class="form-control"/>
        </div>

        <button class="btn btn-primary btn-sm" onclick="updateKhoById('.$id.')">যোগ করুন</button>
        <img class="ajaxloader d-none" src="image/ajax-loader.gif" alt="ajax loader" width="45px">';
    }
    
    echo $output;
}