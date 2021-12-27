<?php

class format {

    public function formatdate($date) {
        return date('F j, Y', strtotime($date));
    }

    function engToBangla($input){
        $bn_digits = array("০","১","২","৩","৪","৫","৬","৭","৮","৯");
        $output = str_replace(range(0, 9), $bn_digits, $input);
        return $output;
    }

    function bangToEnglish($input){
        $en_digits = array("0","1","2","3","4","5","6","7","8","9");
        $bn_digits = array("০","১","২","৩","৪","৫","৬","৭","৮","৯");
        $output = str_replace($bn_digits, $en_digits, $input);
        return $output;
    }

    // short text for post sub-title
    public function shortText($text, $limit = 500) {
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, " "));
        $text = $text . " ...";
        return $text;
    }

    // validation user define data
    public function validation($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // upload image
    public function addImage($file, $folder = "../blogsite/admin/upload/"){
        
        $permitted = array('jpg', 'png', 'jpeg', 'gif');

        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $exten  = explode('.', $file_name);
        $extension = strtolower(end($exten));
        $uniqueName= substr(md5(time()), 0, 15).'.'.$extension;

        if (empty($file_name)) {
            $msg = array(0, "<span class='error'>Please select a image!</span>");
            return $msg;
        }elseif ($file_size > 1048576) {
            $msg = array(0, "<span class='error'>Image size should be less than 1MB!</span>");
            return $msg;
        }elseif (!in_array($extension, $permitted)) {
            $msg = array(0, "<span class='error'>You can upload only ".implode(' ', $permitted)."</span>");
            return $msg;
        }else{
            move_uploaded_file($file_temp, $folder.$uniqueName);
            return array(1, $uniqueName);
        }
        
    }

    // find search filter
    public function searchStyle($html, $search) {
        $after = str_replace($search, "<span style='background: yellow;'>$search</span>", $html);
        return $after;
     }

     // this is for dyanamic title function
    public function dynamicTitle() {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');

        if ($title == 'index') {
            $title = 'Home';
        }
        $title = ucwords($title);
        return $title." - khotiyan.com";
    }

    // get percent value
    public function getPercent($number, $percent){
        return ($percent/100) * $number;
    }

    // convert daag and khotiyan no from json to bengali string
    public function unserializeData($data){
        $jsontoarray = json_decode($data);  // জেসন ডাটাকে অ্যারেতে রুপান্তর || true মানে এটা এখন অ্যারে রিটার্ন করবে, অব্জেক্ট নয়
        $arraytosting = join(", ", $jsontoarray); // অ্যারে ডাটাকে স্ট্রিং এ রুপান্তর with comma
        $daag = $this->engToBangla($arraytosting);
        return $daag;
    }

    // see the user is admin, editor or else
    public function typeOfUser($role){
        if ($role == 3){
            return "অ্যাডমিন";
        }elseif ($role == 2){
            return "ইডিটর";
        }else{
            return "সাধারণ ইউজার";
        }
    }

    // create for user logo in profile
    public function get_first_charecter($username){
        return $username[0];
    }

}
