<?php

class Dashboard_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getMyData()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $role = $_SESSION["role"];

            if ($role == 'mahasiswa') {
                $this->db->query("SELECT nim, nama_lengkap, foto, jurusan, ipk, sks, (SELECT DISTINCT status from krs WHERE nim = :id_user LIMIT 1) as status FROM mahasiswa WHERE nim = :id_user");
            } else if ($role == 'dosen') {
                $this->db->query("SELECT * FROM dosen WHERE nip = :id_user");
            } else {
                $this->db->query("SELECT * FROM user WHERE username = :id_user");
            }

            $this->db->bind("id_user", $id_user);
            $this->db->execute();
            return $this->db->single();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getMyJadwal()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $hariIni = (int) date('w');

            $this->db->query("SELECT m.nama_mk, m.sks, d1.nama_lengkap as dosen_koor, d2.nama_lengkap as dosen_pendamping, hari, jam_mulai, jam_selesai, ruangan FROM krs JOIN kelas as k ON krs.id_kelas = k.id_kelas JOIN matakuliah as m ON k.id_mk = m.id_mk LEFT JOIN dosen as d1 ON k.id_dosen_koor = d1.nip LEFT JOIN dosen as d2 ON k.id_dosen_pendamping = d2.nip WHERE krs.nim = :id_user");
            $this->db->bind("id_user", $id_user);
            $this->db->execute();
            $result = $this->db->resultSet();

            $filterJadwal = [];
            foreach ($result as $hari) {
                if (($hari['hari'] + 1) == $hariIni) {
                    $filterJadwal[] = $hari;
                }
            }
            return $filterJadwal;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getDataAdmin()
    {
        try {
            $this->db->query("CALL get_info_admin()");
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->single();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getMahasiswaDosen()
    {
        try {
            $this->db->query("SELECT * FROM getmahasiswadosen");
            $this->db->execute();
            return $this->filteredUsers($this->db->resultSet());
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function filteredUsers($data) {
        $result = [];
        foreach($data as $user) {
            $result[$user['role']][] = $user;
        }
        return $result;
    }

    public function getDataDosen()
    {
        $id_user = $_SESSION['id_user'];
        try {
            $this->db->query("CALL get_info_dosen(:nip)");
            $this->db->bind("nip", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->single();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getJadwalDosen()
    {
        $id_user = $_SESSION['id_user'];

        try {
            $this->db->query("CALL get_jadwal_dosen(:nip)");
            $this->db->bind("nip", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}