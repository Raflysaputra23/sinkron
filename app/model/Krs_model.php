<?php


class Krs_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getMyKrs()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $this->db->query("CALL get_my_krs(:id_user)");
            $this->db->bind("id_user", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAllKrs()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $this->db->query("CALL get_all_krs(:id_user)");
            $this->db->bind("id_user", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function jumlahSks()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $this->db->query("select jumlah_sks(:id_user) as jumlah_sks");
            $this->db->bind("id_user", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            return $this->db->single();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function ambilKrs($id_kelas)
    {
        $id_user = $_SESSION["id_user"];

        $this->db->query("CALL ambil_krs(:id_user, :id_kelas, @status)");
        $this->db->bind("id_user", $id_user);
        $this->db->bind("id_kelas", $id_kelas);
        $this->db->execute();

        $this->db->query("SELECT @status as status");
        $this->db->execute();
        $result = $this->db->single();
        return $result["status"];
    }

    public function hapusKrs($id_kelas)
    {
        try {
            $id_user = $_SESSION["id_user"];
            $this->db->query("CALL hapus_krs(:id_user, :id_kelas, @status)");
            $this->db->bind("id_user", $id_user);
            $this->db->bind("id_kelas", $id_kelas);
            $this->db->execute();

            $this->db->query("SELECT @status as status");
            $this->db->execute();
            $result = $this->db->single();
            return $result["status"];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getKrsDosen()
    {
        try {
            $id_user = $_SESSION["id_user"];
            $this->db->query("CALL get_krs_dosen(:nip)");
            $this->db->bind("nip", $id_user);
            $this->db->execute();
            $this->db->closeCursor();
            $filtered = $this->filteredKrsDosen($this->db->resultSet());
            return $filtered;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function filteredKrsDosen($data)
    {
        $result = []; 

        foreach ($data as $row) {
            $nim = $row['nim'];

            if (!isset($result[$nim])) {
                $result[$nim] = [
                    "nim" => $nim,
                    "nama_mahasiswa" => $row['nama_mahasiswa'],
                    "total_sks" => 0,
                    "status" => $row['status'],
                    "krs" => []
                ];
            }
            $result[$nim]['total_sks'] += $row['sks'];
            $result[$nim]['krs'][] = [
                "id_mk" => $row['id_mk'],
                "nama_mk" => $row['nama_mk'],
                "sks" => $row['sks'],
                "id_kelas" => $row['id_kelas'],
                "hari" => $row['hari'],
                "jam_mulai" => $row['jam_mulai'],
                "jam_selesai" => $row['jam_selesai'],
                "ruangan" => $row['ruangan'],
                "status" => $row['status']
            ];
        }

        return $result;
    }

    public function getDosenPembimbing()
    {
        $id_user = $_SESSION['id_user'];

        try {
            $this->db->query("SELECT d.nama_lengkap, d.nip FROM mahasiswa as m JOIN dosen as d ON m.nip_pembimbing = d.nip WHERE m.nim = :nim");
            $this->db->bind('nim', $id_user);
            $this->db->execute();
            return $this->db->single();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function search($data)
    {
        $search = $data['search'];
        $id_user = $data['id_user'];

        try {
            $this->db->query('SELECT 
        m.nim,
        m.nama_lengkap AS nama_mahasiswa,
        mk.id_mk,
        mk.nama_mk,
        mk.sks,
        kls.id_kelas,
        kls.hari,
        kls.jam_mulai,
        kls.jam_selesai,
        kls.ruangan,
        kls.kuota,
        d.nama_lengkap AS nama_dosen,
        COALESCE(k.status, "belum diambil") AS status,
        k.updated_at,
        (
            SELECT COUNT(*) 
            FROM krs k2 
            WHERE k2.id_kelas = kls.id_kelas
        ) AS kuota_terisi,
        (
            kls.kuota - (
                SELECT COUNT(*) 
                FROM krs k3 
                WHERE k3.id_kelas = kls.id_kelas
            )
        ) AS sisa_kuota
    FROM kelas kls
    JOIN matakuliah mk ON kls.id_mk = mk.id_mk
    JOIN dosen d ON kls.id_dosen_koor = d.nip
    JOIN mahasiswa m ON m.nim = :nim
    LEFT JOIN krs k 
        ON k.id_kelas = kls.id_kelas 
        AND k.nim = :nim WHERE mk.nama_mk LIKE :nama_mk');
            $this->db->bind('nim', $id_user);
            $this->db->bind('nama_mk', '%' . $search . '%');
            $this->db->execute();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function validasiKrs($nim, $status)
    {
        $id_user = $_SESSION['id_user'];
        try {
            $this->db->query("CALL validasi_krs_mahasiswa(:nim, :nip, :status, @status)");
            $this->db->bind("nim", $nim);
            $this->db->bind("nip", $id_user);
            $this->db->bind("status", $status);
            $this->db->execute();

            $this->db->query("SELECT @status as status");
            $this->db->execute();
            $result = $this->db->single();
            return $result['status'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}