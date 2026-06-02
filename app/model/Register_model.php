<?php

class Register_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data)
    {
        try {
            $nama_lengkap = htmlspecialchars(isset($data["nama_lengkap"]) ? $data["nama_lengkap"] : $data["username"]);
            $username = htmlspecialchars($data["username"]);
            $password = htmlspecialchars($data["password"]);
            $password2 = htmlspecialchars($data["password2"]);
            $role = $data["role"];

            if ($password != $password2) {
                Flasher::setFlash("Password tidak sama", "error");
                header("Location: " . CONSTANT::DIRNAME . "register");
                exit;
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $this->db->query("CALL register(:username, :nama_lengkap, :password, :role, @status)");
            $this->db->bind("username", $username);
            $this->db->bind("nama_lengkap", $nama_lengkap);
            $this->db->bind("password", $password_hash);
            $this->db->bind("role", $role);
            $this->db->execute();

            $this->db->query("SELECT @status as status");
            $result = $this->db->single();
            return $result["status"];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}