<?php
class session{
    public static function initial(){
        session_start();
    }

    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }

    public static function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }else{
            return false;
        }
    }

    public static function checkSession(){
        self::initial();
        if (self::get("adminlogin") == false) {
            self::destroy();
        }
    }
    
    public static function checkLogin(){
        self::initial();
        if (self::get("adminlogin") == true) {
            echo '<script>window.location = "index.php";</script>';
        }
    }

    public static function destroy(){
        session_destroy();
        echo '<script>window.location = "login.php";</script>';
    }
}