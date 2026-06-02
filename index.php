<?php

if(empty(session_id())) session_start();

require_once "./app/init.php";
if(file_exists('./app/core/App.php')) {
    require_once './app/core/App.php';
    new App();
} else {
    die("File App.php tidak ditemukan");
}