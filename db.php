<?php
$pdo = new PDO("mysql:host=localhost;dbname=entreprise","root","pass1234!");

$read = $pdo->query('SELECT * FROM employes');
$result = $read->fetchAll();
