<?php

class Backup extends Controller {
    
    public function index() {
        Permission::izinLogout();
        if(isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
            header('location:' . Constant::DIRNAME . 'dashboard');
            exit();
        }

        $data["user"] = $this->model("Dashboard_model")->getMyData();
        $data['config'] = $this->model('Backup_model')->getConfig();
        $data["title"] = "Backup Sistem";
        
        $this->view('templates/header', $data);
        $this->view('templates/aside', $data); 
        $this->view('backup/index', $data);
        $this->view('templates/footer');
    }

    public function proses() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mode = $_POST['mode_backup'];

            if ($mode == 'manual') {
                if ($this->model('Backup_model')->jalankanBackupManual()) {
                    Flasher::setFlash('Berhasil melakukan backup manual', 'success');
                } else {
                    Flasher::setFlash('Gagal melakukan backup manual', 'error');
                }
                header('Location: ' . Constant::DIRNAME . 'backup');
                exit;
            } else {
                $interval = $_POST['interval'];
                if ($this->model('Backup_model')->simpanKonfigurasiOtomatis($interval)) {
                    Flasher::setFlash('Berhasil melakukan backup otomatis', 'success');
                } else {
                    Flasher::setFlash('Gagal melakukan backup otomatis', 'error');
                }
                header('Location: ' . Constant::DIRNAME . 'backup');
                exit;
            }
        }
    }
}