<?php

class Akademik extends Controller {
    public function index() {
        Permission::izinLogout();
        if(isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
            header('location:'.CONSTANT::DIRNAME.'dashboard');
            exit();
        }

        $data["user"] = $this->model("Dashboard_model")->getMyData();
        $data["dosen"] = $this->model("Manajemen_model")->get_dosen();
        $data["mk"] = $this->model("Akademik_model")->get_semua_mk();
        $data["kelas"] = $this->model("Akademik_model")->get_semua_kelas();
        $data["title"] = "Data Akademik";
        
        $this->view("templates/header", $data);
        $this->view("templates/aside", $data);
        $this->view("akademik/index", $data);
        $this->view("templates/footer");
    }

    public function edit_mk() {
        Permission::izinLogout();
        if($this->model('Akademik_model')->edit_mk($_POST) > 0) {
            Flasher::setFlash('Mata Kuliah berhasil diedit', 'success');
        } else {
            Flasher::setFlash('Mata Kuliah gagal diedit','error');
        }
        header('location:'.CONSTANT::DIRNAME.'akademik');
        exit();
    }

    public function hapus_mk($id_mk) {
        Permission::izinLogout();
        if($this->model('Akademik_model')->hapus_mk($id_mk) > 0) {
            Flasher::setFlash('Mata Kuliah berhasil dihapus', 'success');
        } else {
            Flasher::setFlash('Mata Kuliah gagal dihapus', 'error');
        }
        header('location:'.CONSTANT::DIRNAME.'akademik');
        exit();
    }

    public function edit_kelas() {
        Permission::izinLogout();
        if($this->model('Akademik_model')->edit_kelas($_POST)) {
            Flasher::setFlash('Data Kelas berhasil diedit', 'success');
        } else {
            Flasher::setFlash('Data Kelas gagal diedit','error');
        }
        header('location:'.CONSTANT::DIRNAME.'akademik');
        exit();
    }

    public function hapus_kelas($id_kelas) {
        Permission::izinLogout();
        if($this->model('Akademik_model')->hapus_kelas($id_kelas) > 0) {
            Flasher::setFlash('Kelas berhasil dihapus', 'success');
        } else {
            Flasher::setFlash('Kelas gagal dihapus (Mungkin ada mahasiswa di dalamnya)','error');
        }
        header('location:'.CONSTANT::DIRNAME.'akademik');
        exit();
    }
}
