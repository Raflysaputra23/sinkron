<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?? 'Dashboard' ?> | Siakrs</title>
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?= CONSTANT::DIRNAME ?>/css/output.css">
    <!-- FONT POPPINS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=BBH+Hegarty&family=Bebas+Neue&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap"
        rel="stylesheet">
    <!-- ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- SWEETALERT -->
    <link rel="stylesheet" href="<?= CONSTANT::DIRNAME ?>tools/swetalert/sweetalert2.min.css">
    <script src="<?= CONSTANT::DIRNAME ?>tools/swetalert/sweetalert2.all.min.js"></script>
</head>

<body class="antialiased h-dvh <?= $data["title"] == "Login" || $data["title"] == "Register" ? "overflow-y-auto" : "overflow-hidden flex" ?>">
<?= Flasher::getFlash() ?>
    