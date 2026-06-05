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
        $this->db->query("UPDATE konfigurasi_backup SET mode = 'otomatis', interval_waktu = :interval_waktu, last_backup = NULL WHERE id = :id");
        $this->db->bind('interval_waktu', $interval);
        $this->db->bind('id', 1);
        $this->db->execute();
        return true;
    }

    public function jalankanBackupManual() {
        $host = Constant::DBHOST;
        $user = Constant::DBUSER;
        $pass = Constant::DBPASS;
        $name = Constant::DBNAME;
        
        $namaFile = "backup_" . date('Y-m-d_H-i-s') . ".sql";
        $folderPenyimpanan = dirname(__DIR__, 2) . "/public/backups/";

        if (!file_exists($folderPenyimpanan)) {
            mkdir($folderPenyimpanan, 0777, true);
        }

        $pathPenyimpanan = $folderPenyimpanan . $namaFile;
        
        if ($this->eksekusiBackup($host, $user, $pass, $name, $pathPenyimpanan)) {
            $currentDatetime = date('Y-m-d H:i:s');
            $this->db->query("UPDATE konfigurasi_backup SET mode = 'manual', last_backup = :last_backup WHERE id = 1");
            $this->db->bind('last_backup', $currentDatetime);
            $this->db->execute();
            return true;
        }
        return false;
    }

    public function checkDanJalankanBackupOtomatis() {
        $config = $this->getConfig();
        if (!$config || $config['mode'] !== 'otomatis') {
            return false;
        }

        $interval = $config['interval_waktu'];
        $lastBackup = $config['last_backup'];

        if (empty($lastBackup)) {
            return $this->jalankanBackupOtomatis();
        }

        $lastBackupTime = strtotime($lastBackup);
        $currentTime = time();
        $shouldBackup = false;

        switch ($interval) {
            case 'setiap_jam':
                if ($currentTime - $lastBackupTime >= 3600) {
                    $shouldBackup = true;
                }
                break;
            case 'harian':
                if ($currentTime - $lastBackupTime >= 86400) {
                    $shouldBackup = true;
                }
                break;
            case 'mingguan':
                if ($currentTime - $lastBackupTime >= 604800) {
                    $shouldBackup = true;
                }
                break;
            case 'bulanan':
                if ($currentTime - $lastBackupTime >= 2592000) {
                    $shouldBackup = true;
                }
                break;
        }

        if ($shouldBackup) {
            return $this->jalankanBackupOtomatis();
        }

        return false;
    }

    public function jalankanBackupOtomatis() {
        // Lock last_backup immediately to prevent concurrent requests from triggering multiple backups
        $currentDatetime = date('Y-m-d H:i:s');
        $this->db->query("UPDATE konfigurasi_backup SET last_backup = :last_backup WHERE id = 1");
        $this->db->bind('last_backup', $currentDatetime);
        $this->db->execute();

        $host = Constant::DBHOST;
        $user = Constant::DBUSER;
        $pass = Constant::DBPASS;
        $name = Constant::DBNAME;
        
        $namaFile = "backup_otomatis_" . date('Y-m-d_H-i-s') . ".sql";
        $folderPenyimpanan = dirname(__DIR__, 2) . "/public/backups/";

        if (!file_exists($folderPenyimpanan)) {
            mkdir($folderPenyimpanan, 0777, true);
        }

        $pathPenyimpanan = $folderPenyimpanan . $namaFile;
        
        return $this->eksekusiBackup($host, $user, $pass, $name, $pathPenyimpanan);
    }

    private function eksekusiBackup($host, $user, $pass, $name, $pathPenyimpanan) {
        $batPath = dirname(__DIR__, 2) . "/mysqlbackup.bat";
        $logPath = dirname(__DIR__, 2) . "/public/backups/backup_error.log";
        $success = false;

        // Bersihkan log error lama jika ada
        if (file_exists($logPath)) {
            @unlink($logPath);
        }

        // Coba jalankan file .bat terlebih dahulu jika filenya ada
        if (file_exists($batPath)) {
            $command = "\"{$batPath}\" \"{$user}\" \"{$pass}\" \"{$host}\" \"{$name}\" \"{$pathPenyimpanan}\" 2>\"{$logPath}\"";
            system($command, $output);
            if ($output === 0) {
                $success = true;
                if (file_exists($logPath)) {
                    @unlink($logPath);
                }
            }
        }

        // Fallback ke command mysqldump langsung jika .bat gagal atau tidak ada
        if (!$success) {
            $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$name} > \"{$pathPenyimpanan}\" 2>\"{$logPath}\"";
            system($command, $output);
            if ($output === 0) {
                $success = true;
                if (file_exists($logPath)) {
                    @unlink($logPath);
                }
            }
        }

        return $success;
    }
}