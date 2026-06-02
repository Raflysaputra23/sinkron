<?php

class Log_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllMahasiswa()
    {
        try {
            $this->db->query("SELECT nim, nama_lengkap FROM mahasiswa ORDER BY nama_lengkap ASC");
            $this->db->execute();
            return $this->db->resultSet();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function simulasiDeadlockStream($userNim, $userName, $classes, $userSlot)
    {
        $maxTries = 3;
        $try = 1;

        if ($userSlot == 'B' && count($classes) > 1) {
            $classes = array_reverse($classes);
        }

        $this->emit($userSlot, $userName, "info", "Memulai percobaan transaksi (Percobaan $try)...");

        while ($try <= $maxTries) {
            try {
                $this->db->beginTransaction();
                foreach ($classes as $index => $id_kelas) {
                    $this->emit($userSlot, $userName, "info", "Mencoba mengunci kelas $id_kelas...");

                    $this->db->query("SELECT * FROM kelas WHERE id_kelas = :id FOR UPDATE");
                    $this->db->bind("id", $id_kelas);
                    $this->db->execute();

                    $this->emit($userSlot, $userName, "success", "Berhasil mengunci kelas $id_kelas");
                    
                    $this->db->query("INSERT IGNORE INTO krs (nim, id_kelas) VALUES (:nim, :id_kelas)");
                    $this->db->bind("nim", $userNim);
                    $this->db->bind("id_kelas", $id_kelas);
                    $this->db->execute();

                    if ($index == 0 && count($classes) > 1) {
                        $this->emit($userSlot, $userName, "warning", "Menahan kunci! Menunggu 5 detik untuk user lain dapat mengunci...");
                        sleep(5);
                    }
                }
                
                $this->db->commit();
                $this->emit($userSlot, $userName, "success", "[Berhasil] Transaksi Selesai! Data KRS berhasil ditambahkan.");
                return;
            } catch (PDOException $e) {
                try {
                    $this->db->rollBack();
                } catch (PDOException $err) {
                }

                if (strpos($e->getMessage(), 'Deadlock') !== false || strpos($e->getMessage(), '40001') !== false || strpos($e->getMessage(), '1213') !== false) {
                    $this->emit($userSlot, $userName, "error", "[DEADLOCK TERDETEKSI!] Database menggagalkan transaksi karena saling mengunci.");
                    if ($try < $maxTries) {
                        $this->emit($userSlot, $userName, "warning", "Menunggu sebelum melakukan mekanisme Retry...");
                        sleep(rand(2, 4));
                        $try++;
                        $this->emit($userSlot, $userName, "info", "Memulai Retry (Percobaan $try)...");
                    } else {
                        $this->emit($userSlot, $userName, "error", "[Gagal] Tidak dapat memproses transaksi KRS setelah $maxTries percobaan.");
                        return;
                    }
                } else {
                    $this->emit($userSlot, $userName, "error", "Error DB: " . $e->getMessage());
                    return;
                }
            }
        }
    }

    private function emit($userSlot, $userName, $type, $message)
    {
        $out = json_encode([
            "userSlot" => $userSlot,
            "userName" => $userName,
            "type" => $type,
            "message" => $message,
            "time" => date('H:i:s')
        ]);
        echo $out . "\n";
        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }
}
