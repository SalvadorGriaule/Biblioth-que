<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/css/out.css">
    <script type="module" src="./asset/js/script.js" defer></script>
    <title>Document</title>
</head>

<body>
    <header class="py-1 px-2 flex justify-between items-center bg-orange-300">
        <h1 class="text-amber-900 text-2xl"><a href="./index.php">Bilbiothéque</a></h1>
        <nav>
            <ul id="menu" class="flex space-x-2">
                <?php if (!empty($_SESSION["mail"])): ?>
                    <li><a class="text-amber-900" href="./profile?id_employer=<?php $_SESSION["id"] ?>">profile</a></li>
                    <li><a class="text-amber-900" href="./deconnect.php">Déconnection</a></li>
                    <li><a class="text-amber-900" href="./pdo.php">Base</a></li>
                    <?php else: ?>
                    <li><a class="text-amber-900" href="./signup.php">Inscription</a></li>
                    <li><a class="text-amber-900" href="./connect.php">Connection</a></li>
                <?php endif ?>
            </ul>

        </nav>
    </header>