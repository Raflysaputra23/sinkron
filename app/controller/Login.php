<?php


class Login extends Controller {
    public function index() {
        Permission::izinLogin();
        $data["title"] = "Login";
        $this->view("templates/header", $data);
        $this->view("login/index");
        $this->view("templates/footer");
    }

    public function login() {
        if($this->model("Login_model")->login($_POST)) {
            Flasher::setFlash("Login berhasil","success");
            header("Location: " . CONSTANT::DIRNAME . "dashboard");
            exit;
        } else {
            Flasher::setFlash("Login gagal","error");
            header("Location: " . CONSTANT::DIRNAME . "login");
            exit;
        }
    }
}