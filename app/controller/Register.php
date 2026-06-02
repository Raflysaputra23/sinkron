<?php

class Register extends Controller {
    public function index() {
        Permission::izinLogin();
        $data["title"] = "Register";
        $this->view("templates/header", $data);
        $this->view("register/index");
        $this->view("templates/footer");
    }

    public function register() {
        if($this->model("Register_model")->register($_POST)) {
            Flasher::setFlash("Register berhasil", "success");
            header("location: ".CONSTANT::DIRNAME."login");
            exit;
        } else {
            Flasher::setFlash("Register gagal","error");
            header("location: ".CONSTANT::DIRNAME."register");
            exit;
        }
    }
}
