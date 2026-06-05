<?php

if(empty(session_id())) session_start();

require_once "./app/init.php";

if (file_exists('./app/model/Backup_model.php')) {
    require_once './app/model/Backup_model.php';
    $backupModel = new Backup_model();
    $backupModel->checkDanJalankanBackupOtomatis();
}

if(file_exists('./app/core/App.php')) {
    require_once './app/core/App.php';
    new App();
} else {
    die("File App.php tidak ditemukan");
}