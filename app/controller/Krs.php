<?php

class Krs extends Controller
{
    public function index()
    {
        Permission::izinLogout();
        $data["myKrs"] = $this->model("Krs_model")->getMyKrs();
        $data["krs"] = $this->model("Krs_model")->getAllKrs();
        $data["krsDosen"] = $this->model("Krs_model")->getKrsDosen();
        $data["user"] = $this->model("Dashboard_model")->getMyData();
        $data["jumlahSks"] = $this->model("Krs_model")->jumlahSks();
        $data['dosenPembimbing'] = $this->model("Krs_model")->getDosenPembimbing();
        $data["title"] = "KRS";
        $this->view("templates/header", $data);
        $this->view("templates/aside", $data);
        $this->view("krs/index", $data);
        $this->view("templates/footer");
    }

    public function search()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model("Krs_model")->search($data));
    }

    public function ambilKrs($id_kelas)
    {
        if ($this->model("Krs_model")->ambilKrs($id_kelas)) {
            Flasher::setFlash('Berhasil ambil krs', 'success');
            $_SESSION['rollback_krs_id'] = $id_kelas;
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        } else {
            Flasher::setFlash('Gagal ambil krs, Kuota habis', 'error');
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        }
    }

    public function hapusKrs($id_kelas)
    {
        if ($this->model("Krs_model")->hapusKrs($id_kelas)) {
            Flasher::setFlash('Berhasil hapus krs', 'success');
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        } else {
            Flasher::setFlash('Gagal hapus krs', 'error');
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        }
    }

    public function validasiKrs($nim, $status) {
        if ($this->model("Krs_model")->validasiKrs($nim, $status)) {
            Flasher::setFlash('Berhasil validasi krs', 'success');
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        } else {
            Flasher::setFlash('Gagal validasi krs', 'error');
            header('location: ' . CONSTANT::DIRNAME . 'krs');
            exit;
        }
    }
}
