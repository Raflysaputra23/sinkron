<?php

class Manajemen_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function tambah_mk($data) {
        $id_mk = "COM".mt_rand(10,99);
        $nama_mk = htmlspecialchars($data['nama_mk']);
        $sks = htmlspecialchars($data['sks']);

        try {
            $this->db->query("CALL tambah_mk(:id_mk, :nama_mk, :sks, @status)");
            $this->db->bind("id_mk", $id_mk);
            $this->db->bind("nama_mk", $nama_mk);
            $this->db->bind("sks", $sks);
            $this->db->execute();

            $this->db->query("SELECT @status as status");
            $result = $this->db->single();
            return $result["status"];
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function tambah_kelas($data) {
        $id_kelas = "COM".$data['id_kelas'].mt_rand(10, 99);
        $id_mk = $data['id_mk'];
        $id_dosen_koor = $data['id_dosen_koor'];
        $id_dosen_pendamping = isset($data['id_dosen_pendamping']) ? $data['id_dosen_pendamping'] : null;
        $hari = $data['hari'];
        $jam_mulai = $data['jam_mulai'];
        $jam_selesai = $data['jam_selesai'];
        $ruangan = $data['ruangan'];
        $kuota = $data['kuota'];

        try {
            $this->db->query("CALL tambah_kelas(:id_kelas, :id_mk, :id_dosen_koor, :id_dosen_pendamping, :hari, :jam_mulai, :jam_selesai, :ruangan, :kuota, @status)");
            $this->db->bind("id_kelas", $id_kelas);
            $this->db->bind("id_mk", $id_mk);
            $this->db->bind("id_dosen_koor", $id_dosen_koor);
            $this->db->bind("id_dosen_pendamping", $id_dosen_pendamping);
            $this->db->bind("hari", $hari);
            $this->db->bind("jam_mulai", $jam_mulai);
            $this->db->bind("jam_selesai", $jam_selesai);
            $this->db->bind("ruangan", $ruangan);
            $this->db->bind("kuota", $kuota);
            $this->db->execute();

            $this->db->query("SELECT @status as status");
            $result = $this->db->single();
            return $result["status"];
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function get_mk() {
        try {
            $this->db->query("SELECT * FROM get_mk");
            $this->db->execute();
            return $this->db->resultSet();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

     public function get_dosen() {
        try {
            $this->db->query("SELECT * FROM get_dosen");
            $this->db->execute();
            return $this->db->resultSet();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function get_mahasiswa_no_pembimbing() {
        try {
            $this->db->query("SELECT nim, nama_lengkap FROM mahasiswa WHERE nip_pembimbing IS NULL OR nip_pembimbing = '' ORDER BY nama_lengkap ASC");
            $this->db->execute();
            return $this->db->resultSet();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function assign_pembimbing($data) {
        $nim = htmlspecialchars($data['nim']);
        $nip_pembimbing = htmlspecialchars($data['nip_pembimbing']);

        try {
            $this->db->query("UPDATE mahasiswa SET nip_pembimbing = :nip_pembimbing WHERE nim = :nim");
            $this->db->bind("nip_pembimbing", $nip_pembimbing);
            $this->db->bind("nim", $nim);
            $this->db->execute();
            
            return $this->db->rowCount();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}