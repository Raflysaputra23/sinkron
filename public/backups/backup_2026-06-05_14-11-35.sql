-- ========================================
-- Database Backup: db_sinkron
-- Dibuat pada: 2026-06-05 14:11:38
-- Metode: PHP PDO Native
-- ========================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- ------------------------------------------
-- Tabel: `dosen`
-- ------------------------------------------
DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nip` char(18) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `dosen` (`id_user`, `nip`, `nama_lengkap`) VALUES
('2', '2417051050', 'Arip'),
('3', '198765432100000001', 'Budi Santoso, S.Kom.'),
('4', '198609262015051001', 'Pak Afdhall'),
('5', '198609262015051002', 'Pak Alwine');

-- ------------------------------------------
-- Tabel: `matakuliah`
-- ------------------------------------------
DROP TABLE IF EXISTS `matakuliah`;
CREATE TABLE `matakuliah` (
  `id_mk` char(10) NOT NULL,
  `nama_mk` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sks` int NOT NULL,
  PRIMARY KEY (`id_mk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `matakuliah` (`id_mk`, `nama_mk`, `sks`) VALUES
('COM20', 'Pemrograman Web', '3'),
('COM22', 'Pemrograman Terdistribusi', '3'),
('COM24', 'Sistem Informasi', '3'),
('COM81', 'AI', '3'),
('COM90', 'Machine Learning', '3');

-- ------------------------------------------
-- Tabel: `kelas`
-- ------------------------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id_kelas` varchar(20) NOT NULL,
  `id_mk` char(10) NOT NULL,
  `id_dosen_koor` char(20) NOT NULL,
  `id_dosen_pendamping` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hari` int NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(100) NOT NULL,
  `kuota` int NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `fk_kelas_dosen1` (`id_dosen_koor`),
  KEY `fk_kelas_dosen2` (`id_dosen_pendamping`),
  KEY `fk_kelas_mk` (`id_mk`),
  CONSTRAINT `fk_kelas_dosen1` FOREIGN KEY (`id_dosen_koor`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kelas_dosen2` FOREIGN KEY (`id_dosen_pendamping`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kelas_mk` FOREIGN KEY (`id_mk`) REFERENCES `matakuliah` (`id_mk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kelas` (`id_kelas`, `id_mk`, `id_dosen_koor`, `id_dosen_pendamping`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`, `kuota`) VALUES
('COMA20', 'COM20', '198765432100000001', NULL, '1', '07:30:00', '09:15:00', 'GIK C', '50'),
('COMA44', 'COM90', '198765432100000001', NULL, '0', '16:00:00', '17:30:00', 'GIK C Lt. 2', '50'),
('COMAB', 'COM22', '2417051050', '198765432100000001', '0', '11:00:00', '12:45:00', 'LAB R1', '50'),
('COMAB36', 'COM81', '198609262015051002', NULL, '0', '14:00:00', '15:30:00', 'GIK C Lt.1', '50'),
('COMB20', 'COM20', '2417051050', '198765432100000001', '2', '07:30:00', '09:15:00', 'GIK C Lt. 2', '50');

-- ------------------------------------------
-- Tabel: `konfigurasi_backup`
-- ------------------------------------------
DROP TABLE IF EXISTS `konfigurasi_backup`;
CREATE TABLE `konfigurasi_backup` (
  `id` int NOT NULL,
  `mode` enum('manual','otomatis') NOT NULL DEFAULT 'manual',
  `interval_waktu` varchar(50) DEFAULT NULL,
  `last_backup` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `konfigurasi_backup` (`id`, `mode`, `interval_waktu`, `last_backup`) VALUES
('1', 'manual', 'mingguan', '2026-06-05 13:10:07');

-- ------------------------------------------
-- Tabel: `mahasiswa`
-- ------------------------------------------
DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `ipk` float NOT NULL DEFAULT '0',
  `sks` int NOT NULL DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL,
  `nip_pembimbing` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `nim` (`nim`),
  KEY `fk_mahasiswa_dosen` (`nip_pembimbing`),
  CONSTRAINT `fk_mahasiswa_dosen` FOREIGN KEY (`nip_pembimbing`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mahasiswa` (`id_user`, `nim`, `nama_lengkap`, `jurusan`, `ipk`, `sks`, `foto`, `nip_pembimbing`) VALUES
('1', '2417051044', 'Doni', 'Ilmu Komputer', '3.8', '64', NULL, '2417051050'),
('2', '2417051049', 'M. Rafly Saputra', 'Ilmu Komputer', '3.6', '67', NULL, '2417051050'),
('3', '2417051051', 'Ridho', 'Ilmu Komputer', '3.8', '0', NULL, '198609262015051001'),
('4', '2417051052', 'Bagas', 'Ilmu Komputer', '2', '0', NULL, NULL),
('5', '2317051064', 'Abdul', 'Ilmu Komputer', '3.9', '0', NULL, NULL),
('6', '2417051011', 'Surya Gymnastyar', 'Ilmu Komputer', '3.9', '0', NULL, NULL),
('7', '2417051010', 'Dinda Shaumi', 'Ilmu Komputer', '3.8', '0', NULL, NULL);

-- ------------------------------------------
-- Tabel: `krs`
-- ------------------------------------------
DROP TABLE IF EXISTS `krs`;
CREATE TABLE `krs` (
  `nim` char(10) NOT NULL,
  `id_kelas` varchar(20) NOT NULL,
  `status` enum('disetujui','ditolak','menunggu') NOT NULL DEFAULT 'menunggu',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`nim`,`id_kelas`),
  KEY `fk_krs_kelas` (`id_kelas`),
  CONSTRAINT `fk_krs_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_krs_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `krs` (`nim`, `id_kelas`, `status`, `updated_at`) VALUES
('2417051044', 'COMA20', 'disetujui', '2026-06-05 12:43:22'),
('2417051044', 'COMA44', 'disetujui', '2026-06-05 12:43:22'),
('2417051044', 'COMAB', 'disetujui', '2026-06-05 12:43:22'),
('2417051044', 'COMAB36', 'disetujui', '2026-06-05 12:43:22'),
('2417051044', 'COMB20', 'disetujui', '2026-06-05 12:43:22'),
('2417051049', 'COMA20', 'menunggu', '2026-06-05 12:57:47'),
('2417051049', 'COMAB36', 'disetujui', '2026-06-05 12:44:43'),
('2417051049', 'COMB20', 'disetujui', '2026-06-05 12:44:43');

-- ------------------------------------------
-- Tabel: `log`
-- ------------------------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('berhasil','gagal','menunggu') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `fk_log_dosen` (`id_user`),
  CONSTRAINT `fk_log_dosen` FOREIGN KEY (`id_user`) REFERENCES `dosen` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_log_mahasiswa` FOREIGN KEY (`id_user`) REFERENCES `mahasiswa` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ------------------------------------------
-- Tabel: `mahasiswa_identitas`
-- ------------------------------------------
DROP TABLE IF EXISTS `mahasiswa_identitas`;
CREATE TABLE `mahasiswa_identitas` (
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mahasiswa_identitas` (`nim`, `nama_lengkap`, `jurusan`, `foto`) VALUES
('2417051044', 'Doni', 'Ilmu Komputer', NULL),
('2417051049', 'M. Rafly Saputra', 'Ilmu Komputer', NULL),
('2417051051', 'Ridho', 'Ilmu Komputer', NULL),
('2417051052', 'Bagas', 'Ilmu Komputer', NULL),
('2317051064', 'Abdul', 'Ilmu Komputer', NULL),
('2417051011', 'Surya Gymnastyar', 'Ilmu Komputer', NULL),
('2417051010', 'Dinda Shaumi', 'Ilmu Komputer', NULL);

-- ------------------------------------------
-- Tabel: `mahasiswa_ipk_tinggi`
-- ------------------------------------------
DROP TABLE IF EXISTS `mahasiswa_ipk_tinggi`;
CREATE TABLE `mahasiswa_ipk_tinggi` (
  `id_user` int NOT NULL DEFAULT '0',
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `ipk` float NOT NULL DEFAULT '0',
  `sks` int NOT NULL DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL,
  `nip_pembimbing` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mahasiswa_ipk_tinggi` (`id_user`, `nim`, `nama_lengkap`, `jurusan`, `ipk`, `sks`, `foto`, `nip_pembimbing`) VALUES
('1', '2417051044', 'Doni', 'Ilmu Komputer', '3.8', '64', NULL, '2417051050'),
('2', '2417051049', 'M. Rafly Saputra', 'Ilmu Komputer', '3.6', '67', NULL, '2417051050'),
('3', '2417051051', 'Ridho', 'Ilmu Komputer', '3.8', '0', NULL, '198609262015051001'),
('5', '2317051064', 'Abdul', 'Ilmu Komputer', '3.9', '0', NULL, NULL),
('6', '2417051011', 'Surya Gymnastyar', 'Ilmu Komputer', '3.9', '0', NULL, NULL),
('7', '2417051010', 'Dinda Shaumi', 'Ilmu Komputer', '3.8', '0', NULL, NULL);

-- ------------------------------------------
-- Tabel: `user`
-- ------------------------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('mahasiswa','dosen','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `created_at`) VALUES
('2', '2417051044', '$2y$10$YUo0LCpTR.xueNJ8D76psOwBVvfgipbZcbLq4HxMZry4ncYrpbD6i', 'mahasiswa', '2026-04-06 01:47:22'),
('3', '2417051049', '$2y$10$vP63iit3FNRCvgkKJ1yrTeZgQBUTq5zF7rWfSUF9vS2K8Yhe4Alda', 'mahasiswa', '2026-04-06 11:11:34'),
('4', '2417051050', '$2y$10$fJjIOCEND4GkacJmYcEBf.nYAUNRWzpgu0rjEgjAt.9HFt1yauBYe', 'dosen', '2026-04-06 18:18:30'),
('5', '198765432100000001', '$2y$10$g2gQ1Wj7LpEjmclBTxB10OoAr11XJ62KMsR9QM7FapPxO2ktMspSW', 'dosen', '2026-04-07 00:21:18'),
('6', 'Rafly', '$2y$10$F6AfJ8rCjiHV6/iMdVuoaenF10t7BHENeRQBm8sVWCdpGOiW7YhZG', 'admin', '2026-04-07 00:43:05'),
('7', '2417051051', '$2y$10$QmGutogq.IrYVfH5uy6V5eX5OxIkxMT2D0pWoW1Ho1oEJvjQGppMy', 'mahasiswa', '2026-04-07 15:23:32'),
('10', '198609262015051001', '$2y$10$4mIM5LcRT0rPZsgIo8gkjukvVeXqC.udsLEGxsbmsQuAzHeGqDK2q', 'dosen', '2026-04-07 15:25:29'),
('11', '2417051052', '$2y$10$ptahOMMeI56JaR8G6ijzTes0mYvMcXzBkfFmLjUH4CX36CZm.ZyDS', 'mahasiswa', '2026-04-07 15:26:36'),
('12', '198609262015051002', '$2y$10$IIyhbdBYyGc4cEMtKadOu.PH8vGFKBWz6tCrDM0kSxku47fNB94gm', 'dosen', '2026-04-07 15:26:58'),
('13', 'Ilham', '$2y$10$H6GRQYFLDTBvv.cCLKiKOOF8iBBhhfifBldXFZ6QeE5NSCwrVd6Xi', 'admin', '2026-04-07 16:12:10'),
('14', '2317051064', '$2y$10$jSTXCDvJoHZWoRWtBI6jo.eoQTCOl/aIEoH0Rr36hBK429vrjLm7a', 'mahasiswa', '2026-04-07 16:58:31'),
('15', '2417051011', '$2y$10$w.GkfLzKikeJKTMuWGx5u.G4aBA0CicYuMhyTdjlkcIexK0LJ.gGK', 'mahasiswa', '2026-06-05 19:18:17'),
('16', '2417051010', '$2y$10$GVTSR6waAMDTDhCU3d4q/eqX26KuxPbttlkBaxjz6GkZAU9cNC55y', 'mahasiswa', '2026-06-05 19:18:30');

-- ------------------------------------------
-- View: `get_dosen`
-- ------------------------------------------
DROP VIEW IF EXISTS `get_dosen`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_dosen` AS select `dosen`.`nip` AS `nip`,`dosen`.`nama_lengkap` AS `nama_lengkap` from `dosen`;

-- ------------------------------------------
-- View: `get_mk`
-- ------------------------------------------
DROP VIEW IF EXISTS `get_mk`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_mk` AS select `matakuliah`.`id_mk` AS `id_mk`,`matakuliah`.`nama_mk` AS `nama_mk` from `matakuliah`;

-- ------------------------------------------
-- View: `get_semua_kelas`
-- ------------------------------------------
DROP VIEW IF EXISTS `get_semua_kelas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_semua_kelas` AS select `mk`.`id_mk` AS `id_mk`,`mk`.`nama_mk` AS `nama_mk`,`mk`.`sks` AS `sks`,`kls`.`id_kelas` AS `id_kelas`,`kls`.`hari` AS `hari`,`kls`.`jam_mulai` AS `jam_mulai`,`kls`.`jam_selesai` AS `jam_selesai`,`kls`.`ruangan` AS `ruangan`,`kls`.`kuota` AS `kuota`,`kls`.`id_dosen_koor` AS `id_dosen_koor`,`kls`.`id_dosen_pendamping` AS `id_dosen_pendamping`,`d`.`nama_lengkap` AS `nama_dosen`,`d2`.`nama_lengkap` AS `nama_dosen_pendamping`,(select count(0) from `krs` where (`krs`.`id_kelas` = `kls`.`id_kelas`)) AS `kuota_terisi`,(`kls`.`kuota` - (select count(0) from `krs` where (`krs`.`id_kelas` = `kls`.`id_kelas`))) AS `sisa_kuota` from (((`kelas` `kls` join `matakuliah` `mk` on((`kls`.`id_mk` = `mk`.`id_mk`))) left join `dosen` `d` on((`kls`.`id_dosen_koor` = `d`.`nip`))) left join `dosen` `d2` on((`kls`.`id_dosen_pendamping` = `d2`.`nip`))) order by `mk`.`nama_mk`,`kls`.`id_kelas`;

-- ------------------------------------------
-- View: `getdosenpembimbing`
-- ------------------------------------------
DROP VIEW IF EXISTS `getdosenpembimbing`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getdosenpembimbing` AS select `d`.`nama_lengkap` AS `nama_lengkap`,`d`.`nip` AS `nip` from (`mahasiswa` `m` join `dosen` `d` on((`m`.`nip_pembimbing` = `d`.`nip`)));

-- ------------------------------------------
-- View: `getmahasiswadosen`
-- ------------------------------------------
DROP VIEW IF EXISTS `getmahasiswadosen`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getmahasiswadosen` AS select `m`.`nim` AS `id`,`m`.`nama_lengkap` AS `nama_lengkap`,`u`.`role` AS `role` from (`mahasiswa` `m` join `user` `u` on((`m`.`nim` = `u`.`username`))) union all select `d`.`nip` AS `id`,`d`.`nama_lengkap` AS `nama_lengkap`,`u`.`role` AS `role` from (`dosen` `d` join `user` `u` on((`d`.`nip` = `u`.`username`)));

-- ------------------------------------------
-- View: `view_user_akademik`
-- ------------------------------------------
DROP VIEW IF EXISTS `view_user_akademik`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_akademik` AS select `mahasiswa`.`nim` AS `id`,`mahasiswa`.`nama_lengkap` AS `nama_lengkap`,'mahasiswa' AS `role` from `mahasiswa` union all select `dosen`.`nip` AS `id`,`dosen`.`nama_lengkap` AS `nama_lengkap`,'dosen' AS `role` from `dosen`;

-- Procedure: `ambil_krs`
DROP PROCEDURE IF EXISTS `ambil_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ambil_krs`(IN `p_nim` VARCHAR(20), IN `p_id_kelas` VARCHAR(20), OUT `p_status` BOOLEAN)
BEGIN
    DECLARE v_kuota INT;
    DECLARE v_terisi INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
    	SET p_status = false;
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT kuota INTO v_kuota
    FROM kelas
    WHERE id_kelas = p_id_kelas
    FOR UPDATE;

    SELECT COUNT(*) INTO v_terisi
    FROM krs
    WHERE id_kelas = p_id_kelas
    FOR UPDATE;

    IF v_terisi >= v_kuota THEN
        SET p_status = false;
        ROLLBACK;
    ELSE
        INSERT INTO krs (nim, id_kelas, updated_at)
        VALUES (p_nim, p_id_kelas, NOW());

        COMMIT;
        SET p_status = true;
    END IF;
END;;
DELIMITER ;

-- Procedure: `edit_mk`
DROP PROCEDURE IF EXISTS `edit_mk`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_mk`(IN `p_id_mk` VARCHAR(10), IN `p_nama_mk` VARCHAR(200), IN `p_sks` INT)
BEGIN 
	UPDATE matakuliah SET 
    nama_mk = p_nama_mk, sks = p_sks 
    WHERE id_mk = p_id_mk;
END;;
DELIMITER ;

-- Procedure: `get_all_krs`
DROP PROCEDURE IF EXISTS `get_all_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_krs`(IN `p_nim` CHAR(20))
BEGIN
    SELECT 
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

        COALESCE(k.status, 'belum diambil') AS status,
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
    JOIN mahasiswa m ON m.nim = p_nim
    LEFT JOIN krs k 
        ON k.id_kelas = kls.id_kelas 
        AND k.nim = p_nim;

END;;
DELIMITER ;

-- Procedure: `get_info_admin`
DROP PROCEDURE IF EXISTS `get_info_admin`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_info_admin`()
BEGIN
	SELECT 
    (SELECT COUNT(*) as total_dosen FROM dosen) as  total_dosen,
    (SELECT COUNT(*) as total_mk FROM matakuliah) as total_mk,
    (SELECT COUNT(*) as total_kelas FROM kelas) as total_kelas,
    COUNT(*) as total_mahasiswa FROM mahasiswa;
END;;
DELIMITER ;

-- Procedure: `get_info_dosen`
DROP PROCEDURE IF EXISTS `get_info_dosen`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_info_dosen`(IN `p_nip` VARCHAR(20))
BEGIN

    SELECT 

        jumlah_mahasiswa_bimbingan(p_nip) AS total_mahasiswa_bimbingan,

        jumlah_krs_menunggu(p_nip) AS total_krs_menunggu,

        jumlah_matakuliah_diampu(p_nip) AS total_matakuliah_diampu;



END;;
DELIMITER ;

-- Procedure: `get_jadwal_dosen`
DROP PROCEDURE IF EXISTS `get_jadwal_dosen`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_jadwal_dosen`(IN `p_nip` VARCHAR(20))
BEGIN
    SELECT 
        kls.id_kelas,
        mk.id_mk,
        mk.nama_mk,
        mk.sks,
        kls.hari,
        kls.jam_mulai,
        kls.jam_selesai,
        kls.ruangan,
        (
            SELECT COUNT(*) 
            FROM krs k
            WHERE k.id_kelas = kls.id_kelas
        ) AS jumlah_mahasiswa
    FROM kelas kls
    JOIN matakuliah mk ON kls.id_mk = mk.id_mk
    WHERE kls.id_dosen_koor = p_nip
    ORDER BY 
        kls.hari ASC,
        kls.jam_mulai ASC;
END;;
DELIMITER ;

-- Procedure: `get_krs_dosen`
DROP PROCEDURE IF EXISTS `get_krs_dosen`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_krs_dosen`(IN `p_nip` VARCHAR(20))
BEGIN
    SELECT 
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

        d.nama_lengkap AS nama_dosen_pengampu,

        k.status,
        k.updated_at

    FROM krs k
    JOIN mahasiswa m ON k.nim = m.nim
    JOIN kelas kls ON k.id_kelas = kls.id_kelas
    JOIN matakuliah mk ON kls.id_mk = mk.id_mk
    JOIN dosen d ON kls.id_dosen_koor = d.nip

    WHERE m.nip_pembimbing = p_nip;

END;;
DELIMITER ;

-- Procedure: `get_my_krs`
DROP PROCEDURE IF EXISTS `get_my_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_my_krs`(IN `p_nim` VARCHAR(20))
BEGIN
    SELECT 
        k.nim,
        m.nama_lengkap AS nama_mahasiswa,

        mk.id_mk,
        mk.nama_mk,
        mk.sks,

        kls.id_kelas,
        kls.hari,
        kls.jam_mulai,
        kls.jam_selesai,
        kls.ruangan,

        d.nama_lengkap AS nama_dosen,

        k.status,
        k.updated_at

    FROM krs k
    JOIN mahasiswa m ON k.nim = m.nim
    JOIN kelas kls ON k.id_kelas = kls.id_kelas
    JOIN matakuliah mk ON kls.id_mk = mk.id_mk
    JOIN dosen d ON kls.id_dosen_koor = d.nip

    WHERE k.nim = p_nim;
END;;
DELIMITER ;

-- Procedure: `hapus_krs`
DROP PROCEDURE IF EXISTS `hapus_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_krs`(IN `p_nim` VARCHAR(20), IN `p_id_kelas` VARCHAR(20), OUT `p_status` BOOLEAN)
BEGIN
    DECLARE cek_krs INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_status = false;
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT COUNT(*) INTO cek_krs
    FROM krs
    WHERE nim = p_nim AND id_kelas = p_id_kelas
    FOR UPDATE;

    IF cek_krs = 0 THEN
        SET p_status = false;
        ROLLBACK;
    ELSE
        DELETE FROM krs
        WHERE nim = p_nim AND id_kelas = p_id_kelas;

        COMMIT;
        SET p_status = true;
    END IF;

END;;
DELIMITER ;

-- Procedure: `hapus_mk`
DROP PROCEDURE IF EXISTS `hapus_mk`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_mk`(IN `p_id_mk` VARCHAR(10))
BEGIN
	DELETE FROM matakuliah WHERE id_mk = p_id_mk;
END;;
DELIMITER ;

-- Procedure: `register`
DROP PROCEDURE IF EXISTS `register`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `register`(IN `p_username` VARCHAR(100), IN `p_nama_lengkap` VARCHAR(100), IN `p_password` VARCHAR(255), IN `p_role` ENUM('mahasiswa','dosen','admin'), OUT `p_status` BOOLEAN)
BEGIN
    DECLARE user_count INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_status = FALSE;
    END;

    START TRANSACTION;

    SELECT COUNT(*) INTO user_count 
    FROM `user` 
    WHERE username = p_username;
    
    IF user_count > 0 THEN
        SET p_status = FALSE;
        ROLLBACK;
    ELSE
        INSERT INTO `user` (username, password, role) 
        VALUES (p_username, p_password, p_role);

        IF p_role = 'mahasiswa' THEN
            INSERT INTO mahasiswa (nim, nama_lengkap) 
            VALUES (p_username, p_nama_lengkap);
        ELSEIF p_role = 'dosen' THEN 
            INSERT INTO dosen (nip, nama_lengkap) 
            VALUES (p_username, p_nama_lengkap);
        END IF;

        COMMIT;
        SET p_status = TRUE;
    END IF;

END;;
DELIMITER ;

-- Procedure: `tambah_kelas`
DROP PROCEDURE IF EXISTS `tambah_kelas`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_kelas`(IN `p_id_kelas` VARCHAR(20), IN `p_id_mk` VARCHAR(10), IN `p_dosen_koor` VARCHAR(20), IN `p_dosen_pendamping` VARCHAR(20), IN `p_hari` INT, IN `p_jam_mulai` TIME, IN `p_jam_selesai` TIME, IN `p_ruangan` VARCHAR(100), IN `p_kuota` INT, OUT `p_status` BOOLEAN)
BEGIN
    DECLARE v_exist INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_status = false;
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT COUNT(*) INTO v_exist
    FROM kelas
    WHERE id_kelas = p_id_kelas
    FOR UPDATE;

    IF v_exist > 0 THEN
        SET p_status = false;
        ROLLBACK;
    END IF;

    IF p_jam_mulai >= p_jam_selesai THEN
        SET p_status = false;
        ROLLBACK;
    END IF;

    IF p_kuota <= 0 THEN
        SET p_status = false;
        ROLLBACK;
    END IF;

    INSERT INTO kelas (
        id_kelas,
        id_mk,
        id_dosen_koor,
        id_dosen_pendamping,
        hari,
        jam_mulai,
        jam_selesai,
        ruangan,
        kuota
    ) VALUES (
        p_id_kelas,
        p_id_mk,
        p_dosen_koor,
        NULLIF(p_dosen_pendamping, ''),
        p_hari,
        p_jam_mulai,
        p_jam_selesai,
        p_ruangan,
        p_kuota
    );

    COMMIT;
    SET p_status = true;

END;;
DELIMITER ;

-- Procedure: `tambah_mk`
DROP PROCEDURE IF EXISTS `tambah_mk`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_mk`(IN `p_id_mk` VARCHAR(10), IN `p_nama_mk` VARCHAR(100), IN `p_sks` INT, OUT `p_status` BOOLEAN)
BEGIN
    DECLARE v_exist INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_status = false;
        ROLLBACK;
    END;

    START TRANSACTION;
    IF p_sks < 1 OR p_sks > 6 THEN
        SET p_status = false;
        ROLLBACK;
    END IF;

    SELECT COUNT(*) INTO v_exist
    FROM matakuliah
    WHERE id_mk = p_id_mk
    FOR UPDATE;

    IF v_exist > 0 THEN
        SET p_status = false;
        ROLLBACK;
    END IF;

    INSERT INTO matakuliah (id_mk, nama_mk, sks)
    VALUES (p_id_mk, p_nama_mk, p_sks);

    COMMIT;
    SET p_status = true;

END;;
DELIMITER ;

-- Procedure: `update_kelas`
DROP PROCEDURE IF EXISTS `update_kelas`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_kelas`(IN `p_hari` INT, IN `p_jam_mulai` TIME, IN `p_jam_selesai` TIME, IN `p_ruangan` VARCHAR(200), IN `p_kuota` INT, IN `p_id_dosen_koor` VARCHAR(20), IN `p_id_dosen_pendamping` VARCHAR(20), IN `p_id_kelas` VARCHAR(20))
BEGIN 
	UPDATE kelas SET 
    hari = p_hari, 
    jam_mulai = p_jam_mulai, 
    jam_selesai = p_jam_selesai, 
    ruangan = p_ruangan, 
    kuota = p_kuota, 
    id_dosen_koor = p_id_dosen_koor, 
    id_dosen_pendamping = p_id_dosen_pendamping 
    WHERE id_kelas = p_id_kelas;
END;;
DELIMITER ;

-- Procedure: `update_krs`
DROP PROCEDURE IF EXISTS `update_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_krs`(IN `p_id_krs` INT, IN `p_id_mk` INT)
BEGIN
    UPDATE krs
    SET id_mk = p_id_mk
    WHERE id_krs = p_id_krs;
END;;
DELIMITER ;

-- Procedure: `validasi_krs_mahasiswa`
DROP PROCEDURE IF EXISTS `validasi_krs_mahasiswa`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `validasi_krs_mahasiswa`(IN `p_nim` VARCHAR(20), IN `p_nip` VARCHAR(20), IN `p_status_krs` ENUM('disetujui','ditolak'), OUT `p_status` BOOLEAN)
BEGIN
    DECLARE v_valid INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_status = false;
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT COUNT(*) INTO v_valid
    FROM mahasiswa
    WHERE nim = p_nim 
    AND nip_pembimbing = p_nip
    FOR UPDATE;

    IF v_valid = 0 THEN
        SET p_status = false;
        ROLLBACK;
    ELSE
        UPDATE krs
        SET status = p_status_krs,
            updated_at = NOW()
        WHERE nim = p_nim;

        COMMIT;
        SET p_status = true;
    END IF;

END;;
DELIMITER ;

-- Function: `jumlah_krs_menunggu`
DROP FUNCTION IF EXISTS `jumlah_krs_menunggu`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_krs_menunggu`(`p_nip` VARCHAR(20)) RETURNS int
    READS SQL DATA
    DETERMINISTIC
BEGIN

   DECLARE jumlah_mahasiswa INT;

   SELECT COUNT(DISTINCT m.nim) INTO jumlah_mahasiswa 

            FROM krs k

            JOIN mahasiswa m ON k.nim = m.nim

            WHERE m.nip_pembimbing = p_nip

            AND k.status = 'menunggu';

   RETURN jumlah_mahasiswa;

END;;
DELIMITER ;

-- Function: `jumlah_mahasiswa_bimbingan`
DROP FUNCTION IF EXISTS `jumlah_mahasiswa_bimbingan`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_mahasiswa_bimbingan`(`p_nip` VARCHAR(20)) RETURNS int
    READS SQL DATA
    DETERMINISTIC
BEGIN

   DECLARE jumlah_mahasiswa INT;



   SELECT COUNT(*) INTO jumlah_mahasiswa 

   FROM mahasiswa 

   WHERE nip_pembimbing = p_nip;

   

   RETURN jumlah_mahasiswa;

END;;
DELIMITER ;

-- Function: `jumlah_matakuliah_diampu`
DROP FUNCTION IF EXISTS `jumlah_matakuliah_diampu`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_matakuliah_diampu`(`p_nip` VARCHAR(20)) RETURNS int
    READS SQL DATA
    DETERMINISTIC
BEGIN

   DECLARE jumlah_matakuliah INT;

   SELECT COUNT(DISTINCT kls.id_mk) INTO jumlah_matakuliah

            FROM kelas kls

            WHERE kls.id_dosen_koor = p_nip OR kls.id_dosen_koor = p_nip;

   RETURN jumlah_matakuliah;

END;;
DELIMITER ;

-- Function: `jumlah_sks`
DROP FUNCTION IF EXISTS `jumlah_sks`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_sks`(`p_nim` VARCHAR(20)) RETURNS int
    READS SQL DATA
    DETERMINISTIC
BEGIN
    DECLARE total_sks INT;

    SELECT COALESCE(SUM(mk.sks), 0) INTO total_sks
    FROM krs k
    JOIN kelas kls ON k.id_kelas = kls.id_kelas
    JOIN matakuliah mk ON kls.id_mk = mk.id_mk
    WHERE k.nim = p_nim;

    RETURN total_sks;
END;;
DELIMITER ;

-- Function: `status_krs`
DROP FUNCTION IF EXISTS `status_krs`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `status_krs`(`p_nim` CHAR(10)) RETURNS varchar(20) CHARSET utf8mb4
    READS SQL DATA
    DETERMINISTIC
BEGIN

   DECLARE v_status_krs VARCHAR(20);



   SELECT status

   INTO v_status_krs

   FROM krs

   WHERE nim = p_nim

   LIMIT 1;



   RETURN v_status_krs;

END;;
DELIMITER ;

-- Trigger: `trigger_after_insert_krs`
DROP TRIGGER IF EXISTS `trigger_after_insert_krs`;
DELIMITER ;;
CREATE TRIGGER `trigger_after_insert_krs` AFTER INSERT ON `krs` FOR EACH ROW
BEGIN

    DECLARE new_sks INT;



    SELECT m.sks INTO new_sks 

    FROM kelas k

    JOIN matakuliah m ON k.id_mk = m.id_mk

    WHERE k.id_kelas = NEW.id_kelas;



    UPDATE mahasiswa 

    SET sks = sks + IFNULL(new_sks, 0)

    WHERE nim = NEW.nim;

    

END;;
DELIMITER ;

-- Trigger: `trigger_afterr_delete_krs`
DROP TRIGGER IF EXISTS `trigger_afterr_delete_krs`;
DELIMITER ;;
CREATE TRIGGER `trigger_afterr_delete_krs` AFTER DELETE ON `krs` FOR EACH ROW
BEGIN

    DECLARE new_sks INT;



    SELECT m.sks INTO new_sks 

    FROM kelas k

    JOIN matakuliah m ON k.id_mk = m.id_mk

    WHERE k.id_kelas = OLD.id_kelas;



    UPDATE mahasiswa 

    SET sks = sks - IFNULL(new_sks, 0)

    WHERE nim = OLD.nim;

END;;
DELIMITER ;

SET FOREIGN_KEY_CHECKS=1;
-- ========================================
-- Backup selesai: 2026-06-05 14:11:38
-- ========================================
