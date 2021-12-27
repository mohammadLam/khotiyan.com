<?php

class Cookie{

    public static function initial(){

        session_start();

    }



    public static function set($key, $val){

        // date_default_timezone_set("Asia/Dhaka");

        setcookie($key, $val, time()+24*60*60*30, '/');

    }



    public static function get($key){

        if (isset($_COOKIE[$key])) {

            return $_COOKIE[$key];

        }else{

            return false;

        }

    }



    public static function checkSession(){

        if (self::get("userlogin") == false) {

            echo '<script>window.location = "login.php";</script>';

        }

    }

    

    public static function checkLogin(){

        if (self::get("userlogin") == true) {

            echo '<script>window.location = "index.php";</script>';

        }

    }



    public static function destroy(){

        session_destroy();

        echo '<script>window.location = "login.php";</script>';

    }

}