<?php 

class Permission {
    public static function izinLogin() {
        if(isset($_SESSION["id_user"])) {
            header('location:'.Constant::DIRNAME.'dashboard');
        } else if(isset($_COOKIE["cookie"])) {
            $user = json_decode($_COOKIE["token"], false);
            if(password_verify($user->id_user, $_COOKIE["cookie"])) {
                $_SESSION["id_user"] = $user->id_user;
                $_SESSION["nama_lengkap"] = $user->nama_lengkap;
                $_SESSION["role"] = $user->role;
                header('location:'.Constant::DIRNAME.'dashboard');
                exit();
            }
        }
    }

    public static function izinLogout() {
        if(empty($_SESSION["id_user"])) {
            header('location:'.Constant::DIRNAME.'login');
        }
    }
}