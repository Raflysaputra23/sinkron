<?php

class Manajemen extends Controller {
    public function index() {
        Permission::izinLogout();
        if(isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
            header('location:'.CONSTANT::DIRNAME.'dashboard');
            exit();
        }
        $data['mk'] = $this->model('Manajemen_model')->get_mk();
        $data['dosen'] = $this->model('Manajemen_model')->get_dosen();
        $data['mahasiswa_no_pembimbing'] = $this->model('Manajemen_model')->get_mahasiswa_no_pembimbing();
        $data["user"] = $this->model("Dashboard_model")->getMyData();
        $data["title"] = "Manajemen Data";
        $this->view("templates/header", $data);
        $this->view("templates/aside", $data);
        $this->view("manajemen/index", $data);
        $this->view("templates/footer");
    }

    public function tambah_mk() {
        if($this->model('Manajemen_model')->tambah_mk($_POST) > 0) {
            Flasher::setFlash('Matkul berhasil ditambahkan', 'success');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        } else {
            Flasher::setFlash('Matkul gagal ditambahkan','error');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        }
    }

    public function tambah_kelas() {
        if($this->model('Manajemen_model')->tambah_kelas($_POST) > 0) {
            Flasher::setFlash('Kelas berhasil ditambahkan', 'success');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        } else {
            Flasher::setFlash('Kelas gagal ditambahkan','error');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        }
    }

    public function tambah_pembimbing() {
        if($this->model('Manajemen_model')->assign_pembimbing($_POST) > 0) {
            Flasher::setFlash('Dosen Pembimbing berhasil ditambahkan', 'success');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        } else {
            Flasher::setFlash('Dosen Pembimbing gagal ditambahkan','error');
            header('location:'.CONSTANT::DIRNAME.'manajemen');
            exit();
        }
    }

}
