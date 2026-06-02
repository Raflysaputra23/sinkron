<?php

class Log extends Controller {
    public function index() {
        Permission::izinLogout();
        $data["user"] = $this->model("Dashboard_model")->getMyData();
        $data["krs"] = $this->model("Krs_model")->getAllKrs() ?: [];
        $data["mahasiswa"] = $this->model("Log_model")->getAllMahasiswa() ?: [];
        $data["title"] = "Log Simulasi (PDT)";
        $this->view("templates/header", $data);
        $this->view("templates/aside", $data);
        $this->view("log/index", $data);
        $this->view("templates/footer");
    }

    public function streamDeadlock() {
        Permission::izinLogout();

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Cache-Control: no-cache');
        header('Content-Type: application/json');
        header('X-Accel-Buffering: no');

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_GET;
        }

        if (isset($input['userNim']) && isset($input['userName']) && isset($input['classes']) && is_array($input['classes'])) {
            $userNim = $input['userNim'];
            $userName = $input['userName'];
            $userSlot = isset($input['userSlot']) ? $input['userSlot'] : 'A';
            $classes = $input['classes'];
            $this->model("Log_model")->simulasiDeadlockStream($userNim, $userName, $classes, $userSlot);
        } else {
            echo json_encode(["error" => "Parameter tidak valid"]) . "\n";
            flush();
        }
    }
}
