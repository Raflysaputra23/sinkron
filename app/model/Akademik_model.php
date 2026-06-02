<?php

class Akademik_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_semua_mk() {
        try {
            $this->db->query("SELECT * FROM matakuliah ORDER BY nama_mk ASC");
            $this->db->execute();
            return $this->db->resultSet();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function edit_mk($data) {
        $id_mk = htmlspecialchars($data['id_mk']);
        $nama_mk = htmlspecialchars($data['nama_mk']);
        $sks = htmlspecialchars($data['sks']);

        try {
            $this->db->query("CALL edit_mk(:id_mk, :nama_mk, :sks)");
            $this->db->bind("nama_mk", $nama_mk);
            $this->db->bind("sks", $sks);
            $this->db->bind("id_mk", $id_mk);
            $this->db->execute();
            return $this->db->rowCount();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function hapus_mk($id_mk) {
        try {
            $this->db->query("CALL hapus_mk(:id_mk)");
            $this->db->bind("id_mk", $id_mk);
            $this->db->execute();
            return $this->db->rowCount();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function get_semua_kelas() {
        try {
            $this->db->query("SELECT * FROM get_semua_kelas");
            $this->db->execute();
            return $this->db->resultSet();
        } catch(PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function edit_kelas($data) {
        $id_kelas = htmlspecialchars($data['id_kelas']);
        $hari = htmlspecialchars($data['hari']);
        $jam_mulai = htmlspecialchars($data['jam_mulai']);
        $jam_selesai = htmlspecialchars($data['jam_selesai']);
        $ruangan = htmlspecialchars($data['ruangan']);
        $kuota = htmlspecialchars($data['kuota']);
        $id_dosen_koor = htmlspecialchars($data['id_dosen_koor']);
        
        $id_dosen_pendamping = isset($data['id_dosen_pendamping']) && $data['id_dosen_pendamping'] !== "" ? htmlspecialchars($data['id_dosen_pendamping']) : null;

        try {
            $this->db->query("CALL update_kelas(:hari, :jam_mulai, :jam_selesai, :ruangan, :kuota, :id_dosen_koor, :id_dosen_pendamping, :id_kelas)");
            $this->db->bind('hari', $hari);
            $this->db->bind('jam_mulai', $jam_mulai);
            $this->db->bind('jam_selesai', $jam_selesai);
            $this->db->bind('ruangan', $ruangan);
            $this->db->bind('kuota', $kuota);
            $this->db->bind('id_dosen_koor', $id_dosen_koor);
            $this->db->bind('id_dosen_pendamping', $id_dosen_pendamping);
            $this->db->bind('id_kelas', $id_kelas);
            $this->db->execute();
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function hapus_kelas($id_kelas) {
        try {
            $this->db->query("DELETE FROM kelas WHERE id_kelas = :id_kelas");
            $this->db->bind("id_kelas", $id_kelas);
            $this->db->execute();
            return $this->db->rowCount();
        } catch(PDOException $e) {
            return false;
        }
    }
}
