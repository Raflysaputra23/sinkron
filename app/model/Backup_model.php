<?php

class Backup_model {
    private Database $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function getConfig() {
        $this->db->query("SELECT * FROM konfigurasi_backup LIMIT 1");
        return $this->db->single();
    }

    public function simpanKonfigurasiOtomatis(string $interval) {
        $query = "UPDATE konfigurasi_backup SET mode = 'otomatis', interval_waktu = :interval_waktu WHERE id = 1";
        $this->db->query($query);
        $this->db->bind('interval_waktu', $interval);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function jalankanBackupManual() {
        $host = Constant::DBHOST;
        $user = Constant::DBUSER;
        $pass = Constant::DBPASS;
        $name = Constant::DBNAME;
        
        $namaFile = "backup_" . date('Y-m-d_H-i-s') . ".sql";
        $folderPenyimpanan = $_SERVER['DOCUMENT_ROOT'] . "/sinkron/public/backups/";

        if (!file_exists($folderPenyimpanan)) {
            mkdir($folderPenyimpanan, 0777, true);
        }

        $pathPenyimpanan = $folderPenyimpanan . $namaFile;
        $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$name} > {$pathPenyimpanan}";
        
        system($command, $output);
        return ($output === 0);
    }
}