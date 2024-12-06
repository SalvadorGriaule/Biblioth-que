<?php
$pdo = new PDO("mysql:host=localhost;dbname=bibliotheque","root2","pass");

$read = $pdo->query('SELECT * FROM livre');
$result = $read->fetchAll();
