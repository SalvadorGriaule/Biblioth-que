<?php
$pdo = new PDO("mysql:host=localhost;dbname=bibliotheque","root","pass1234!");

$read = $pdo->query('SELECT * FROM livre');
$result = $read->fetchAll();
