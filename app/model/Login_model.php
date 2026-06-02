<?php

class Login_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($data)
    {
        try {
            $username = htmlspecialchars($data["username"]);
            $password = htmlspecialchars($data["password"]);
            $rememberMe = isset($data["remember-me"]) ? true : false;

            $this->db->query("SELECT 
        u.username,
        u.password,
        u.role,
        CASE 
            WHEN u.role = 'mahasiswa' THEN m.nama_lengkap
            WHEN u.role = 'dosen' THEN d.nama_lengkap
            WHEN u.role = 'admin' THEN u.username
            ELSE NULL
        END AS nama_lengkap
    FROM `user` u
    LEFT JOIN mahasiswa as m ON m.nim = u.username
    LEFT JOIN dosen as d ON d.nip = u.username
    WHERE u.username = :username
    LIMIT 1;");

            $this->db->bind("username", $username);
            $this->db->execute();
            $user = $this->db->single();

            if ($user) {
                if (!password_verify($password, $user["password"])) {
                    Flasher::setFlash("Username / Password salah", "error");
                    header("Location: " . CONSTANT::DIRNAME . "login");
                    exit;
                } else {
                    $_SESSION["id_user"] = $user["username"];
                    $_SESSION["nama_lengkap"] = $user["nama_lengkap"];
                    $_SESSION["role"] = $user["role"];
                    if($rememberMe) {
                        $data = ["id_user" => $user["username"], "nama_lengkap" => $user["nama_lengkap"], "role" => $user["role"]];
                        setcookie("cookie", password_hash($data["id_user"], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 30, "/");
                        setcookie("token", json_encode($data), time() + 60 * 60 * 24 * 30, "/");
                    }
                    return true;
                }
            } else {
                Flasher::setFlash("Username / Password salah", "error");
                header("Location: " . CONSTANT::DIRNAME . "login");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}