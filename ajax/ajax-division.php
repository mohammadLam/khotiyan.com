<?php
$filepath = realpath(dirname(__FILE__));
// include_once($filepath . '/../class/divisionClass.php');
// include_once($filepath . '/../lib/Database.php');
// include_once($filepath . '/../helpers/format.php');

include_once('../class/divisionClass.php');
include_once('../lib/Database.php');
include_once('../helpers/format.php');

$fm = new format();
$db = new Database();
$division = new Division();


// বিভাগ টেবিল লোড করার ফাংশান (ডাটাবেজ থেকে)
if (isset($_POST['type']) && $_POST['type'] == 'tbl_divison') {
    $output ='<table>
    <thead>
        <tr class="bg-dark text-white">
            <th>নং</th>
            <th>বিভাগ</th>
            <th>বিভাগ (ইংরেজী)</th>
            <th>অ্যাকশন</th>
        </tr>
    </thead>';

    $getDivisionList = $division->getDivisionList();

    $output .= "<tbody>";

    if ($getDivisionList) {
        $i = 0;
        while ($result = $getDivisionList->fetch_assoc()) {
            $i++;
            $output .= '
            <tr>
                <td>' . $fm->engToBangla($i)  . '</td>
                <td>' . $result["divisionBn"] . '</td>
                <td>' . $result["divisionEn"] . '</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm" onclick="getDivisionInfo(' . $result["id"] . ')"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteDivision(' . $result["id"] . ')"><i class="fa fa-remove"></i></button>
                    </div>
                </td>
            </tr>';
        }
    }

    $output.="</tbody></table>";
    echo $output;
}

// বিভাগ মোডাল লোড করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'loadDivisionModal') {
    $output = '
        <div class="form-group">
            <label for="divisionBn">বিভাগের নাম লিখুন</label>
            <input type="text" placeholder="বিভাগের নাম লিখুন" id="divisionBn" name="divisionBn" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="divisionEn">Enter division name</label>
            <input type="text" placeholder="Enter division name" id="divisionEn" name="divisionEn" class="form-control"/>
        </div>
        
        <button type="submit" class="btn btn-sm btn-primary" onclick="createDivision()"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;তৈরি করুন</button>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>  -->';
    echo $output;
}

// বিভাগ তৈরি করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'createDivision') {
    $divisionInfo = $_POST['division'];

    $divisionBn  = $divisionInfo['divisionBn'];
    $divisionEn  = $divisionInfo['divisionEn'];
    $addDivision = $division->addDivision($divisionBn, $divisionEn);

    if ($addDivision){
        if ($addDivision[0] == 'success'){
            echo "1".$addDivision[1];
        }
        else{
            echo "0".$addDivision[1];
        }
    }
    else{
        echo "0".$addDivision[1];
    }
}

// বিভাগ মুছে ফেলার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'deleteDivision') {
    $id = $_POST['divisionId'];
    $deleteDivision = $division->deleteDivision($id);

    if ($deleteDivision){

        if ($deleteDivision[0] == 'success'){  // যদি deleteDivision এর 0 নাম্বার ইনডেক্স success হয়, তাহলে কন্ডিশান সত্য
            echo "1".$deleteDivision[1];  // 1 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
        }
        else{
            echo "0".$deleteDivision[1];
        }

    }
    else{
        echo "0".$deleteDivision[1];
    }
}

// বিভাগর তথ্য ডাটাবেজ থেকে নিয়ে আসা এবং বিভাগ মোডাল লোড করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'getDivisionById') {
    $id = $_POST['id'];
    $sql = " SELECT * FROM tbl_division  WHERE id = '$id' ";

    $getDivisionInfo = $division->getDivisionById($id);

    if ($getDivisionInfo) {
        $result = $getDivisionInfo->fetch_assoc();
        $divisionBn = $result['divisionBn'];
        $divisionEn = $result['divisionEn'];
    }

    $output = '
        <div class="form-group">
            <label for="divisionBn">বিভাগর নাম লিখুন</label>
            <input type="text" value="' . $divisionBn . '" placeholder="মৌজার নাম লিখুন" id="divisionBn" name="divisionBn" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="divisionEn">Write division name</label>
            <input type="text" value="' . $divisionEn . '" placeholder="Write mouja name" id="divisionEn" name="divisionEn" class="form-control"/>
        </div>
        
        <button type="submit" onclick="updateDivision('. $id .')" class="btn btn-sm btn-primary" >সংস্করণ করুন</button>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>  -->';

    echo $output;
}

// বিভাগ সংস্কার করার ফাংশান
if (isset($_POST['type']) && $_POST['type'] == 'updateDivision'){

    $divisionInfo = $_POST['division'];
    $id = $_POST['id'];

    $divisionBn  = $divisionInfo['divisionBn'];
    $divisionEn  = $divisionInfo['divisionEn'];
    $updateDivision = $division->updateDivision($id, $divisionBn, $divisionEn);

    if ($updateDivision){

        if ($updateDivision[0] == 'success'){  // যদি updateDivision এর 0 নাম্বার ইনডেক্স success হয়, তাহলে কন্ডিশান সত্য
            echo "1".$updateDivision[1];  // 1 এবং ম্যাসেজ রিটার্ন করবে স্ট্রিং আকারে
        }
        else{
            echo "0".$updateDivision[1];
        }
    }
    else{
        echo "0".$updateDivision[1];
    }
}