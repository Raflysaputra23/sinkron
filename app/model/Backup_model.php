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

        // Langkah 1: Coba jalankan file .bat terlebih dahulu jika filenya ada
        if (file_exists($batPath)) {
            $command = "\"{$batPath}\" \"{$user}\" \"{$pass}\" \"{$host}\" \"{$name}\" \"{$pathPenyimpanan}\" 2>\"{$logPath}\"";
            system($command, $output);
            if ($output === 0) {
                $success = true;
                if (file_exists($logPath)) @unlink($logPath);
            }
        }

        // Langkah 2: Fallback ke command mysqldump langsung jika .bat gagal atau tidak ada
        if (!$success) {
            $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$name} > \"{$pathPenyimpanan}\" 2>\"{$logPath}\"";
            system($command, $output);
            if ($output === 0) {
                $success = true;
                if (file_exists($logPath)) @unlink($logPath);
            }
        }

        // Langkah 3: Fallback terakhir - Backup murni PHP via PDO (tidak butuh mysqldump sama sekali!)
        if (!$success) {
            if (file_exists($logPath)) @unlink($logPath);
            $success = $this->backupViaPHP($host, $user, $pass, $name, $pathPenyimpanan);
        }

        return $success;
    }

    private function backupViaPHP($host, $user, $pass, $name, $pathPenyimpanan) {
        try {
            $pdo = new PDO(
                "mysql:host={$host};dbname={$name};charset=utf8mb4",
                $user,
                $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $sql  = "-- ========================================\n";
            $sql .= "-- Database Backup: {$name}\n";
            $sql .= "-- Dibuat pada: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Metode: PHP PDO Native\n";
            $sql .= "-- ========================================\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n";
            $sql .= "SET NAMES utf8mb4;\n\n";

            // Ambil semua tabel (bukan view) dengan urutan dependensi yang benar
            $tabelStmt = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
            $semuaTabel = $tabelStmt->fetchAll(PDO::FETCH_COLUMN);

            // Urutkan tabel berdasarkan dependensi foreign key agar tidak error saat import
            $tabelTerurut = $this->urutkanTabel($pdo, $semuaTabel, $name);

            // Export setiap tabel: struktur + data
            foreach ($tabelTerurut as $tabel) {
                // Struktur tabel
                $createStmt = $pdo->query("SHOW CREATE TABLE `{$tabel}`");
                $createRow  = $createStmt->fetch(PDO::FETCH_ASSOC);
                $createSql  = $createRow['Create Table'];

                $sql .= "-- ------------------------------------------\n";
                $sql .= "-- Tabel: `{$tabel}`\n";
                $sql .= "-- ------------------------------------------\n";
                $sql .= "DROP TABLE IF EXISTS `{$tabel}`;\n";
                $sql .= $createSql . ";\n\n";

                // Data tabel
                $dataStmt = $pdo->query("SELECT * FROM `{$tabel}`");
                $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    $kolom = array_map(fn($k) => "`{$k}`", array_keys($rows[0]));
                    $sql .= "INSERT INTO `{$tabel}` (" . implode(', ', $kolom) . ") VALUES\n";
                    $values = [];
                    foreach ($rows as $row) {
                        $escaped = array_map(function($val) use ($pdo) {
                            if ($val === null) return 'NULL';
                            return $pdo->quote($val);
                        }, $row);
                        $values[] = "(" . implode(', ', $escaped) . ")";
                    }
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }

            // Export semua VIEW sebagai VIEW (bukan tabel)
            $viewStmt = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'VIEW'");
            $semuaView = $viewStmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($semuaView as $view) {
                $createStmt = $pdo->query("SHOW CREATE VIEW `{$view}`");
                $createRow  = $createStmt->fetch(PDO::FETCH_ASSOC);
                $createSql  = $createRow['Create View'];

                $sql .= "-- ------------------------------------------\n";
                $sql .= "-- View: `{$view}`\n";
                $sql .= "-- ------------------------------------------\n";
                $sql .= "DROP VIEW IF EXISTS `{$view}`;\n";
                $sql .= $createSql . ";\n\n";
            }

            // Export semua PROCEDURE
            $procStmt = $pdo->query("SHOW PROCEDURE STATUS WHERE Db = '{$name}'");
            $procs = $procStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($procs as $proc) {
                $procName = $proc['Name'];
                $createStmt = $pdo->query("SHOW CREATE PROCEDURE `{$procName}`");
                $createRow  = $createStmt->fetch(PDO::FETCH_ASSOC);
                $createSql  = $createRow['Create Procedure'];
                $sql .= "-- Procedure: `{$procName}`\n";
                $sql .= "DROP PROCEDURE IF EXISTS `{$procName}`;\n";
                $sql .= "DELIMITER ;;\n{$createSql};;\nDELIMITER ;\n\n";
            }

            // Export semua FUNCTION
            $funcStmt = $pdo->query("SHOW FUNCTION STATUS WHERE Db = '{$name}'");
            $funcs = $funcStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($funcs as $func) {
                $funcName = $func['Name'];
                $createStmt = $pdo->query("SHOW CREATE FUNCTION `{$funcName}`");
                $createRow  = $createStmt->fetch(PDO::FETCH_ASSOC);
                $createSql  = $createRow['Create Function'];
                $sql .= "-- Function: `{$funcName}`\n";
                $sql .= "DROP FUNCTION IF EXISTS `{$funcName}`;\n";
                $sql .= "DELIMITER ;;\n{$createSql};;\nDELIMITER ;\n\n";
            }

            // Export semua TRIGGER
            $triggerStmt = $pdo->query("SHOW TRIGGERS FROM `{$name}`");
            $triggers = $triggerStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($triggers as $trigger) {
                $triggerName = $trigger['Trigger'];
                $sql .= "-- Trigger: `{$triggerName}`\n";
                $sql .= "DROP TRIGGER IF EXISTS `{$triggerName}`;\n";
                $sql .= "DELIMITER ;;\n";
                $sql .= "CREATE TRIGGER `{$triggerName}` {$trigger['Timing']} {$trigger['Event']} ON `{$trigger['Table']}` FOR EACH ROW\n";
                $sql .= "{$trigger['Statement']};;\n";
                $sql .= "DELIMITER ;\n\n";
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            $sql .= "-- ========================================\n";
            $sql .= "-- Backup selesai: " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- ========================================\n";

            return file_put_contents($pathPenyimpanan, $sql) !== false;

        } catch (Exception $e) {
            $logPath = dirname(__DIR__, 2) . "/public/backups/backup_error.log";
            file_put_contents($logPath, "PHP PDO Backup Error: " . $e->getMessage());
            return false;
        }
    }

    private function urutkanTabel($pdo, $tabelList, $dbName) {
        // Buat graf dependensi foreign key antar tabel
        $dependensi = [];
        foreach ($tabelList as $tabel) {
            $dependensi[$tabel] = [];
        }

        $fkStmt = $pdo->query("
            SELECT TABLE_NAME, REFERENCED_TABLE_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = '{$dbName}'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        $fkRows = $fkStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($fkRows as $fk) {
            $tabel = $fk['TABLE_NAME'];
            $ref   = $fk['REFERENCED_TABLE_NAME'];
            if (isset($dependensi[$tabel]) && $tabel !== $ref) {
                $dependensi[$tabel][] = $ref;
            }
        }

        // Topological sort (Kahn's algorithm)
        $dikunjungi = [];
        $hasil = [];

        $kunjungi = function($node) use (&$kunjungi, &$dikunjungi, &$hasil, $dependensi) {
            if (in_array($node, $dikunjungi)) return;
            $dikunjungi[] = $node;
            foreach ($dependensi[$node] ?? [] as $dep) {
                $kunjungi($dep);
            }
            $hasil[] = $node;
        };

        foreach ($tabelList as $tabel) {
            $kunjungi($tabel);
        }

        return $hasil;
    }
}